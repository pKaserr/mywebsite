<?php
/**
 * Admin: Manage User ↔ Document relations
 * - Lists all users and documents
 * - Allows choosing a user and toggling assigned documents
 * - Persists changes into pivot table `user_documents`
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db_connect.php';

// Ensure admin role
$sql = "SELECT role FROM user WHERE user_name = :user_name";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_name', $_SESSION['user_name'], PDO::PARAM_STR);
$stmt->execute();
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$currentUser || $currentUser['role'] !== 'admin') {
    header('Location: ../dashboard');
    exit;
}

// CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Fetch all users.
 */
function fetchAllUsers(PDO $pdo): array {
    $stmt = $pdo->prepare('SELECT user_id, user_name FROM user ORDER BY user_name');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

/**
 * Fetch all documents.
 */
function fetchAllDocuments(PDO $pdo): array {
    $stmt = $pdo->prepare('SELECT file_id, file_name, file_url, file_size FROM documents ORDER BY file_name');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}

/**
 * Fetch assigned document ids for a user.
 */
function fetchAssignedDocumentIds(PDO $pdo, int $userId): array {
    $stmt = $pdo->prepare('SELECT document_id FROM user_documents WHERE user_id = :uid');
    $stmt->execute([':uid' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN) ?: [];
}

/**
 * Replace assignments for a user with the provided document ids.
 */
function replaceAssignments(PDO $pdo, int $userId, array $documentIds): void {
    $pdo->beginTransaction();
    try {
        $del = $pdo->prepare('DELETE FROM user_documents WHERE user_id = :uid');
        $del->execute([':uid' => $userId]);

        if (!empty($documentIds)) {
            $ins = $pdo->prepare('INSERT INTO user_documents (user_id, document_id) VALUES (:uid, :did)');
            foreach ($documentIds as $docId) {
                if (!is_numeric($docId)) continue;
                $ins->execute([':uid' => $userId, ':did' => (int)$docId]);
            }
        }

        $pdo->commit();
    } catch (Throwable $t) {
        $pdo->rollBack();
        throw $t;
    }
}

$users = fetchAllUsers($pdo);
$documents = fetchAllDocuments($pdo);

// Determine selected user
$selectedUserId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if ($selectedUserId === 0 && !empty($users)) {
    $selectedUserId = (int)$users[0]['user_id'];
}

$message = '';
$messageType = 'info';

// Handle POST (update assignments)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        http_response_code(400);
        die('Ungültiger CSRF-Token.');
    }

    $targetUserId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $selectedDocs = isset($_POST['documents']) && is_array($_POST['documents']) ? $_POST['documents'] : [];

    try {
        replaceAssignments($pdo, $targetUserId, $selectedDocs);
        $message = 'Zuweisungen erfolgreich aktualisiert.';
        $messageType = 'success';
        // Keep selection on the same user
        $selectedUserId = $targetUserId;
    } catch (Throwable $e) {
        $message = 'Fehler beim Aktualisieren: ' . htmlspecialchars($e->getMessage());
        $messageType = 'error';
    }
}

// Load current assignments for selected user
$assignedIds = $selectedUserId ? fetchAssignedDocumentIds($pdo, $selectedUserId) : [];

?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – Zuweisungen</title>
  <link rel="stylesheet" href="../style.css" />
  <link rel="icon" type="image/png" href="../assets/favicons/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="../assets/favicons/favicon.svg" />
  <link rel="shortcut icon" href="../assets/favicons/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicons/apple-touch-icon.png" />
  <link rel="manifest" href="../assets/favicons/site.webmanifest" />
</head>
<body>
  <div class="nav">
    <a href="../logout"><button class="btn btn--main btn--nav">Abmelden</button></a>
    <a href="../dashboard"><button class="btn btn--main btn--nav">Zurück</button></a>
  </div>

  <div class="container_dashboard">
    <h1>Zuweisungen verwalten</h1>

    <?php if ($message): ?>
      <p class="mb-4"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

      <form method="get" action="relations.php" class="mb-6">
      <label for="user_id">User auswählen:</label>
      <select id="user_id" name="user_id" onchange="this.form.submit()">
        <?php foreach ($users as $u): ?>
          <option value="<?= (int)$u['user_id'] ?>" <?= (int)$u['user_id'] === $selectedUserId ? 'selected' : '' ?>>
            <?= htmlspecialchars($u['user_name']) ?> (ID: <?= (int)$u['user_id'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </form>

    <?php if ($selectedUserId): ?>
      <form method="post" action="relations.php?user_id=<?= (int)$selectedUserId ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" />
        <input type="hidden" name="user_id" value="<?= (int)$selectedUserId ?>" />
        <!--
          Changed from grid to list view for document assignment.
          Uses a simple <ul> for better overview and accessibility.
        -->
        <ul class="assignment-list">
          <?php foreach ($documents as $doc): ?>
            <li class="assignment-list__item">
              <label class="assignment-list__label">
                <input
                  type="checkbox"
                  name="documents[]"
                  value="<?= (int)$doc['file_id'] ?>"
                  <?= in_array($doc['file_id'], $assignedIds, true) ? 'checked' : '' ?>
                  class="assignment-list__checkbox"
                />
                <span class="assignment-list__info">
                  <span class="assignment-list__title"><?= htmlspecialchars($doc['file_name']) ?></span>
                  <span class="assignment-list__meta">
                    ID: <?= (int)$doc['file_id'] ?> · Größe: <?= (int)$doc['file_size'] ?> KB
                  </span>
                </span>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>

        <div class="mt-6">
          <button class="btn btn--main" type="submit">Zuweisungen speichern</button>
          <a class="btn btn--secondary" href="relations.php?user_id=<?= (int)$selectedUserId ?>">Zurücksetzen</a>
        </div>
      </form>
    <?php endif; ?>

    <hr />

    <h2>Aktuelle Zuweisungen (Übersicht)</h2>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>User</th>
            <th>Dokumente (IDs)</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
            <?php $ids = fetchAssignedDocumentIds($pdo, (int)$u['user_id']); ?>
            <tr>
              <td>
                <?= htmlspecialchars($u['user_name']) ?> (<?= (int)$u['user_id'] ?>)
              </td>
              <td>
                <?= $ids ? htmlspecialchars(implode(', ', array_map('intval', $ids))) : '—' ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>



<?php
// session_start();
require './includes/auth.php';
require './includes/db_connect.php';
require_once './includes/utils.php';

if (!isset($_POST['ai_prompt'])) {
   $sql = "SELECT role FROM user WHERE user_name = :user_name";
   $stmt = $pdo->prepare($sql);
   $stmt->bindParam(':user_name', $_SESSION['user_name'], PDO::PARAM_STR);
   $stmt->execute();
   $user = $stmt->fetch(PDO::FETCH_ASSOC);

   /**
    * Check user access and show error message if access is denied.
    * If the user is nicht eingeloggt oder admin, zeige eine Fehlermeldung im Frontend.
    */
   if ($user['role'] !== 'admin') {
      header('Location: dashboard');
      exit;
   }


   // CSRF-Schutz vorbereiten
   if (!isset($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
   }

   // Verarbeite das Formular, wenn es abgeschickt wurde
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Überprüfe CSRF-Token
      if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
         die("Ungültiger CSRF-Token.");
      }

      // Eingaben validieren und bereinigen
      $company_name = htmlspecialchars(trim($_POST['company_name']));
      $company_email = filter_var($_POST['company_email'], FILTER_SANITIZE_EMAIL);
      $company_password = $_POST['company_password']; // Wird später gehasht
      $company_job_desc = htmlspecialchars(trim($_POST['company_job_desc']));
      $company_initial_apply = isset($_POST["company_initial_apply"]) ? 1 : 0;


      // Validierung der Eingaben
      if (empty($company_name) || empty($company_email) || empty($company_password)) {
         die("Benutzername, E-Mail und Passwort dürfen nicht leer sein.");
      }

      if (!filter_var($company_email, FILTER_VALIDATE_EMAIL)) {
         die("Ungültige E-Mail-Adresse.");
      }

      // Passwort-Hashing
      $hashed_password = password_hash($company_password, PASSWORD_DEFAULT);
      $file_hash = randomHash(20);

      try {
         // add user
         $sql = "
               INSERT INTO user (user_name, email, passwort, job_desc, initial_apply, role, file_hash)
               VALUES (:company_name, :company_email, :company_password, :company_job_desc, :company_initial_apply, 'user', :file_hash)
            ";
         $stmt = $pdo->prepare($sql);

         $stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
         $stmt->bindParam(':company_email', $company_email, PDO::PARAM_STR);
         $stmt->bindParam(':company_password', $hashed_password, PDO::PARAM_STR);
         $stmt->bindParam(':company_job_desc', $company_job_desc, PDO::PARAM_STR);
         $stmt->bindParam(':company_initial_apply', $company_initial_apply, PDO::PARAM_STR);
         $stmt->bindParam(':file_hash', $file_hash, PDO::PARAM_STR);
         $stmt->execute();

         // add document
         $file_name = $_FILES["file"]["name"];
         $file_size = round($_FILES["file"]["size"] / 1024);
         $target_dir = "downloads/protected/motivation/";
         $target_file = $target_dir . basename($file_name);
         $target_url = "/" . $target_dir . basename($file_name);

         try {
            $sql = "
               INSERT INTO documents (file_name, file_desc, file_url, file_size, file_hash, common_file)
               VALUES (:file_name, 'Motivationsschreiben für die Bewerbung', :target_url, :file_size, :file_hash, 0)
               ";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':file_name', $file_name, PDO::PARAM_STR);
            $stmt->bindParam(':target_url', $target_url, PDO::PARAM_STR);
            $stmt->bindParam(':file_size', $file_size, PDO::PARAM_INT);
            $stmt->bindParam(':file_hash', $file_hash, PDO::PARAM_STR);
            $stmt->execute();
            move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
         } catch (PDOException $e) {
            die("Fehler beim Hinzufügen des Users: " . $e->getMessage());
         }

         // add user_documents
         $user_id_query = $pdo->prepare("SELECT user_id FROM user WHERE user_name = :company_name");
         $user_id_query->execute([':company_name' => $company_name]);
         $user_id = $user_id_query->fetchColumn();

         $file_ids_query = $pdo->prepare("SELECT file_id FROM documents WHERE common_file = 1 OR file_hash = :file_hash");
         $file_ids_query->execute([':file_hash' => $file_hash]);

         $file_ids = $file_ids_query->fetchAll(PDO::FETCH_COLUMN);

         $insert_stmt = $pdo->prepare("INSERT INTO user_documents (user_id, document_id) VALUES (:user_id, :document_id)");
         foreach ($file_ids as $document_id) {
            $insert_stmt->execute([
               ':user_id' => $user_id,
               ':document_id' => $document_id,
            ]);
         }
      } catch (PDOException $e) {
         die("Fehler beim Hinzufügen des User-Dokuments: " . $e->getMessage());
      }
   }
   try {
      $stmt = $pdo->prepare("SELECT user_name, user_id FROM user");
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
   } catch (PDOException $e) {
      die("Fehler beim Hinzufügen des Dokuments: " . $e->getMessage());
   }
}
$pw = randomHash(8);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Unternehmen Hinzufügen</title>
   <script src="./js/add_comp.js" defer></script>
   <script src="./js/chat.js" defer></script>
   <link rel="stylesheet" href="./style.css">
   <link rel="icon" type="image/png" href="./assets/favicons/favicon-96x96.png" sizes="96x96" />
   <link rel="icon" type="image/svg+xml" href="./assets/favicons/favicon.svg" />
   <link rel="shortcut icon" href="./assets/favicons/favicon.ico" />
   <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicons/apple-touch-icon.png" />
   <link rel="manifest" href="./assets/favicons/site.webmanifest" />
</head>

<body>
   <div class="nav">
      <a href="logout"><button class="btn btn--main btn--nav">Abmelden</button></a>
      <a href="dashboard"><button class="btn btn--main btn--nav">Zurück</button></a>
   </div>

   <div class="container_dashboard">
      <div style="margin-bottom: 30px; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
         <h3>Motivationsschreiben erstellen</h3>
         <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <textarea name="ai_prompt" style="width: 100%; height: 100px; padding: 10px; margin-bottom: 10px; resize: vertical;" placeholder="Hier die Stellenaussschreibung einfügen und go..."><?php echo isset($_POST['ai_prompt']) ? htmlspecialchars($_POST['ai_prompt']) : ''; ?></textarea>
            <button type="submit" name="run_python_test" class="btn btn--main">Anschreiben erstellen</button>
         </form>
         <?php
         if (isset($_POST['run_python_test']) && !empty($_POST['ai_prompt'])) {
            $prompt = $_POST['ai_prompt'];
            $script_path = __DIR__ . '/python/llm_api.py';

            if (file_exists($script_path)) {
               // Prepare command with proper escaping
               // Force UTF-8 encoding for input/output might be tricky on Windows shell, 
               // but basic execution should work.
               $command = "python " . escapeshellarg($script_path) . " " . escapeshellarg($prompt) . " 2>&1";
               $output = shell_exec($command);
            } else {
               echo "<p style='color: red; margin-top: 10px;'>Fehler: llm_api.py nicht gefunden unter $script_path</p>";
            }
         }
         ?>
      </div>
      
      <h1>Motivationsschreiben erstellen</h1>
      <form action="process_cover_note.php" method="post" class="form-style mb-4" style="width: 100%">
         <div class="form-group" style="margin-bottom: 15px;">
            <label for="p_salutation">Anrede:</label>
            <input type="text" id="p_salutation" name="p_salutation" required class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;" value="Sehr geehrte[r] [###], sehr geehrte Damen und Herren">
         </div>

         <div class="form-group">
            <label for="p_text">Text:</label>
            <textarea id="p_text" name="p_text" required class="form-control" rows="10" style="width: 100%; padding: 8px; margin-top: 5px;" placeholder="Ihr Text hier..."><?php echo isset($_POST['ai_prompt']) ? htmlspecialchars($output) : ''; ?></textarea>
         </div>

         <div class="form-group" style="margin-bottom: 15px;">
            <label for="p_login">Login:</label>
            <input type="text" id="p_login" required name="p_login" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;" placeholder="Login-Name">
         </div>

         <div class="form-group" style="margin-bottom: 15px;">
            <label for="p_passwort">Passwort:</label>
            <input value="<?= htmlspecialchars($pw) ?>" type="text" id="p_passwort" name="p_passwort" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;" placeholder="Passwort">
         </div>

         <div class="form-group" style="margin-bottom: 15px;">
            <label for="format">Format wählen:</label>
            <select id="format" name="format" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;">
               <option value="docx">Word (.docx)</option>
               <!-- <option value="pdf">PDF (.pdf)</option> -->
               <!-- PDF generation might require more setup, enabling only Word for now unless I can confirm PDF works -->
            </select>
         </div>

         <button type="submit" class="btn btn--main">Dokument erstellen</button>
      </form>

      <h1>Lebenslauf Erstellen</h1>
      <form action="process_cv.php" method="post" class="form-style mb-4" style="width: 100%">
         <div class="form-group" style="margin-bottom: 15px;">
            <label for="p_login">Login:</label>
            <input type="text" id="p_login_cv" required name="p_login" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;" placeholder="Login-Name">
         </div>

         <div class="form-group" style="margin-bottom: 15px;">
            <label for="p_passwort">Passwort:</label>
            <input value="<?= htmlspecialchars($pw) ?>" type="text" id="p_passwort_cv" name="p_passwort" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;" placeholder="Passwort">
         </div>

         <button type="submit" class="btn btn--main">Dokument erstellen</button>
      </form>
      <h1>Unternehmen Hinzufügen</h1>
      <!-- Formular anzeigen -->
      <form action="add_comp" method="post" enctype="multipart/form-data">
         <!-- CSRF-Token als verstecktes Feld -->
         <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
         <label for="company_name">Benutzername:</label>
         <input type="text" id="company_name" name="company_name" required>
         <br>

         <label for="company_email">E-Mail:</label>
         <input value="no@email.de" type="email" id="company_email" name="company_email">
         <br>

         <label for="company_password">Passwort:</label>
         <input value="<?= htmlspecialchars($pw) ?>" type="text" id="company_password" name="company_password" required>
         <br>

         <label for="company_job_desc">Job-Beschreibung:</label>
         <input type="text" id="company_job_desc" name="company_job_desc" required>
         <br>

         <label for="company_initial_apply">Initial Apply:</label>
         <input type="checkbox" id="company_initial_apply" name="company_initial_apply">
         <br>

         <label for="file">Motivationsschreiben:</label>
         <input id="file" name="file" type="file" required />
         <br>

         <button type="submit">Hinzufügen</button>
      </form>
   </div>
</body>

</html>
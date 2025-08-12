<?php
// session_start();
require './includes/auth.php';
require './includes/db_connect.php';
require_once './includes/utils.php';

$sql = "SELECT role FROM user WHERE user_name = :user_name";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_name', $_SESSION['user_name'], PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user['role'] !== 'admin') {
   header('Location: dashboard');
   exit;
}

// Verarbeite das Formular, wenn es abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   // Überprüfe CSRF-Token
   if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
      die("Ungültiger CSRF-Token.");
   }
}

// get all user_name and user_id from user in database:
try {
   $stmt = $pdo->prepare("SELECT user_name, user_id FROM user");
   $stmt->execute();
   $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   die("Fehler bei der Datenbankabfrage: " . $e->getMessage());
}

// upload file
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $file = $_FILES['file'];
   $user = $_POST['user'];

   if ($file['error'] !== 0) {
      die("Fehler beim Upload.");
   }

   $file_name = $file['name'];
   $allowed = array('pdf', 'docx', 'doc', 'txt');
   
   // Validate file extension
   $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
   if (!in_array($file_extension, $allowed)) {
      die("Dateityp nicht erlaubt. Erlaubte Formate: " . implode(', ', $allowed));
   }

   // Create upload directory if it doesn't exist
   $upload_dir = "downloads/protected/basic/";
   if (!is_dir($upload_dir)) {
      if (!mkdir($upload_dir, 0755, true)) {
         die("Fehler beim Erstellen des Upload-Verzeichnisses.");
      }
   }

   // Generate unique filename to prevent conflicts
   /**
    * Check if the file name already exists in the upload directory.
    * If it exists, append a hash to the filename, otherwise use the original filename.
    */
   $base_filename = pathinfo($file_name, PATHINFO_FILENAME);
   $unique_filename = $base_filename . '.' . $file_extension;
   $upload_path = $upload_dir . $unique_filename;
   $file_hash = null;

   if (file_exists($upload_path)) {
      // If file exists, add hash to filename
      $file_hash = randomHash(15);
      $unique_filename = $base_filename . '_' . $file_hash . '.' . $file_extension;
      $upload_path = $upload_dir . $unique_filename;
   }

   $file_url = "/downloads/protected/basic/" . $unique_filename;
   $file_size = round($_FILES["file"]["size"] / 1024);

   // Move uploaded file to correct directory
   if (!move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path)) {
      die("Fehler beim Hochladen der Datei.");
   }

   // Insert into database
   $sql = "INSERT INTO `documents` (`file_name`, `file_desc`, `file_url`, `file_size`, `file_hash`, `uploaded_at`) VALUES (:file_name, :file_desc, :file_url, :file_size, :file_hash, :uploaded_at);";
   $stmt = $pdo->prepare($sql);
   $stmt->bindParam(':file_name', $file_name, PDO::PARAM_STR);
   $file_desc = isset($_POST['file_desc']) ? trim($_POST['file_desc']) : '';
   $stmt->bindParam(':file_desc', $file_desc, PDO::PARAM_STR);
   $stmt->bindParam(':file_url', $file_url, PDO::PARAM_STR);
   $stmt->bindParam(':file_size', $file_size, PDO::PARAM_INT);
   // Generate a hash for database storage (always needed for the database field)
   $db_file_hash = $file_hash ?? randomHash(15);
   $stmt->bindParam(':file_hash', $db_file_hash, PDO::PARAM_STR);
   $date = date('Y-m-d H:i:s');
   $stmt->bindParam(':uploaded_at', $date, PDO::PARAM_STR);
   
   if ($stmt->execute()) {
      echo "<script>alert('Datei erfolgreich hochgeladen!');</script>";
   } else {
      // If database insert fails, remove the uploaded file
      unlink($upload_path);
      die("Fehler beim Speichern in der Datenbank.");
   }
}
?>

<!DOCTYPE html>
<html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Unternehmen Hinzufügen</title>
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
         <h1>Unternehmen Hinzufügen</h1>
         <label for="motivation">Motivationsschreiben?</label>
         <input type="checkbox" id="motivation" name="motivation">

         <form action="add_file" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <label for="file">File</label>
            <input id="file" name="file" type="file" />
            <br>

            <label for="file_desc">Dateibeschreibung</label>
            <input id="file_desc" name="file_desc" type="text" placeholder="Beschreibung der Datei" />
            <br>

            <label for="add_company">Unternehmen hinzufügen?</label>
            <select name="user">
               <option value="false">False</option>
               <?php foreach ($users as $user) : ?>
                  <option value="<?= $user['user_id'] ?>"><?= $user['user_name'] ?></option>
               <?php endforeach; ?>
            </select> <br>

            <button type="submit">Upload</button>
         </form>
      </div>
   <script>
      el = '<select name="user"> <option value="false">False</option> <?php foreach ($users as $user) : ?><option value="<?= $user['user_id'] ?>"><?= $user['user_name'] ?></option><?php endforeach; ?> </select> <br>'
   </script>

   </body>
</html>
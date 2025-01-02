// Purpose: To log out the user and destroy the session.

<?php
session_start();
session_destroy();
header("Location: index.php");
exit();
?>

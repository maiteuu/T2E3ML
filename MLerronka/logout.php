<?php
session_start();
session_unset();    // Libera todas las variables de sesión
session_destroy();  // Destruye la sesión

// Te redirige a la página principal
header("Location: index.php");
exit();
?>
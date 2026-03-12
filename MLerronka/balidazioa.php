<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos los datos enviados por el formulario (loginform.php)
    $user_input = $_POST['usuario'];
    $pass_input = $_POST['contrasena'];

    // Cargamos el archivo XML que contiene los usuarios
    $xml = simplexml_load_file("users.xml");
    $login_success = false;

    // Recorremos cada nodo <usuario> buscando una coincidencia
    foreach ($xml->usuario as $user_node) {
        $xml_user = (string)$user_node->usuario;
        $xml_pass = (string)$user_node->contrasena;
        $xml_rol  = (string)$user_node['rol'];

        // Si el nombre y la contraseña coinciden con el XML
        if ($user_input === $xml_user && $pass_input === $xml_pass) {
            $_SESSION['usuario'] = $xml_user;
            $_SESSION['rol'] = $xml_rol;
            $login_success = true;
            break;
        }
    }

    if ($login_success) {
        // Si todo es correcto, entramos a la web
        header("Location: index.html"); 
        exit();
    } else {
        // Si hay error, volvemos al login con el aviso de error activado
        header("Location: loginform.php?error=1");
        exit();
    }
}
?>

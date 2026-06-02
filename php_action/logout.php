<?php
//Iniciamos session
session_start();
//Destuimos todas las variables de sesion
session_destroy();

//Redirigimos a rl inicio de sesion
header('Location: ../index.php');
exit();

?>
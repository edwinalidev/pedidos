<?php

session_start();
if(isset($_SESSION['idUser'])){
    $idUser=$_SESSION['idUser'];
    $tipoUser   = $_SESSION["tipo"];

}else{
// Redirige al usuario a una página de salida o a cualquier otra página que desees
header("Location: /");
exit(); // Asegura que el script se detenga después de redirigir
}

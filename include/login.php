<?php
session_start();
require_once("connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Email      = $_POST["Email"];
    $clave      = $_POST["password"];
    // Preparar la consulta SQL
    $stmt = $pdo->prepare("SELECT idUser,Email,password,usuario,tipo,phone,idSucursal FROM usuarios WHERE Email = :Email");
    
    // Bind de parámetros
    $stmt->bindParam(':Email', $Email, PDO::PARAM_STR);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Obtener el resultado
    if ($stmt->rowCount() > 0) {
        // Obtener los resultados en un array asociativo
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verificar la contraseña utilizando password_verify
        if (password_verify($clave, $result['password'])) {
            session_start();
            $_SESSION["idUser"]     = $result['idUser'];
            $_SESSION["usuario"]    = $result['usuario'];
            $_SESSION["tipo"]       = $result['tipo'];
            $_SESSION["idSucursal"] = $result['idSucursal'];
            header("Location: ../pedidos/pedidos.php"); // Redirige a la página de inicio después del login
            exit(); // Es importante salir después de redirigir
        } else {
           
            header("Location: ../"); // Redirige
            echo "password error";
            exit();
        }
    } else {
        header("Location: ../");
        echo "Usuario no valido ";
        exit();
    }  
    // Cerrar la conexión y liberar recursos

}
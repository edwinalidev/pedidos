<?php
header('Content-Type: text/html; charset=UTF-8');
header('Content-Type: application/json; charset=utf-8');
include("../../template/session.php");
include("../../include/connection.php");
$method=$_SERVER['REQUEST_METHOD'];
if($method==='POST'){
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try{

$Usuario        = $_POST['Usuario'];
//$Email          = $_POST['Email'];
$Phone          = $_POST['Phone'];
$Password       = $_POST['Password'];
$newPassword    = $_POST['newPassword'];

// Consulta para obtener la contraseña actual del usuario
$stmt = $pdo->prepare("SELECT password from usuarios where idUser = :idUser");
$stmt->bindParam(':idUser', $idUser);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Si el usuario existe, verifica la contraseña actual
    if (password_verify($Password, $result['password'])) {
        // La contraseña actual es correcta, actualiza la contraseña
        if (empty($newPassword)){
        $updateStmt = $pdo->prepare("UPDATE usuarios SET usuario=:usuario,phone=:phone WHERE idUser = :idUser");
        $updateStmt->bindParam(':usuario', $Usuario);
//        $updateStmt->bindParam(':email', $Email);
        $updateStmt->bindParam(':phone', $Phone);
        $updateStmt->bindParam(':idUser',$idUser);
        if ($updateStmt->execute()) {
            // Contraseña actualizada correctamente
            $response = array("status" => "success", "message" => "Datos actualizados correctamente");
        } else {
            // Error al actualizar la contraseña
            $response = array("status" => "error", "message" => "Error al actualizar los datos");
        }
        }else{
            $updateStmt = $pdo->prepare("UPDATE usuarios SET password=:newPassword,usuario=:usuario,phone=:phone WHERE idUser = :idUser");
            $newPassword=password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt->bindParam(':newPassword', $newPassword);
            $updateStmt->bindParam(':usuario', $Usuario);
 //           $updateStmt->bindParam(':email', $Email);
            $updateStmt->bindParam(':phone', $Phone);
            $updateStmt->bindParam(':idUser',$idUser);
            if ($updateStmt->execute()) {
                // Contraseña actualizada correctamente
                $response = array("status" => "success", "message" => "Contraseña actualizada correctamente");
            } else {
                // Error al actualizar la contraseña
                $response = array("status" => "error", "message" => "Error al actualizar la contraseña");
            }
        }

    } else {
        // La contraseña actual no es correcta
        $response = array("status" => "error", "message" => "Contraseña incorrecta");
    }
} else {
    // Usuario no encontrado
    $response = array("status" => "error", "message" => "Usuario no encontrado");
}
} catch(PDOException $e) {
// Error de conexión
$response = array("status" => "error", "message" => "Error de conexión: " . $e->getMessage());
}
echo json_encode($response);

}else if($method==='GET'){
    $send=$pdo->prepare("SELECT idUser,usuario,email,phone from usuarios where idUser=:idUser");
    $send->bindParam(':idUser',$idUser);
    $send->execute();
    $data=$send->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data,JSON_ERROR_UTF8);
}

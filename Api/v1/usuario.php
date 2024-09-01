<?php
include_once("../../include/connection.php");

function getUser($pdo,$idUser) {
    $sql="select usuario,email,phone,idUser from usuarios where idUser=:idUser";
    $send=$pdo->prepare($sql);
    $send->bindParam(':idUser',$idUser,PDO::PARAM_INT);
    $send->execute();
    $data=$send->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
    $pdo=null;
    $send=null;
}

function addUser($pdo, $Usuario, $Email, $Password, $Tipo, $Phone,$Estado){
    // Corregir los nombres de las columnas y quitar los dos puntos
 
    $Password = password_hash($Password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (usuario, password, estado, phone, email, tipo) VALUES (:usuario, :password, :estado, :phone, :email, :tipo)";
    $send = $pdo->prepare($sql);  
    // Corregir los nombres de las columnas en bindParam
    $send->bindParam(':usuario', $Usuario, PDO::PARAM_STR);
    $send->bindParam(':password', $Password, PDO::PARAM_STR);
    $send->bindParam(':phone', $Phone, PDO::PARAM_STR);
    $send->bindParam(':email', $Email, PDO::PARAM_STR);
    $send->bindParam(':tipo', $Tipo, PDO::PARAM_INT);
    $send->bindParam(':estado', $Estado, PDO::PARAM_INT);
    $send->execute();
    getUser($pdo);
}
function editUser( $pdo, $idUser, $usuario, $email, $password, $tipo, $phone,$estado){
    // Corregir los nombres de las columnas y quitar los dos puntos
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "update usuarios set usuario=:usuario,password=:password,estado=:estado, phone=:phone, email=:email, tipo=:tipo where idUser=:idUser ";
    $send = $pdo->prepare($sql);
    
    // Corregir los nombres de las columnas en bindParam
    $send->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $send->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $send->bindParam(':password', $password, PDO::PARAM_STR);
    $send->bindParam(':phone', $phone, PDO::PARAM_STR);
    $send->bindParam(':email', $email, PDO::PARAM_STR);
    $send->bindParam(':tipo', $tipo, PDO::PARAM_INT);    
    $send->bindParam(':estado', $estado, PDO::PARAM_INT); 
    $send->execute();
    getUser($pdo);
}
function setPassword($conn,$idUser,$Password){
    $Sql="update Usuarios set password=:Password where id=:idUser";
    $Send=$conn->prepare($Sql);
    $Send->bindParam(':$Password',$Password,PDO::PARAM_STR);
    $Send->bindParam(':idUser',$idUser,PDO::PARAM_INT);
    $Send->execute();
} 
function delUser($conn,$idUser){
    $Sql="delete from Usuarios where idUser=:idUser";
    $Send=$conn->prepare($Sql);
    $Send->bindParam(':idUser',$idUser,PDO::PARAM_INT);
    $Send->execute();
    getUser($conn);

}

if($_SERVER["REQUEST_METHOD"]=="GET"){
    getUser($pdo);
}else if($_SERVER["REQUEST_METHOD"]=="POST"){   
    $requestData = json_decode(file_get_contents("php://input"), true);
    $Usuario    =$requestData["Usuario"];
    $Email      =$requestData["Email"];
    $Password   =$requestData["Password"];
    $Phone      =$requestData["Phone"];
    $idUser=isset($requestData["idUser"])? $requestData["idUser"] :null;

    if($idUser==null){

        addUser($pdo,$Usuario,$Email,$Password,$Tipo,$Phone,$Estado);
    }else{
        editUser($pdo,$idUser,$Usuario,$Email,$Password,$Tipo,$Phone,$Estado);
    }
}else if($_SERVER["REQUEST_METHOD"]=='DELETE'){
    $requestData = json_decode(file_get_contents("php://input"), true);
    $idUser=$requestData["idUser"];
    delUser($pdo, $idUser);
    
   }
<?php

include("../../template/session.php");
function getData($pdo) {
    global $idUser,$tipoUser;
    if($tipoUser==1){
        $sql = "select idPedido,fecha,usuario,fecha2,monto,p.estado from pedidos p inner join usuarios u on p.idUser=u.idUser order by p.idPedido";
        $stmt = $pdo->prepare($sql);
    }else{
        $sql = "select idPedido,fecha,usuario,fecha2,monto,p.estado from pedidos p inner join usuarios u on p.idUser=u.idUser where p.idUser=:idUser order by p.idPedido";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);     
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

$data = json_decode(file_get_contents('php://input'), true);
if (empty($data)) {
    // Manejar el caso en que el JSON esté vacío
    echo "<h1>API REST. LOGIN </h1>";
} else {
    include_once("../../include/connection.php");
    $idPedido   =$data['pedidos']['idPedido'];
    $send=$pdo->prepare("delete from detalles where idPedido=:idPedido");
    $send->bindParam(':idPedido',$idPedido,PDO::PARAM_INT);
    $send->execute();
    if($idPedido==0){
        // Insertar datos en la tabla de pedidos
            $stmt = $pdo->prepare("INSERT INTO pedidos ( fecha, idUser, monto, estado, fecha2) VALUES (:fecha, :idUser, :monto, :estado, :fecha2)");
            $stmt->bindParam(':fecha', $data['pedidos']['fecha']);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->bindParam(':monto', $data['pedidos']['monto']);
            $stmt->bindParam(':estado', $data['pedidos']['estado']);
            $stmt->bindParam(':fecha2', $data['pedidos']['fecha2']);
            $stmt->execute();
            // Obtener el ID del pedido recién insertado
            $lastInsertId = $pdo->lastInsertId();
    }else{
        $stmt = $pdo->prepare("update pedidos set fecha=:fecha,monto=:monto,estado=:estado, fecha2=:fecha2 where idPedido=:idPedido");
        $stmt->bindParam(':fecha', $data['pedidos']['fecha']);
//        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':monto', $data['pedidos']['monto']);
        $stmt->bindParam(':estado', $data['pedidos']['estado']);
        $stmt->bindParam(':fecha2', $data['pedidos']['fecha2']);
        $stmt->bindParam(':idPedido', $idPedido,PDO::PARAM_INT);
        $stmt->execute();
        // Obtener el ID del pedido recién insertado
        $lastInsertId = $idPedido;

    }
    // Insertar detalles en la tabla de detalles
    foreach ($data['pedidos']['Detalles'] as $detalle) {
        $stmt = $pdo->prepare("INSERT INTO detalles (idPedido, idItem, Detalle, Precio,Cantidad) VALUES (:idPedido, :idItem, :Detalle, :Precio,:Cantidad)");
        $stmt->bindParam(':idPedido', $lastInsertId);
        $stmt->bindParam(':idItem', $detalle['idItem']);
        $stmt->bindParam(':Detalle', $detalle['Detalle']);
        $stmt->bindParam(':Precio', $detalle['Precio']);
        $stmt->bindParam(':Cantidad', $detalle['Cantidad']);
        $stmt->execute();
    }
    $response=array();
    $response['success'] = true;
    $response['message'] = "Datos ingresados correctamente.";
    $response['data']    = getData($pdo);
    echo json_encode($response);
    $pdo=null;
}


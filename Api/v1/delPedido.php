<?php
// Configuración de conexión a la base de datos
include_once("../../include/connection.php");
header("Content-type: application/json; charset=utf-8");
function getPedidos($pdo) {
    $sql = "select idPedido,fecha,usuario,fecha2,monto,p.estado from pedidos p inner join usuarios u on p.idUser=u.idUser  order by p.idPedido";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

function getPedidoDetalle($pdo,$idPedido) {
    // Endpoint para obtener la lista de pedidos con detalles
    $Sql="SELECT fecha,fecha2,estado from pedidos where idPedido=:idPedido";
    $Send=$pdo->prepare($Sql);
    $Send->bindParam(':idPedido',$idPedido,PDO::PARAM_INT);
    $Send->execute();
    $Pedido = [];
    $dataDetalle=[];
    $dataPedido=$Send->fetchAll(PDO::FETCH_ASSOC);
        foreach($dataPedido as $row)
        {
            $detalleStmt = $pdo->prepare("SELECT idItem,Detalle,Precio,Cantidad FROM detalles WHERE idPedido = :idPedido order by idDetalle ");
            $detalleStmt->bindParam(':idPedido',$idPedido,PDO::PARAM_INT);
            $detalleStmt->execute();
            $dataDetalle=$detalleStmt->fetchAll(PDO::FETCH_ASSOC);
            $Pedido []=[
                'idPedido'=>$idPedido,
                'fecha'=>$row['fecha'],
                'fecha2'=>$row['fecha2'],
                'Detalle'=>$dataDetalle];
        }
        echo json_encode($Pedido);
    
}
function deletePedido($pdo, $idPedido) {
    $sql = "select estado from pedidos where idPedido=:idPedido";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
    $stmt->execute();
    $estado = $stmt->fetchColumn();
    if($estado===1){    
        $sql = "delete from pedidos WHERE idPedido = :idPedido";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(['mensaje' => 'El pedido se eliminó correctamente']);
    }else{
        echo json_encode(['mensaje' => 'No se puede eliminar el pedido ya fue aceptado']);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $idPedido = isset($_GET["idPedido"]) ? $_GET["idPedido"] : null;
    getPedidoDetalle($pdo, $idPedido);
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $deleteParams);
    $idPedido = $deleteParams["idPedido"];
    deletePedido($pdo, $idPedido);
}
$pdo=null;
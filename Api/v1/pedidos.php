<?php
// Configuración de conexión a la base de datos
include_once "../../include/connection.php";
include_once "../../template/session.php";
function getPedidos()
{
    global $idUser, $tipoUser, $pdo;
    if ($tipoUser == 1) {
        $sql = "select idPedido,fecha,usuario,fecha2,monto,p.estado from pedidos p inner join usuarios u on p.idUser=u.idUser order by p.idPedido desc";
        $stmt = $pdo->prepare($sql);
    } else {
        $Sql = "select idPedido,fecha,usuario,fecha2,monto,p.estado from pedidos p inner join usuarios u on p.idUser=u.idUser where p.idUser=:idUser order by p.idPedido desc";
        $stmt = $pdo->prepare($Sql);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    }
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function getPedidoDetalle($pdo)
{
    // Endpoint para obtener la lista de pedidos con detalles
    $stmt = $pdo->query('SELECT idPedido,fecha,idUser,fecha2,monto,estado FROM pedidos');
    $pedidos = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $idPedido = $row['idPedido'];
        // Obtener detalles del pedido
        $detallesStmt = $pdo->prepare("SELECT * FROM detalles WHERE idPedido = :idPedido");
        $detallesStmt->bindParam(':idPedido', $idPedido);
        $detallesStmt->execute();
        $detalles = [];
        while ($detalleRow = $detallesStmt->fetch(PDO::FETCH_ASSOC)) {
            $detalles[] = [
                'idDetalle' => $detalleRow['idDetalle'],
                'idItem' => $detalleRow['idItem'],
                'detalle' => $detalleRow['Detalle'],
                'Precio' => $detalleRow['Precio'],
                'Cantidad' => $detalleRow['Cantidad'],
            ];
        }
        $pedidos[] = [
            'idPedido' => $idPedido,
            'fecha' => $row['fecha'],
            'idUser' => $row['idUser'],
            'fecha2' => $row['fecha2'],
            'Monto' => $row['idUser'],

            'Detalle' => $detalles,
        ];
    }
    echo json_encode($pedidos);
}

// Función para obtener un elemento por su ID
function getPedido($pdo, $idUser)
{

    $sql = "select idPedido,fecha,usuario,fecha2,monto,p.estado from pedidos p inner join usuarios u on p.idUser=u.idUser   WHERE idUser = :idUser order by idPedido";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function delPedido($pdo, $idPedido)
{
    $sql = "select estado from pedidos where idPedido=:idPedido";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
    $stmt->execute();
    $estado = $stmt->fetchColumn();
    $response = array();
    if ($estado == 1) {
        $sql = "delete from pedidos WHERE idPedido = :idPedido";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
        $stmt->execute();
        $response['success'] = true;
        $response['message'] = 'El pedido se eliminó correctamente';
        $response['data'] = getPedidos();
        echo json_encode($response);
    } else {
        $response['success'] = false;
        $response['message'] = 'No se puede eliminar.' . PHP_EOL . ' El pedido esta aceptado.';
        $response['data'] = getPedidos();
        echo json_encode($response);
    }
}
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        echo json_encode(getPedidos());
        break;
    case 'POST':
        break;
    case 'DELETE':
        parse_str(file_get_contents("php://input"), $deleteParams);
        $idPedido = $deleteParams["idPedido"];
        delPedido($pdo, $idPedido);
        break;
}

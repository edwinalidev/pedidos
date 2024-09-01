<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-type: application/json; charset=utf-8");

include '../../include/connection.php';
include '../../template/session.php';
function getSucursales()
{
    global $pdo;
    $send = $pdo->prepare("select * from sucursales");
    $send->execute();
    $data = $send->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($data);
}

$method = $_SERVER['REQUEST_METHOD'];
try {
    if ($method == 'GET') {
        echo getSucursales();
    } else if ($method == 'POST') {
        $idSucursal = $_POST['idSucursal'];
        if ($idSucursal >= 0) {
            $sucDetalle = $_POST['sucDetalle'];
            $sql = "update sucursales set sucDetalle=:sucDetalle where idSucursal=:idSucursal ";
            $send = $pdo->prepare($sql);
            $send->bindParam(':idSucursal', $idSucursal);
            $send->bindParam(':sucDetalle', $sucDetalle);
            $send->execute();

        } else {
            $stmt = $pdo->query("SELECT IFNULL(MAX(idSucursal), 0) + 1 AS newId FROM sucursales");
            $idSucursal = $stmt->fetch(PDO::FETCH_ASSOC)['newId'];
            $sucDetalle = $_POST['sucDetalle'];
            $sql = "insert into sucursales (idSucursal,sucDetalle) values(:idSucursal,:sucDetalle)";
            $send = $pdo->prepare($sql);
            $send->bindParam(':sucDetalle', $sucDetalle);
            $send->bindParam(':idSucursal', $idSucursal);
            $send->execute();
            $idSucursal = $_POST['idSucursal'];
        }
        echo getSucursales();
    } else if ($method == 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);
        // Verificar si se recibió el parámetro 'idCargo'
        $idSucursal = $data['idSucursal'];
        $Sql = "delete from sucursales where idSucursal=:idSucursal";
        $send = $pdo->prepare($Sql);
        $send->bindParam(':idSucursal', $idSucursal);
        $send->execute();
        echo getSucursales();

    } else {
        http_response_code(400); // Internal Server Error
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $e->getMessage()]);

}
$pdo = null;

<?php
include '../../include/connection.php';
include '../../template/session.php';
header('Content-Type: application/json');
header("Content-type: application/json; charset=utf-8");
function getCargos()
{
    global $pdo;
    $send = $pdo->prepare("select * from cargos");
    $send->execute();
    $data = $send->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($data);
}
$method = $_SERVER['REQUEST_METHOD'];
try {
    switch ($method) {
        case 'GET':
            echo getCargos();
            break;
        case 'POST':
            $idCargo = $_POST['idCargo'];
            if ($idCargo > 0) {
                $idCargo = $_POST['idCargo'];
                $carDetalle = $_POST['carDetalle'];
                $sql = "update cargos set carDetalle=:carDetalle where idCargo=:idCargo ";
                $send = $pdo->prepare($sql);
                $send->bindParam(':idCargo', $idCargo);
                $send->bindParam(':carDetalle', $carDetalle);
                $send->execute();
            } else {
                $carDetalle = $_POST['carDetalle'];
                $stmt = $pdo->query("SELECT IFNULL(MAX(idCargo), 0) + 1 AS newId FROM cargos");
                $idCargo = $stmt->fetch(PDO::FETCH_ASSOC)['newId'];
                $sql = "insert into cargos (idCargo,carDetalle) values(:idCargo,:carDetalle)";
                $send = $pdo->prepare($sql);
                $send->bindParam(':carDetalle', $carDetalle);
                $send->bindParam(':idCargo', $idCargo);
                $send->execute();
            }
            echo getCargos();
            break;
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"), true);
            $idCargo = $data['idCargo'];
            $send = $pdo->prepare("delete from cargos where idCargo=:idCargo");
            $send->bindParam(':idCargo', $idCargo);
            if ($send->execute()) {
                echo getCargos();
            } else {
                echo json_encode(["error" => "Error " . $send->errorInfo()[2]]);
            }

            break;
        default:
            http_response_code(405);
            echo json_encode(["error" => "Metodo no permitido"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
}
$pdo = null;

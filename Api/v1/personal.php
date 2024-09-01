<?php
include_once "../../include/connection.php";
//include_once "../../template/session.php";
header('Access-Control-Allow-Origin: *');
function getPersonal()
{
    global $pdo;
    $send = $pdo->prepare("SELECT idPersonal, nombre, ci, celular FROM personal");
    $send->execute();
    $data = $send->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($data);
}

$method = $_SERVER['REQUEST_METHOD'];
try {
    if ($method == 'GET') {
        echo getPersonal();
    } else if ($method == 'POST') {
        $nombre = $_POST['nombre'];
        $ci = $_POST['ci'];
        $celular = $_POST['celular'];
        $monto = $_POST['monto'];
        $idUser = $_POST['idUser'];
        $idPersonal = isset($_POST['idPersonal']) ? $_POST['idPersonal'] : null;

        if ($idPersonal) {
            // Actualizar registro existente
            $sql = "UPDATE personal SET nombre = :nombre, ci = :ci, celular = :celular, monto = :monto, idUser = :idUser WHERE idPersonal = :idPersonal";
            $send = $pdo->prepare($sql);
            $send->bindParam(':idPersonal', $idPersonal);
        } else {
            // Insertar nuevo registro
            $sql = "INSERT INTO personal (fecha, nombre, ci, celular, monto, idUser) VALUES (NOW(), :nombre, :ci, :celular, :monto, :idUser)";
            $send = $pdo->prepare($sql);
        }

        $send->bindParam(':nombre', $nombre);
        $send->bindParam(':ci', $ci);
        $send->bindParam(':celular', $celular);
        $send->bindParam(':monto', $monto);
        $send->bindParam(':idUser', $idUser);
        $send->execute();

        echo getPersonal();
    } else if ($method == 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);
        $idPersonal = $data['idPersonal'];

        $sql = "DELETE FROM personal WHERE idPersonal = :idPersonal";
        $send = $pdo->prepare($sql);
        $send->bindParam(':idPersonal', $idPersonal);
        $send->execute();

        echo getPersonal();
    } else {
        http_response_code(400); // Bad Request
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $e->getMessage()]);
}
$pdo = null;

<?php
// Configuración de conexión a la base de datos
//header("Content-Type: application/json");
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

// Resto de tu código

include_once "../../include/connection.php";
// Función para obtener todos los elementos
function getCategories()
{
    global $pdo;
    $sql = "SELECT * FROM categorias ORDER BY detalle";
    $stmt = $pdo->query($sql);
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return json_encode($categories);
}
try {
    // Configuración de la conexión a la base de datos
    // Manejar solicitudes GET, POST, PUT y DELETE
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            echo getCategories();
            break;
        case 'POST':
            // Insertar una nueva categoría
            $catDetalle = $_POST["catDetalle"];
            $catOrden = $_POST["catOrden"];
            $idCategoria = $_POST["idCategory"];
            if (isset($idCategoria)) {
                $sql = "INSERT INTO categorias (idCategoria,Detalle, orden) VALUES (:idCategoria,:detalle, :orden) ON DUPLICATE KEY UPDATE Detalle = :detalle, orden = :orden";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':detalle', $catDetalle);
                $stmt->bindParam(':orden', $catOrden);
                $stmt->bindParam(':idCategoria', $idCategoria);
                $stmt->execute();
                $datos = getCategories();
//                $result = array("success" => "true","data" => $datos,);
                echo $datos;

            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Datos de categoría no válidos"]);
            }
            break;
        case 'DELETE':
            // Eliminar una categoría
            $requestData = json_decode(file_get_contents("php://input"), true);
            $idCategoria = $requestData["idCategoria"];
            if ($requestData && isset($idCategoria)) {
                $sql = "DELETE FROM categorias WHERE idCategoria = :idCategoria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':idCategoria', $idCategoria, pdo::PARAM_INT);
                $stmt->execute();
                echo json_encode(["mensaje" => "Categoría eliminada con éxito"]);
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(["error" => "Datos de categoría no válidos"]);
            }
            break;

        default:
            http_response_code(405); // Method Not Allowed
            echo json_encode(["error" => "Método no permitido"]);
            break;
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $e->getMessage()]);
}

<?php
// Configuración de conexión a la base de datos
include_once("../../include/connection.php");


// Función para obtener todos los elementos
function getItems($pdo) {
    $sql = "SELECT idItem,i.Detalle,precio,i.idCategoria,c.Detalle as Categoria,i.orden,i.favorito,unidad FROM items i inner join categorias c on i.idCategoria=c.idcategoria order by c.orden,i.orden";
    $result = $pdo->query($sql);

    $data = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }

    echo json_encode($data);
}
// Función para obtener todos los elementos
function getItem($conn,$idItem) {
    
    $sql = "SELECT * FROM items i inner join categorias c on i.idCategoria=c.idcategoria WHERE idItem=$idItem";
    $result = $conn->query($sql);
    $data = array();
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    echo json_encode($data);
}
// Función para agregar/editar un elemento
function saveItem($pdo, $detalle, $precio, $orden, $idCategoria, $idItem,$unidad,$favorito) {
    $response = array();
    if (empty($idItem)) {
        $sql = "INSERT INTO items (Detalle, precio, orden, idCategoria,unidad,favorito) VALUES (:detalle, :precio, :orden, :idCategoria,:unidad,:favorito)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':detalle', $detalle, PDO::PARAM_STR);
        $stmt->bindValue(':precio', $precio, PDO::PARAM_INT);
        $stmt->bindValue(':orden', $orden, PDO::PARAM_INT);
        $stmt->bindValue(':unidad',$unidad);
        $stmt->bindValue(':favorito',$favorito);
        $stmt->bindValue(':idCategoria', $idCategoria, PDO::PARAM_INT);
    } else {
        // UPDATE
        $sql = "UPDATE items SET Detalle=:detalle, precio=:precio, orden=:orden, idCategoria=:idCategoria,unidad=:unidad,favorito=:favorito WHERE idItem=:idItem";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':detalle', $detalle, PDO::PARAM_STR);
        $stmt->bindValue(':precio', $precio, PDO::PARAM_INT);
        $stmt->bindValue(':orden', $orden, PDO::PARAM_INT);
        $stmt->bindValue(':idCategoria', $idCategoria, PDO::PARAM_INT);
        $stmt->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        $stmt->bindValue(':unidad',$unidad);
        $stmt->bindValue(':favorito',$favorito);

    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Operación realizada con éxito";
    } else {
        $response['success'] = false;
        $response['message'] = "Error al realizar la operación: " . $stmt->errorInfo()[2];
    }

    // Devolver resultado en formato JSON
    echo json_encode($response);
}



// Función para eliminar un elemento
function deleteItem($pdo, $idItem) {
    // Utilizar una consulta preparada para evitar la inyección de SQL
    $sql = "DELETE FROM items WHERE idItem = :idItem";
    
    // Preparar la consulta
    $stmt = $pdo->prepare($sql);

    // Vincular los parámetros
    $stmt->bindParam(':idItem', $idItem, PDO::PARAM_INT);

    try {
        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se eliminó correctamente
        if ($stmt->rowCount() > 0) {
            $response = array('success' => true, 'message' => 'Operacion realizada con exito');
        } else {
            $response = array('success' => false, 'message' => 'No se encontro el elemento con el ID proporcionado.');
        }
    } catch (PDOException $e) {
        $response = array('success' => false, 'message' => 'Error al ejecutar la consulta: ' . $e->getMessage());
    }

    // Devolver el resultado como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}


// Verificar el tipo de solicitud y llamar a la función correspondiente
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Obtener elementos
    $idItem = isset($_GET["idItem"]) ? $_GET["idItem"] : null;

    if ($idItem == null) {
        getItems($pdo);
    }else{
        getItem($pdo, $idItem);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Guardar elemento
    $detalle        = $_POST["detalle"];
    $precio         = $_POST["precio"];
    $orden          = $_POST["orden"];
    $idCategoria    = $_POST["selectCategory"];
    $idItem         = $_POST["idItem"];
    $unidad         = $_POST["unidad"];
    $favorito       = isset($_POST["favorito"])? 1:0;

    saveItem($pdo, $detalle, $precio, $orden, $idCategoria, $idItem,$unidad,$favorito);
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Eliminar elemento file_get_contents recupera los datos enviados 
    parse_str(file_get_contents("php://input"), $deleteParams);
    $idItem = $deleteParams["idItem"];

    deleteItem($pdo, $idItem);
}
$pdo=null;


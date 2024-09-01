<?php

require_once 'connection.php';

class ApiController {

    private $pdo;
    public  $tabla;
    public  $id;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function handleRequest() {
        // Set the content type to JSON
        header('Content-Type: application/json');
        
        // Handle HTTP methods
        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                $this->handleGetRequest();
                break;
            case 'POST':
                $this->handlePostRequest();
                break;
            case 'PUT':
                $this->handlePutRequest();
                break;
            case 'DELETE':
                $this->handleDeleteRequest();
                break;
            default:
                // Invalid method
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed']);
                break;
        }
    }

    private function handleGetRequest() {
        // Read operation (fetch records)
        $stmt = $this->pdo->query("SELECT * FROM $this->tabla");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }

    private function handlePostRequest() {
    $data = json_decode(file_get_contents('php://input'), true);    
    // Prepare and execute the SQL query for insertion
    $fields = implode(', ', array_keys($data));
    $placeholders = rtrim(str_repeat('?, ', count($data)), ', ');

    $query = "INSERT INTO $this->tabla ($fields) VALUES ($placeholders)";
    $stmt = $this->pdo->prepare($query);
    
    // Bind values for the prepared statement
    $values = array_values($data);
    $stmt->execute($values);
    }

    private function handlePutRequest() {
        // Update operation (edit a record)
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
    
        // Build the SET part of the SQL query
        $setClauses = [];
        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                $setClauses[] = "$key=?";
            }
        }
        $setClause = implode(', ', $setClauses);
    
        // Prepare and execute the SQL query
        $query = "UPDATE $this.table SET $setClause WHERE id=?";
        $stmt = $this->pdo->prepare($query);
    
        // Bind values for the prepared statement
        $values = array_values($data);
        $values[] = $id;
    
        $stmt->execute($values);
    
        echo json_encode(['message' => 'Record updated successfully']);
    }

    private function handleDeleteRequest() {
        // Delete operation (remove a record)
        $id = $_GET['id'];

        $stmt = $this->pdo->prepare('DELETE FROM $this.table WHERE id=?');
        $stmt->execute([$id]);

        echo json_encode(['message' => 'Record deleted successfully']);
    }
}

// Usage
$apiController = new ApiController($pdo);
$apiController->tabla="items";
$apiController->handleRequest();

?>

<?php
/*
    Author:- Edwin Ali
    Date:- 2023-12-23
    Purpose:- User Class to manage actions: getConnection(),closeConnection()
*/
require_once 'config.php';

class Database {
    private $conn;

    public function getConnection() {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch (PDOException $pdoException) {
            throw new Exception("Error al conectar con la base de datos: " . $pdoException->getMessage());
        } catch (Exception $exception) {
            throw new Exception("Error general: " . $exception->getMessage());
        }

        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
?>

<?php
// Endpoint para obtener la lista de pedidos con detalles
include_once("../../include/connection.php");
        $sql="SELECT detalle,idCategoria FROM categorias";
        $send=$pdo->prepare($sql);
        $send->execute();      
        $data = $send->fetchAll(PDO::FETCH_ASSOC);    
        $categorias = [];
        foreach($data as $row){
            $idCategoria    = $row['idCategoria'];
            $itemsStmt      = $pdo->prepare("SELECT * FROM items WHERE idcategoria = :idCategoria");
            $itemsStmt->bindParam(':idCategoria',$idCategoria,PDO::PARAM_INT);
            $itemsStmt->execute();
            $Items = [];
            $dataItems=$itemsStmt->fetchAll(PDO::FETCH_ASSOC);
            if($dataItems){    
            $categorias[] = [
                'idCategoria'  => $idCategoria,
                'detalle'     => $row['detalle'],                
                'items'   => $dataItems
            ];
            }
        }
        echo json_encode($categorias);
    
?>
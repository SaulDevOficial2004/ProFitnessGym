<?php

session_start();

header('Content-Type: application/json');

require_once '../php_action/conn_db.php';

if(!isset($_SESSION['telefono'])){
    
    echo json_encode([
        "status" => "error",
        "message" => "Sesión expirada"
    ]);

    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];

$sql = "
    UPDATE personas
    SET estatus = 2
    WHERE id = ?
";

$stmt = $connect->prepare($sql);

$stmt->bind_param("i",
    $id    
);

if($stmt->execute()){
    echo json_encode([
        "status" => "success",
        "message" => "Persona eliminada"
    ]);
}else{
    echo json_encode([
        "status" => "error",
        "message" => "Error al eliminar"
    ]);
}

?>
<?php

session_start();

header('Content-Type: application/json');

require_once "../php_action/conn_db.php";

if(!isset($_SESSION['telefono'])){
    
    echo json_encode([
        
        "status" => "error",
        "message" => "Sesión expirada"
    ]);

    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];

$fecha_ini = $data['fecha_ini'];
$fecha_fin = $data['fecha_fin'];

$sql = "
    UPDATE personas
    SET fecha_ini = ?, fecha_fin = ?
    WHERE id = ?
";

$stmt = $connect->prepare($sql);

$stmt->bind_param("ssi",
    $fecha_ini,
    $fecha_fin,
    $id
);

if($stmt->execute()){

    echo json_encode([

    "status" => "success",
    "message" => "Membresía actualizada correctamente"
    ]);

}else{

    echo json_encode([
        "status" => "error",
        "message" => "Error al actualizar"
    ]);
}

?>
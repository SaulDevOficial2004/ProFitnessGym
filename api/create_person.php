<?php

session_start();

header('Content-Type : application/json');

require_once '../php_action/conn_db.php';

if(!isset($_SESSION['telefono'])){

    json_encode([
        "status" => "error",
        "message" => "Sesión expirada"
    ]);

    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$nombre = $data['nombre'];
$folio = $data['folio'];
$fecha_ini = $data['fecha_ini'];
$fecha_fin = $data['fecha_fin'];

$sql = "
    INSERT INTO personas
    (nombre, folio, fecha_ini, fecha_fin, estatus)
    VALUES (?, ?, ?, ?, 1)
";

$stmt = $connect->prepare($sql);

$stmt->bind_param("siss",
    $nombre,
    $folio,
    $fecha_ini,
    $fecha_fin
);


if($stmt->execute()){

    echo json_encode([
        "status" => "success",
        "message" => "Persona registrada correctamente"
    ]);
}else{

    echo json_encode([
        "status" => "error",
        "message" => "Error al registrar"
    ]);
}

?>
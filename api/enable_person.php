<?php

session_start();

header('Content-Type: application/json');

require_once '../php_action/conn_db.php';

//Validar sesión

if(!isset($_SESSION['telefono'])){

    echo json_encode([
        "status" => "error",
        "message" => "Sesión expirada"
    ]);

    exit();
}

//RECEPCIÓN DE DATOS

$data = json_decode(file_get_contents("php://input"),true);

//VALIDACION DE ID

if(!isset($data['id'])){

    echo json_encode([
        "status" => "error",
        "message" => "ID no recibida"
    ]);
}

$id = $data['id'];

//HABILITAR PERSONA

$sql = "
    UPDATE personas
    SET estatus = 1
    WHERE id = ?
";

$stmt = $connect->prepare($sql);

$stmt->bind_param("i",
    $id
);

//RESPUESTA

if($stmt->execute()){

    echo json_encode([

        "status" => "success",
        "message" => "Persona habilitada correctamente"
    ]);
}else{

    echo json_encode([
        "status" => "error",
        "message" => "Error al habilitar a la persona"
    ]);
}

//CERRAR CONEXION

$stmt->close();

$connect->close();


?>
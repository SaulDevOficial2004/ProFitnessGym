<?php

header('Content-Type: application/json');

require_once '../php_action/conn_db.php';

// Obtener búsqueda
$search = trim($_GET['search'] ?? '');

if(empty($search)){

    echo json_encode([]);
    exit();

}

// Agregar comodines para LIKE
$search = "%" . $search . "%";

$sql = "

    SELECT
        nombre,
        folio,
        fecha_fin

    FROM personas

    WHERE
    (
        nombre LIKE ?
        OR folio LIKE ?
    )

    AND estatus = 1

    ORDER BY nombre ASC

";

$stmt = $connect->prepare($sql);

$stmt->bind_param(
    "ss",
    $search,
    $search
);

$stmt->execute();

$result = $stmt->get_result();

$personas = [];

while($row = $result->fetch_assoc()){

    $personas[] = $row;

}

echo json_encode($personas);

$stmt->close();
$connect->close();

?>
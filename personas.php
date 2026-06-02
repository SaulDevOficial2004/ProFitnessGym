<?php
session_start();

if (!isset($_SESSION['telefono'])) {
    header("Location: index.php");
    exit();
}

require_once 'php_action/conn_db.php';

// TOTAL DE PERSONAS
$sqlTotal = "
SELECT COUNT(*) AS personas
FROM personas
WHERE estatus = 1
";

$resultTotal = $connect->query($sqlTotal);
$rowTotal = $resultTotal->fetch_assoc();

$total_personas = $rowTotal['personas'];
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Personas | ProfitnessGym</title>

    <link rel="shortcut icon"
          href="img/logo_pfg-removebg-preview.ico"
          type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet"
          href="css/personas.css">

    <!--Toastify-->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg navbar-custom">
    <a class="navbar-brand d-flex align-items-center"
       href="pagina.php">
        <img src="img/logo_pfg-removebg-preview.png"
             class="nav-logo">
        <span class="brand-text">
            ProfitnessGym
        </span>
    </a>

    <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNav">

        <span class="navbar-toggler-icon"></span>

    </button>

    <div class="collapse navbar-collapse"
         id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link active-link"
                   href="pagina.php">
                    <i class="fas fa-house-user"></i>
                    Home
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link"
                   href="personas.php">
                    <i class="fas fa-users"></i>
                    Personas
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link"
                   href="inactivos.php">
                    <i class="fas fa-ban"></i>
                    Inhabilitados
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- CONTENIDO -->

<div class="content-card">

    <!-- HEADER -->

    <div class="header-toolbar">

        <div>

            <h2>

                <i class="fas fa-users"></i>
                Personas Registradas

            </h2>

            <p>

                Total de personas activas:

                <strong>

                    <?php echo $total_personas; ?>

                </strong>

            </p>

        </div>

        <button
            class="btn-add-person"
            data-toggle="modal"
            data-target="#addPersonModal">

            <i class="fas fa-user-plus"></i>

            Agregar Persona

        </button>

    </div>

    <!-- BUSCADOR -->

    <div class="search-box">

        <i class="fas fa-search"></i>

        <input
            type="text"
            id="searchPerson"
            placeholder="Buscar persona por nombre o folio">

    </div>

    <!-- TABLA -->

    <div class="table-responsive">

        <table
            id="personsTable"
            class="table modern-table">

            <thead>

            <tr>

                <th>Nombre</th>
                <th>Folio</th>
                <th>Inicio</th>
                <th>Vencimiento</th>
                <th>Estatus</th>
                <th>Acciones</th>

            </tr>

            </thead>

            <tbody>

            <?php

            $fechaActual = new DateTime();

            $sql = "
            SELECT *
            FROM personas
            WHERE estatus = 1
            ORDER BY nombre ASC
            ";

            $result = $connect->query($sql);

            if($result->num_rows > 0){

                while($row = $result->fetch_assoc()){

                    $fechaInicio =
                    date(
                        "d/m/Y",
                        strtotime($row['fecha_ini'])
                    );

                    $fechaFin =
                    date(
                        "d/m/Y",
                        strtotime($row['fecha_fin'])
                    );

                    $fechaFinObj =
                    new DateTime(
                        $row['fecha_fin']
                    );

                    if($fechaActual <= $fechaFinObj){

                        $badge =
                        "<span class='status-active'>
                        Activo
                        </span>";

                    }else{

                        $badge =
                        "<span class='status-expired'>
                        Vencido
                        </span>";

                    }

                    echo "

                    <tr>

                        <td>{$row['nombre']}</td>

                        <td>{$row['folio']}</td>

                        <td>{$fechaInicio}</td>

                        <td>{$fechaFin}</td>

                        <td>{$badge}</td>

                        <td>

                            <button
                                type='button'
                                class='btn-edit editBtn'
                                
                                data-id='{$row['id']}'
                                data-nombre='{$row['nombre']}'
                                data-folio='{$row['folio']}'
                                data-fecha_ini='{$row['fecha_ini']}'
                                data-fecha_fin='{$row['fecha_fin']}'>

                                <i class='fas fa-pen'></i>

                            </button>

                            <button
                                type='button'
                                class='btn-delete deleteBtn ml-2'
                                
                                data-id='{$row['id']}'
                                data-nombre='{$row['nombre']}'>

                                <i class='fas fa-trash'></i>

                            </button>

                        </td>

                    </tr>

                    ";

                }

            }else{

                echo "

                <tr>

                    <td
                        colspan='6'
                        class='text-center'>

                        No hay personas registradas

                    </td>

                </tr>

                ";

            }

            ?>

            </tbody>

        </table>

    </div>

</div>


<!-- MODAL AGREGAR PERSONA -->

<div class="modal fade"
     id="addPersonModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header border-0">
                <h4 class="modal-title">

                    <i class="fas fa-user-plus"></i>
                    Registrar Persona

                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <form id="createPersonForm">
                <div class="modal-body">
                    <div class="form-group">

                        <label>Nombre completo</label>

                        <input type="text"
                               id="nombre"
                               class="form-control modern-input"
                               placeholder="Ingrese nombre completo"
                               required>

                    </div>

                    <div class="form-group">
                        
                        <label>Folio</label>

                        <input type="number"
                               id="folio"
                               class="form-control modern-input"
                               placeholder="Ingrese folio"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Duración</label>

                        <select id="duracionPersonas"
                                class="form-control modern-input">

                            <option value="">
                                Seleccione duración
                            </option>

                            <option value="7">
                                1 Semana
                            </option>

                            <option value="14">
                                2 Semanas
                            </option>

                            <option value="30">
                                1 Mes
                            </option>

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Fecha inicio</label>

                        <input type="date"
                               id="fecha_ini_persona"
                               class="form-control modern-input"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Fecha vencimiento</label>

                        <input type="date"
                               id="fecha_fin_persona"
                               class="form-control modern-input"
                               required>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button type="reset"
                            class="btn btn-cancel">

                        Limpiar

                    </button>

                    <button type="submit"
                            class="btn btn-save">

                        Registrar

                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL EDITAR PERSONA -->

<div
    class="modal fade"
    id="editPersonModal"
    tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <h5 class="modal-title">

                    <i class="fas fa-user-edit"></i>
                    Editar Persona

                </h5>

                <button
                    type="button"
                    class="close"
                    data-dismiss="modal">

                    <span>&times;</span>

                </button>
            </div>

            <div class="modal-body">
                <form id="editPersonForm">
                    <input
                        type="hidden"
                        id="edit_id">

                    <div class="form-group">
                        <label for="edit_nombre">

                            Nombre

                        </label>

                        <input
                            type="text"
                            id="edit_nombre"
                            class="form-control modern-input"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="edit_folio">

                            Folio

                        </label>
                        <input
                            type="number"
                            id="edit_folio"
                            class="form-control modern-input"
                            required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_fecha_ini">

                                    Fecha Inicio

                                </label>
                                <input
                                    type="date"
                                    id="edit_fecha_ini"
                                    class="form-control modern-input"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_fecha_fin">

                                    Fecha Fin

                                </label>
                                <input
                                    type="date"
                                    id="edit_fecha_fin"
                                    class="form-control modern-input"
                                    required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn-cancel"
                    data-dismiss="modal">

                    <i class="fas fa-times"></i>
                    Cancelar

                </button>

                <button
                    type="submit"
                    form="editPersonForm"
                    class="btn-save">

                    <i class="fas fa-save"></i>
                    Guardar Cambios

                </button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!--Toastify-->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>



<!--Scripts funcionales-->
<script src="js/personas.js"></script>
<script src="js/dashboard.js"></script>
<script src="js/alerts.js"></script>

</body>
</html>

<?php
$connect->close();
?>
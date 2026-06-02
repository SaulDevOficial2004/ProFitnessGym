<?php

session_start();

if(!isset($_SESSION['telefono'])){

    header("Location: index.php");
    exit();

}

require_once 'php_action/conn_db.php';

/* TOTAL INHABILITADOS */

$sqlTotal = "
  SELECT COUNT(*) AS personas
  FROM personas
  WHERE estatus = 2
";

$resultTotal = $connect->query($sqlTotal);
$rowTotal = $resultTotal->fetch_assoc();
$total_personas = $rowTotal['personas'];

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Inhabilitados | ProfitnessGym</title>

<link rel="shortcut icon"
      href="img/logo_pfg-removebg-preview.ico">

<!-- Bootstrap -->

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<!-- FontAwesome -->

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- SweetAlert -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Toastify -->

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<!-- CSS -->

<link rel="stylesheet"
href="css/inactivos.css">

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
                   href="#"
                   
                   data-toggle="modal"
                   data-target="#addPersonModal">

                    <i class="fas fa-user-plus"></i>
                    Agregar persona
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

                <i class="fas fa-user-slash"></i>

                Personas Inhabilitadas

            </h2>

            <p>

                Total de personas inhabilitadas:

                <strong>

                    <?php echo $total_personas; ?>

                </strong>

            </p>

        </div>

    </div>

    <!-- BUSCADOR -->

    <div class="search-box">

        <i class="fas fa-search"></i>

        <input
            type="text"
            id="searchInactive"
            placeholder="Buscar persona por nombre o folio">

    </div>

    <!-- TABLA -->

    <div class="table-responsive">

        <table
            id="inactiveTable"
            class="table modern-table">

            <thead>

                <tr>

                    <th>Nombre</th>

                    <th>Folio</th>

                    <th>Acciones</th>

                </tr>

            </thead>

            <tbody>

            <?php

            $sql = "

            SELECT *

            FROM personas

            WHERE estatus = 2

            ORDER BY nombre ASC

            ";

            $result = $connect->query($sql);

            if($result->num_rows > 0){

                while($row = $result->fetch_assoc()){

                    echo "

                    <tr>

                        <td>

                            {$row['nombre']}

                        </td>

                        <td>

                            {$row['folio']}

                        </td>

                        <td>

                            <button

                            type='button'

                            class='btn-enable enableBtn'

                            data-id='{$row['id']}'

                            data-nombre=\"{$row['nombre']}\">

                                <i class='fas fa-check'></i>

                                Habilitar

                            </button>

                        </td>

                    </tr>

                    ";

                }

            }else{

                echo "

                <tr>

                    <td

                    colspan='3'

                    class='empty-state text-center'>

                        <i class='fas fa-check-circle'></i>

                        <br><br>

                        No hay personas inhabilitadas

                    </td>

                </tr>

                ";

            }

            ?>

            </tbody>

        </table>

    </div>

</div>

<!-- JQUERY -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- BOOTSTRAP -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS -->

<script src="js/inactivos.js"></script>

</body>

</html>

<?php

$connect->close();

?>
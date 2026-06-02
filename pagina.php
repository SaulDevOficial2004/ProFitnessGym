<?php

session_start();

if(isset($_SESSION['telefono'])){

    $telefono = $_SESSION['telefono'];
    $nombre = $_SESSION['nombre'];

    require_once 'php_action/conn_db.php';

    $sql = "SELECT * FROM administradores WHERE telefono = ?";

    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();
    $userInformation = '';

    if($result->num_rows === 1){
        $row = $result->fetch_assoc();

        $userInformation = '

            <tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['apellidos'].'</td>
                <td>'.$row['telefono'].'</td>
            </tr>

        ';
    }

    $stmt->close();

}else{

    header("location:index.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ProfitnessGym</title>
    <link rel="shortcut icon" href="img/logo_pfg-removebg-preview.ico" type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Toastify -->
    <link rel="stylesheet"
          type="text/css"
          href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS PERSONALIZADO -->
    <link rel="stylesheet" href="css/dashboard.css">
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

<div class="container-fluid dashboard-container">

    <!-- BIENVENIDA -->

    <div class="card-custom">
        <div class="welcome-header">
            <div>
                <h1 class="welcome-title">

                    ¡Hola <?php echo $nombre; ?>!

                </h1>
                <p class="welcome-subtitle">

                    Bienvenido nuevamente al sistema administrativo.

                </p>
            </div>

            <div class="welcome-icon">
                <i class="fa-solid fa-dumbbell"></i>
            </div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>

                    <?php echo $userInformation; ?>

                </tbody>
            </table>
        </div>

        <a href="php_action/logout.php"
           class="btn btn-logout">
            <i class="fas fa-right-from-bracket"></i>
            Cerrar sesión

        </a>
    </div>

    <!-- MEMBRESIAS -->

    <?php

    $sql_vencidos = "
        SELECT * 
        FROM personas 
        WHERE fecha_fin < NOW()
        AND estatus = 1
    ";

    $result_vencidos = $connect->query($sql_vencidos);

    ?>

    <div class="card-custom">
        <div class="section-title-container">
            <h2 class="section-title">

                Membresías vencidas

            </h2>

            <p class="section-subtitle">

                Clientes que necesitan renovación de membresía

            </p>
        </div>

        <div class="table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Vencimiento</th>
                        <th>Membresía</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>

                <?php

                while($row = $result_vencidos->fetch_assoc()){

                    $fechaFin = date("d/m/Y", strtotime($row['fecha_fin']));

                    echo '

                    <tr>
                        <td>'.$row['nombre'].'</td>
                        <td>'.$fechaFin.'</td>
                        <td>

                            <button
                                type="button"
                                class="btn btn-update updateBtn"

                                data-toggle="modal"
                                data-target="#updateMembershipModal"

                                data-id="'.$row['id'].'"
                                data-nombre="'.$row['nombre'].'">

                                <i class="fas fa-credit-card"></i>
                                Actualizar

                            </button>

                        </td>

                        <td>
                            <span class="status-expired">

                                Vencido

                            </span>

                            <a href="del_ven.php?id='.$row['id'].'"
                               class="btn btn-delete">

                                <i class="fas fa-trash"></i>

                            </a>
                        </td>
                    </tr>
                    ';
                }

                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL ACTUALIZAR MEMBRESIA -->

<div class="modal fade"
     id="updateMembershipModal"
     tabindex="-1"
     role="dialog">

    <div class="modal-dialog modal-dialog-centered"
         role="document">

        <div class="modal-content custom-modal">
            <div class="modal-header border-0">
                <h4 class="modal-title">

                    <i class="fas fa-credit-card"></i>
                    Actualizar Membresía

                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <form id="updateMembershipForm"
                  method="POST">

                <div class="modal-body">

                    <input type="hidden"
                           name="id"
                           id="cliente_id">

                    <div class="client-name-box">

                        Cliente:
                        <span id="cliente_nombre"></span>

                    </div>

                    <div class="form-group">

                        <label>Duración</label>

                        <select name="fechas"
                                id="duracion"
                                class="form-control modern-input">

                            <option value="">
                                Seleccione una opción
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

                        <label>Fecha inicial</label>

                        <input type="date"
                               name="fecha_ini"
                               id="fecha_ini"
                               class="form-control modern-input"
                               required>

                    </div>

                    <div class="form-group">

                        <label>Fecha vencimiento</label>

                        <input type="date"
                               name="fecha_fin"
                               id="fecha_fin"
                               class="form-control modern-input"
                               required>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button type="button"
                            class="btn btn-cancel"
                            data-dismiss="modal">

                        Cancelar

                    </button>

                    <button type="submit"
                            class="btn btn-save">

                        Guardar Membresía

                    </button>

                </div>

            </form>

        </div>

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

<!-- JS -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<!--SCRIPTS JS-->
<script src="js/alerts.js"></script>
<script src="js/dashboard.js"></script>
<!--Funcionalidades-->

<?php if(isset($_GET['success'])): ?>

<script>

    loginSuccess();

</script>

<?php endif; ?>

<?php if(isset($_GET['update'])): ?>

    <script>

        updateMembership();

    </script>

<?php endif; ?>

</body>
</html>

<?php

$connect->close();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ProfitnessGym Web</title>

    <link rel="shortcut icon"
          href="img/logo_pfg-removebg-preview.ico"
          type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Toastify -->
    <link rel="stylesheet"
          type="text/css"
          href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- CSS PERSONALIZADO -->
    <link rel="stylesheet" href="css/login.css">

</head>
<body>

<div class="login-wrapper">

    <!-- LOGIN -->
    <div class="login-left">

        <img src="img/logo_pfg-removebg-preview.png"
             class="logo"
             alt="Logo">

        <h2 class="login-title">
            Iniciar Sesión
        </h2>

        <p class="login-subtitle">
            Accede al sistema administrativo del gimnasio
        </p>

        <form id="loginForm" method="POST">

            <div class="form-group">

                <label>
                    <i class="fas fa-phone-alt"></i>
                    Teléfono
                </label>

                <input type="text"
                       id="telefono"
                       class="form-control"
                       name="telefono"
                       placeholder="Ingrese su teléfono">

            </div>

            <div class="form-group">

                <label>
                    <i class="fas fa-lock"></i>
                    Contraseña
                </label>

                <input type="password"
                       id="password"
                       class="form-control"
                       name="password"
                       placeholder="Ingrese su contraseña">

            </div>

            <button type="submit" class="btn btn-login">
                Iniciar Sesión
            </button>

        </form>

    </div>

    <!-- PANEL DERECHO -->

    <div class="login-right">

        <h1 class="welcome-title">
            Bienvenido a <br>
            ProfitnessGym Web
        </h1>

        <p class="welcome-text">
            Gestiona clientes, membresías, pagos y el control administrativo
            de tu gimnasio desde una plataforma moderna, rápida y segura.
        </p>

        <a href="auto_busqueda.php" class="btn-status">

            Ver mi estatus

            <i class="fa-solid fa-users ml-2"></i>

        </a>

        <div class="fitness-text">
            ProfitnessGym © 2026
        </div>

    </div>

</div>

<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- TOASTIFY -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<!-- ALERTAS -->
<script src="js/alerts.js"></script>
<!--SCRIPT login.js-->
<script src="js/login.js"></script>

<!-- ALERTAS PHP -->

<?php if(isset($_GET['error'])): ?>

<script>
    loginError();
</script>

<?php endif; ?>


<?php if(isset($_GET['success'])): ?>

<script>
    loginSuccess();
</script>

<?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
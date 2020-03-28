<?php 
    session_start();

    if($_SESSION['s_usuario'] === null){   //si la variable de sesión es nula
        header("Location: ../index.php");  //nos redirige a "index.php" la cual es la pantalla de Login/Logout
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit-no">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../estilos.css">
    <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
    <title>Login/Logout</title>
</head>
<body class="">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="junbotron">
                    <h1 class="display-4 text-center">¡Bienvenido!</h1>
                    <h2 class="text-center">Usuario: <span class="badge badge-primary"><?php echo $_SESSION["s_usuario"]; ?></span></h2>
                    <a class="btn btn-danger btn-lg" href="../bd/logout.php" role="button">Cerrar sesón</a>
                </div>
            </div>
        </div>
    </div>


    <script src="../jquery/jquery-3.4.1.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../popper/popper.min.js"></script>

    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../codigo.js"></script> <!--jquery ajax-->
</body>
</html>
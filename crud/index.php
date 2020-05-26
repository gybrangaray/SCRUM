<?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar(); //llamando a la método Conectar de la clase Conexion archivo "conexion.php"

$consulta = 'SELECT id, nombre, pais, edad FROM personas';  // también * <-- todo
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

session_start();
if($_SESSION['s_usuario'] === null){   //si la variable de sesión es nula
  header("Location: ../crud/index.php");  //nos redirige a "index.php" la cual es la pantalla de Login/Logout
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--  <link rel="shortcut icon" href="#">-->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="datatables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css">
    <title>Sistemas de información</title>
</head>
<body>
    <header>
    <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img src="https://i.imgur.com/iO8Ro4y.jpg" width="30" height="30" style="border-radius:50%" class="d-inline-block align-top" alt="sistema">
    Sistemas de información
  </a>
  <h4 class="display-8 ">¡Bienvenido Usuario: <span class="badge badge-primary"><?php echo $_SESSION["s_usuario"]; ?></span>!</h4>
                    <a  class="btn btn-danger btn-lg center-block" href="../bd/logout.php" role="button">Cerrar sesón</a>
</nav>
    </header>
    <div class="container">  
        <div class="row">
            <div class="col-lg-12"><br>
                <button id="btnNuevo" type="button" class="btn btn-success" title="Agregar nuevo">
                    <i class="fas fa-user-plus"></i> 
                </button> <!--Boton nuevo y se le agrega Id por que es unico -->
            </div>
        </div>
    </div>

                  <div class="container"> <!-- tabla responsiva-->
                      <div class="row">
                          <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                                    <br>
                                  <thead class="text-center"> <!-- Encabezado de la tabla-->
                                      <tr>   <!-- tr Filas--> 
                                           <td>Id</td> <!-- td Columnas-->
                                          <td>Nombre</td>
                                          <td>Pais</td>
                                          <td>Edad</td>
                                          <td>Acciones</td>
                                      </tr>
                                    </thead>
                                    <tbody class="text-center" > <!-- Cuerpo de la tabla-->
                                    <?php
                                    foreach($data as $dat){
                                      ?>
                                      <tr id="hover">   
                                          <td > <?php echo $dat['id']     ?></td> 
                                          <td><b> <?php echo $dat['nombre'] ?> </b></td>
                                          <td> <?php echo $dat['pais']   ?> </td>
                                          <td> <?php echo $dat['edad']   ?> </td>
                                          <td>
                                        <div class="text-center">
                                                  <div class="btn-group">
                                                      <button class="btn btn-primary btnEditar" title="Editar">
                                                        <i class="fa fa-edit"></i>
                                                      </button><!--Al boton editar seran muchos generados dinamicamente por JS y se le agrega clase en ves id -->
                                                      <button class="btn btn-danger btnEliminar" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                      </button> <!--Boton Eliminar-->
                                                  </div>
                                              </div>  
                                          </td>
                                          </tr>
                                          <?php
                                                          }
                                      ?>
                                    </tbody>
                                </table>
                            </div>
                          </div>
                      </div>
                  </div>

                 <!-- Modal -->
                <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form id="formPersonas"> <!--Mismo MODAL para distintas acciones ("NUEVO, EDITAR, ELIMINAR") -->
                          <div class="modal-body"><!--todos los datos de los inputs seran enviados a la base de datos por medio de la etiqueta <form>-->
                              <div class="form-group">
                                  <label for="nombre" class="col-form-label">Nombre:</label>
                                  <input required type="text" class="form-control" id="nombre" placeholder="Nombre">
                                </div>
                              <div class="form-group">
                                  <label for="pais" class="col-form-label">País:</label>
                                  <input required type="text" class="form-control" id="pais" placeholder="País">
                                </div>
                                <div class="form-group">
                                  <label for="edad" class="col-form-label">Edad:</label>
                                  <input required type="number" class="form-control" id="edad" placeholder="Edad">
                                </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btnGuardar btn btn-dark">Guardar</button>
                            </div>
                      </form>
                      
                    </div>
                  </div>
                </div>

  
     <!-- Fontawesome, jquery, popper, js, bootstrap JS-->
    <script  src="fontawesome/js/all.min.js"></script>
    <script src="jquery/jquery-3.4.1.min.js"></script>
    <script src="popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <!-- datatables JS-->
    <script type="text/javascript" src="datatables/datatables.min.js"></script>
    <script type="text/javascript" src="main.js"></script>
   
    
</body>
</html>  
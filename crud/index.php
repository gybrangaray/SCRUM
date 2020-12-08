<?php
include_once 'bd/conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar(); //llamando a la método Conectar de la clase Conexion archivo "conexion.php"

$consulta = 'SELECT id,seccion,nombre,descripcion,sintoma,solucion,persona FROM personas';  // también * <-- todo
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
    <link rel="shortcut icon" href="../img/KyuubinetSolo.png" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="datatables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="datatables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css">
    <title>Kyuubinet</title>
</head>
<body>
    <header>
    <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">
  <img src="../img/KyuubinetSoloDos.png" width="170" height="30"  alt="Kyuubinet" >
  <img src="../img/KyuubinetSolo.png" width="40" height="30"  alt="Kyuubinet" class="girar">
  </a>
  <h4 class="display-8 ">¡Bienvenido Usuario: <span class="badge badge-success"><?php echo $_SESSION["s_usuario"]; ?></span>!</h4>
                    <a  class="btn btn-outline-danger btn-sm center-block" href="../bd/logout.php" role="button">Cerrar sesión</a>
</nav>
    </header>
    <div class="container">  
        <div class="row">
            <div class="col-lg-12"><br>
                <button id="btnNuevo" type="button" class="btn btn-outline-success" title="Agregar | nuevo">
                    <i class="fas fa-user-plus"></i> 
                </button> <!--Boton nuevo y se le agrega Id por que es unico -->
            </div>
        </div>
    </div>
                  <div class="container"> <!-- tabla responsiva-->
                  <br>
                     <h4>Control de fallas | Control de cambios</h4>
                     
                      <div class="row">
                          <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tablaPersonas" class="table table-striped table-bordered table-condensed" style="width:100%">
                                  <thead class="text-center"> <!-- Encabezado de la tabla-->
                                      <tr>   <!-- tr Filas--> 
                                          <td><b>Id</td> <!-- td Columnas-->
                                          <td><b>Sección</td>
                                          <td><b>Nombre</td>
                                          <td><b>Descripción</td>
                                          <td><b>Sintoma</td>
                                          <td><b>Solución</td>
                                          <td><b>Persona</td>
                                          <td><b>Acciones</td>
                                      </tr>
                                    </thead>
                                    <tbody class="text-center" > <!-- Cuerpo de la tabla-->
                                    <?php
                                    foreach($data as $dat){
                                      ?>
                                      <tr id="hover">   
                                          <td > <?php echo $dat['id']     ?></td> 
                                          <td> <?php echo $dat['seccion'] ?></td>
                                          <td> <?php echo $dat['nombre']   ?> </td>
                                          <td> <?php echo $dat['descripcion']   ?> </td>
                                          <td> <?php echo $dat['sintoma']   ?> </td>
                                          <td> <?php echo $dat['solucion']   ?> </td>
                                          <td> <?php echo $dat['persona']   ?> </td>
                                          <td>
                                        <div class="text-center">
                                                  <div class="btn-group">
                                                      <button class="btn btn-outline-primary btnEditar" title="Editar">
                                                        <i class="fa fa-edit"></i>
                                                      </button><!--Al boton editar seran muchos generados dinamicamente por JS y se le agrega clase en ves id -->
                                                      <button class="btn btn-outline-danger btnEliminar" title="Eliminar">
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
                                  <label for="nombre" class="col-form-label">Sección:</label>
                                  <input required type="text" class="form-control" id="seccion" placeholder="Sección">
                                </div>
                                <div class="form-group">
                                  <label for="calle" class="col-form-label">Nombre:</label>
                                  <input required type="text" class="form-control" id="nombre" placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                  <label for="numero" class="col-form-label">Descripción:</label>
                                  <input required type="text" class="form-control" id="descripcion" placeholder="Descripción">
                                </div>
                                <div class="form-group">
                                  <label for="colonia" class="col-form-label">Sintoma:</label>
                                  <input required type="text" class="form-control" id="sintoma" placeholder="Sintoma">
                                </div>
                                <div class="form-group">
                                  <label for="municipio" class="col-form-label">Solución:</label>
                                  <input required type="text" class="form-control" id="solucion" placeholder="Solución">
                                </div>
                                <div class="form-group">
                                  <label for="estado" class="col-form-label">Persona:</label>
                                  <input required type="text" class="form-control" id="persona" placeholder="Persona">
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
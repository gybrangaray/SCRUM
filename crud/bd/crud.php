<?php
include_once  "../bd/conexion.php";   //llamar a nuestra conexion 
$objeto = new Conexion();
$conexion = $objeto->Conectar();  //llamando a la método Conectar de la clase Conexion archivo "conexion.php"

//Resepción de los parametros que vienen desde ajax "Datos enviados entre metodo POST situado en el archivo main.js"
//Se aplica el formato con isset(deterimna si una variable esta definida y no es nula)
                                                                //aquí en ALTA no recibimos id por que es autoincrementable
$nombre =  (isset($_POST['nombre'])) ? $_POST['nombre'] : ''; // Si es verdadero recibimos nombre y vacio si no lo es 
$calle =  (isset($_POST['calle'])) ? $_POST['calle'] : '';  // antes del signo de interrogación es la condición
$numero =  (isset($_POST['numero'])) ? $_POST['numero'] : '';  //lo que se ejecuta despues del signo es si es verdadero y luego de los dos puntos si es falso 
$colonia =  (isset($_POST['colonia'])) ? $_POST['colonia'] : '';
$municipio =  (isset($_POST['municipio'])) ? $_POST['municipio'] : '';
$estado =  (isset($_POST['estado'])) ? $_POST['estado'] : '';
$postal =  (isset($_POST['postal'])) ? $_POST['postal'] : '';
$pais =  (isset($_POST['pais'])) ? $_POST['pais'] : '';  
$edad =  (isset($_POST['edad'])) ? $_POST['edad'] : '';  
$curp =  (isset($_POST['curp'])) ? $_POST['curp'] : '';
$opcion =  (isset($_POST['opcion'])) ? $_POST['opcion'] : ''; 
$id =  (isset($_POST['id'])) ? $_POST['id'] : ''; 

switch($opcion){  //opcion es lo que estamos recibiendo de nuestro archivo main.js y nos dira si es ALTA, MODIFICACIÓN ó BAJA
    case 1://ALTA 
        $consulta = "INSERT INTO personas (nombre,calle,numero,colonia,municipio,estado,postal,pais,edad,curp) VALUES ('$nombre',' $calle',' $numero',' $colonia',' $municipio',' $estado',' $postal',' $pais' , '$edad', '$curp' )"; 
        $resultado = $conexion->prepare($consulta);//se prepara la consulta
        $resultado->execute();  //Ejecutamos el resultado
        
        $consulta = "SELECT id, nombre,calle,,numero,colonia,municipio,estado,postal,pais, edad, curp FROM personas ORDER BY id DESC LIMIT 1"; 
        $resultado = $conexion->prepare($consulta);//se prepara la consulta
        $resultado->execute();  //Ejecutamos el resultado  
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
    break;

    case 2: //MODIFICACION
        $consulta = "UPDATE personas SET nombre='$nombre', calle='$calle', numero='$numero', colonia='$colonia', municipio='$municipio', estado='$estado',postal='$postal', pais='$pais', edad='$edad', curp='$curp' WHERE id='$id' "; 
        $resultado = $conexion->prepare($consulta);//se prepara la consulta
        $resultado->execute();  //Ejecutamos el resultado

        $consulta = "SELECT id, nombre,calle,numero,colonia,municipio,estado,postal pais, edad, curp FROM personas WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);//se prepara la consulta
        $resultado->execute();  //Ejecutamos el resultado  
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);     
    break;

    case 3: //BAJA
        $consulta = "DELETE FROM personas WHERE id='$id'";
        $resultado = $conexion->prepare($consulta);//se prepara la consulta
        $resultado->execute();  //Ejecutamos el resultado 
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);  
     break;

}


print json_encode($data, JSON_UNESCAPED_UNICODE); //Enviar el array final en formato json a nuestro ajax en el archivo "main.js"
$consulta = NULL;  //cerramos conección 



?>
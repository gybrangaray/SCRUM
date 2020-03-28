<?php

session_start(); //se inicia la sesion entre el usuario y el servidor y permite acceder a los valores guardados en las variables de sesión

include_once 'conexion.php'; //sentencia para incluir archivo conexion.php
$objeto = new Conexion();
$conexion = $objeto->Conectar(); //cada vez que se necesite conectar a la base de datos llamaremos a esta variable $conexion
    
//Resepción de datos enviados mediante el metodo POST desde ajax situado en archivo "codigo.js"

$usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';   //Control de variables por el metodo POST
$contraseña = (isset($_POST['contraseña'])) ? $_POST['contraseña'] : '';  //isset determina si una variable esta definida y no es nula

$pass = md5($contraseña);   //Encriptacion de la clave enviada por el usuario para compararla con la clave encriptada y almacenada en la base de datos

$consulta = " SELECT * FROM usuarios WHERE usuario='$usuario' AND contraseña='$pass' ";  //sentencia SQL
$resultado = $conexion->prepare($consulta);   //se prepara la consulta
$resultado->execute();  //se ejecuta el resultado

    if($resultado->rowCount() >=1){   //este metodo rowCount devuelve el numero de filas afectadas por la sentencia SQL
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);   
        $_SESSION["s_usuario"] = $usuario;   //Variables de sesión
    }else{
        $_SESSION["s_usuario"] = null;
        $data = null; //se devuelve a ajax
    }
print json_encode($data);
$conexion = null; //se cierra la conexion con la base de datos
?>
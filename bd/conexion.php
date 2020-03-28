<?php
    class Conexion{  //clase Conexion
        public static function Conectar(){  //metodo Conectar
            define('servidor', 'localhost');
            define('nombre_bd', 'login');
            define('usuario', 'root');
            define('contraseña', '');
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
            
            try{
                $conexion = new PDO("mysql:host=".servidor.";dbname=".nombre_bd, usuario, contraseña, $opciones);
                return $conexion;
            }catch(Exception $e){
                die("El error de conexión: ".$e->getMessage());
            }
        }
    }
?>
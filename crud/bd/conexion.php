<?php     //conexion con simulacion PDO (Php Data Object)
    class Conexion{  //clase Conexion
        public static function Conectar(){  //metodo Conectar
            define('servidor', 'localhost'); // Se definen los parametros para que el programa sepa como conectarse
            define('nombre_bd', 'crud');
            define('usuario', 'root');
            define('contraseña', '');
            $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');  //variable opciones "arreglo con parametros de las conexiones PDO"
            
            try{ //Manejo de exepciones
                $conexion = new PDO("mysql:host=".servidor."; dbname=".nombre_bd, usuario, contraseña, $opciones);
                return $conexion;
            }catch(Exception $e){
                die("El error de conexión: ".$e->getMessage());
            }
        }
    }
?>


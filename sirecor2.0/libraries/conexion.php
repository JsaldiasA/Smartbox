<?php
    require_once "../config/config.php";
    class Conection{
        public static function conect(){
            $mysql = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
            $mysql->set_charset(DB_CHARSET);
            if(mysqli_connect_errno()){
                echo "Error en la conexión: ".mysqli_connect_errno();
            }//else{
                //echo "Coneción exitosa";

            //}
            return $mysql;
        }
        

    }
    //print_r(Conection::conect());

?>
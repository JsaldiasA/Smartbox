<?php
    require_once "../libraries/conexion.php";
    class RiegoModel{
        private $conection;
        function __construct(){
            $this-> conection = new Conection();
            $this-> conection= $this->conection->conect();

        }

    

        public function getRiego(){
            $arrRegistros = array ();
            $rs = $this-> connection->query("CALL riegoPbi()");

            while($obj = $rs->fetch_object()){
                array_push($arrRegistros,$obj);
            }
            return $arrRegistros;

    }

    }

?>
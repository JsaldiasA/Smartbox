<?php
class comandos_milesightDbEntity {
	
public $Id;
public $Nombre;
public $Comando_HEX;
public $Comando_Base64;
public $Descripcion;
	    
  function __construct($Id,
$Nombre,
$Comando_HEX,
$Comando_Base64,
$Descripcion ) {
	  		
	  		$this->Id = $Id;
		$this->Nombre = $Nombre;
		$this->Comando_HEX = $Comando_HEX;
		$this->Comando_Base64 = $Comando_Base64;
		$this->Descripcion = $Descripcion;
  }
	
 function get_Id() { return $this->Id; }
function get_Nombre() { return $this->Nombre; }
function get_Comando_HEX() { return $this->Comando_HEX; }
function get_Comando_Base64() { return $this->Comando_Base64; }
function get_Descripcion() { return $this->Descripción; }
  	

}
//testing 
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","4","2","100%");
//echo "ok".$apple->get_Id_UnidadTipo();

?>
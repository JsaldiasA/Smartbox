<?php
class unidadtipoDbEntity {

public $Id;
public $Nombre;
public $Descripcion;

	
  function __construct($Id,
$Nombre,
$Descripcion)
  {
	$this->Id = $Id;
	$this->Nombre = $Nombre;
	$this->Descripcion = $Descripcion;
  }
	function get_Id() { return $this->Id; }
	function get_Nombre() { return $this->Nombre; }
	function get_Descripcion() { return $this->Descripcion; }
  	

}
//testing 
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","4","2","100%");
//echo "ok".$apple->get_Id_UnidadTipo();

?>
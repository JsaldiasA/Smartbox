<?php
class unidadtipoDbEntity {

public $Id;
public $Nombre;
public $Descripcion;
public $IsMilesight;

	
  function __construct($Id,
$Nombre,
$Descripcion,
$IsMilesight)
  {
	$this->Id = $Id;
	$this->Nombre = $Nombre;
	$this->Descripcion = $Descripcion;
	$this->IsMilesight = $IsMilesight;
  }
	function get_Id() { return $this->Id; }
	function get_Nombre() { return $this->Nombre; }
	function get_Descripcion() { return $this->Descripcion; }
	function get_IsMilesight() { return $this->IsMilesight; }

}
//testing 
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","4","2","100%");
//echo "ok".$apple->get_Id_UnidadTipo();

?>
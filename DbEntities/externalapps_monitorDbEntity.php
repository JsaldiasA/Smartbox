<?php
class externalapps_monitorDbEntity {

public $id;
public $LastUpdate;
public $AppName;
public $Description;

	
  function __construct($id,
$LastUpdate,
$AppName,
$Description)
  {
	$this->id = $id;
	$this->LastUpdate = $LastUpdate;
	$this->AppName = $AppName;
	$this->Description = $Description;
  }
	function get_id() { return $this->id; }
	function get_LastUpdate() { return $this->LastUpdate; }
	function get_AppName() { return $this->AppName; }
	function get_Description() { return $this->Description; }

}
//testing 
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","4","2","100%");
//echo "ok".$apple->get_Id_UnidadTipo();

?>
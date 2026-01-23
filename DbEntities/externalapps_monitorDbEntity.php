<?php
class externalapps_monitorDbEntity {

public $Id;
public $LastUpdate;
public $AppName;
public $Description;

	
	function get_id() { return $this->Id; }
	function get_LastUpdate() { return $this->LastUpdate; }
	function get_AppName() { return $this->AppName; }
	function get_Description() { return $this->Description; }
  	function DiffBetweenNow_and_LastUpdate() {
	
	date_default_timezone_set('America/Santiago');
	$FechaActual= date_create(date("Y-m-d H:i:s"));
    $FechaSQLrow= date_create($this->get_LastUpdate());
	$UltimaAct= date_diff($FechaActual,$FechaSQLrow);
	  
	if ($UltimaAct->format("%a")=="0")
	{	
	   if ($UltimaAct->format("%h")=="0")
		{
			$UltimaActROW=$UltimaAct->format("%i Min");
		}
		else {$UltimaActROW=$UltimaAct->format("%h Horas");}
		}
	else {$UltimaActROW=$UltimaAct->format("%a Dias");}
	  
	return $UltimaActROW;
  }	
}
//testing 
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","4","2","100%");
//echo "ok".$apple->get_Id_UnidadTipo();

?>
<?php
class unidadDbEntity {
	
public $id;
public $Serie;
public $tag;
public $Ubicacion;
public $numero;
public $UltimaActualizacion;
public $Volumen;
public $Estado;
public $id_unidadTipo;
public $InvertirEntrada;
public $BatNivel;
public $Temperatura;
public $Humedad;
public $EC;
	    
function __construct($id,
$Serie,
$tag,
$Ubicacion,
$numero,
$UltimaActualizacion,
$Volumen,
$Estado,
$id_unidadTipo,
$InvertirEntrada,
$BatNivel,
$Temperatura,
$Humedad,
$EC)

{ 		
  $this->id = $id;
  $this->Serie = $Serie;
  $this->tag = $tag;
  $this->Ubicacion = $Ubicacion;
  $this->numero = $numero;
  $this->UltimaActualizacion = $UltimaActualizacion;
  $this->Volumen = $Volumen;
  $this->Estado = $Estado;
  $this->id_unidadTipo = $id_unidadTipo;
  $this->InvertirEntrada = $InvertirEntrada;
  $this->BatNivel = $BatNivel;
  $this->Temperatura = $Temperatura;
  $this->Humedad = $Humedad;
  $this->EC = $EC;
}

  function get_id() { return $this->id; }
  function get_Serie() { return $this->Serie; }
  function get_tag() { return $this->tag; }
  function get_Ubicacion() { return $this->Ubicacion; }
  function get_numero() { return $this->numero; }
  function get_UltimaActualizacion() { return $this->UltimaActualizacion; }
  function get_Volumen() { return $this->Volumen; }
  function get_Estado() { return $this->Estado; }
  function get_id_unidadTipo() { return $this->id_unidadTipo; }
  function get_InvertirEntrada() { return $this->InvertirEntrada; }
  function get_BatNivel() { return $this->BatNivel; }
  function get_Temperatura() { return $this->Temperatura; }
  function get_Humedad() { return $this->Humedad; }
  function get_EC() { return $this->EC; }
  
  function UltimaActualizacion() {
	
	date_default_timezone_set('America/Santiago');
	$FechaActual= date_create(date("Y-m-d H:i:s"));
    $FechaSQLrow= date_create($this->get_UltimaActualizacion());
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
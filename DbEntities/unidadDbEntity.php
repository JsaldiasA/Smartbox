<?php
class unidadDbEntity {
	
public $Id;
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
public $VolMax;
public $FactorFlujometro;
public $Id_Last_RegistroDiario;
public $Id_bateriaTipo;
public $BateriaDate;
	    

  function get_id() { return $this->Id; }
  function get_Serie() { return $this->Serie; }
  function get_tag() { return $this->tag; }
  function get_Ubicacion() { return $this->Ubicacion; }
  function get_numero() { return $this->numero; }
  function get_UltimaActualizacion() { return $this->UltimaActualizacion; }
  function get_Volumen() { return $this->Volumen; }
  function get_Estado() 
  { 
    if($this->InvertirEntrada == 1)
    {
      switch ($this->Estado) {
      case "ALTO":
        return 'BAJO'; 
        break;
      case "NULL":
        return 'MEDIO'; 
        break;
      case "BAJO":
        return 'ALTO'; 
        break;
      default:
        // Code if no match is found
        break;
      }
    } 
    return $this->Estado; 
  }
  
  function get_id_unidadTipo() { return $this->id_unidadTipo; }
  function get_InvertirEntrada() { return $this->InvertirEntrada; }
  function get_BatNivel() { return $this->BatNivel; }
  function get_Temperatura() { return $this->Temperatura; }
  function get_Humedad() { return $this->Humedad; }
  function get_EC() { return $this->EC; }
  function get_VolMax() { return $this->VolMax; }
  function get_FactorFlujometro() { return $this->FactorFlujometro; }
  function get_VolumenForMilesight( )
  {
    $factor = floatval($this->FactorFlujometro);
    $volumen = intval($this->Volumen);
    return ($factor*$volumen)/60;
  }

  // function get_CaudalForMilesight( )
  // {
  
    // $factor = floatval($this->FactorFlujometro);
    // $caudal = intval($this->UltimoRegistro->get_CAUDAL());
    // return ($factor*$caudal)/60;
  // }
  
  function DiffBetweenNow_and_UltimaActualizacion() {
	
	date_default_timezone_set('America/Santiago');
	$FechaActual= date_create(date("Y-m-d H:i:s"));
    $FechaSQLrow= date_create($this->get_UltimaActualizacion());
	$UltimaAct= date_diff($FechaActual,$FechaSQLrow);
	  
	if ($UltimaAct->format("%a")=="0")
	{	
	   if ($UltimaAct->format("%h")=="0")
		{
			$UltimaActROW= ($UltimaAct->format("%i") > 30) ? $UltimaAct->format('<a style="color: yellow;"> %i Min</a>') : $UltimaAct->format('<a style="color: green;"> %i Min</a>')  ;
		}
		else {$UltimaActROW=$UltimaAct->format('<a style="color: red;">%h Horas</a>');}
		}
	else {$UltimaActROW=$UltimaAct->format('<a style="color: red;">%a Dias');}
	  
	return $UltimaActROW;
  }	
  	

}
//testing 
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","4","2","100%");
//echo "ok".$apple->get_Id_UnidadTipo();

?>
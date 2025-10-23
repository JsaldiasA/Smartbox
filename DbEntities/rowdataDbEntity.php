<?php
class rowdataDbEntity {
	
  public $Id;
  public $Nombre;
  public $Tag;
  public $Numero;
  public $UltimaActualizacion;
  public $Volumen;
  public $Estado;
  public $Id_UnidadTipo;
  public $InvertirEntrada;
  public $BatNivel;
	    
  function __construct($Id,$Nombre,$Tag,$Numero,$UltimaActualizacion,$Volumen,$Estado,$Id_UnidadTipo,$InvertirEntrada,$BatNivel ) {
	  		
	  		$this->Id = $Id;
	    	$this->Nombre = $Nombre;
		 	$this->Tag = $Tag;
	  		$this->Numero = $Numero;
  			$this->UltimaActualizacion = $UltimaActualizacion;
	  		$this->Volumen = $Volumen;
  			$this->Estado = $Estado;
  			$this->Id_UnidadTipo = $Id_UnidadTipo;
  			$this->InvertirEntrada = $InvertirEntrada;
  			$this->BatNivel = $BatNivel;
  }
  function get_Id() {
    return $this->Id;
  }
  
  function get_Nombre() {
    return $this->Nombre;
  }
	
  function get_Tag() {
    return $this->Tag;
  }
	
  function get_Numero() {
    return $this->Numero;
  }		
	
  function get_UltimaActualizacion() {
    return $this->UltimaActualizacion;
  }

  function get_Volumen() {
    return $this->Volumen;
  }

  function get_Estado() {
    return $this->Estado;
  }

  function get_Id_UnidadTipo() {
    return $this->Id_UnidadTipo;
  }

  function get_InvertirEntrada() {
    return $this->InvertirEntrada;
  }

  function get_BatNivel() {
    return $this->BatNivel;
  }
  
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
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","1","2","100%");
//echo "ok".$apple->get_Tag();

?>
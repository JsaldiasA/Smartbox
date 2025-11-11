<?php
class unidadeslastortolasDbEntity {
	
  public $id;
  public $unidad_id;
  public $ESTADO;
  public $VOLUMEN;
  public $CAUDAL;
  public $SENAL;
  public $VOLTAJE;
  public $DATETIME;
	    
  function __construct(
  $id,
  $unidad_id,
  $ESTADO,
  $VOLUMEN,
  $CAUDAL,
  $SENAL,
  $VOLTAJE,
  $DATETIME,)
  
  {		
  $this->id = $id;
  $this->unidad_id = $unidad_id;
  $this->ESTADO = $ESTADO;
  $this->VOLUMEN = $VOLUMEN;
  $this->CAUDAL = $CAUDAL;
  $this->SENAL = $SENAL;
  $this->VOLTAJE = $VOLTAJE;
  $this->DATETIME = $DATETIME;
  }

  function get_id()
  { return $this->id; }

  function get_unidad_id()
  { return $this->unidad_id; }

  function get_ESTADO()
  { return $this->ESTADO; }

  function get_VOLUMEN()
  { return $this->VOLUMEN; }

  function get_CAUDAL()
  { return $this->CAUDAL; }

  function get_SENAL()
  { return $this->SENAL; }

  function get_VOLTAJE()
  { return $this->VOLTAJE; }

  function get_DATETIME()
  { return $this->DATETIME; }
  	
}

?>
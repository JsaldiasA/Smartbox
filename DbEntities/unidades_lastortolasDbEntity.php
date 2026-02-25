<?php
class unidades_lastortolasDbEntity {
	
  public $Id;
  public $unidad_id;
  public $ESTADO;
  public $VOLUMEN;
  public $CAUDAL;
  public $SENAL;
  public $VOLTAJE;
  public $DATETIME;
	  	
  function get_CAUDALforHtmlTable() { 
    switch ($this->CAUDAL) {
    case '-999':
        return '<p class="text-danger"> <8 <i class="bi bi-exclamation-triangle-fill"></i> </>';

    case '999':
        return '<p class="text-danger"> >140 <i class="bi bi-exclamation-triangle-fill"></i> </>';

    default:
        return $this->CAUDAL; 
      }
    
  }
}

?>
<?php
class checklistDbEntity {

	public $Id;
	public $VoltajeReguladorBat;
	public $VoltajeReguladorMCU;
	public $SmartBox;
	public $SMSenvio;
	public $SMSrecibo;
	public $Flujometro;
	public $Solenoide;
	public $SensorNivelBajo;
	public $SensorNivelAlto;
	public $VoltajeMCU;
	public $BateriaTest;
	public $id_checklistMotivo;
	public $Observaciones;
	public $id_unidadtipo;
	public $URL_foto;
	public $id_unidad;
	public $Fecha;
	public $TecnicoResponsable;

	
  function __construct($Id,
$VoltajeReguladorBat,
$VoltajeReguladorMCU,
$SmartBox,
$SMSenvio,
$SMSrecibo,
$Flujometro,
$Solenoide,
$SensorNivelBajo,
$SensorNivelAlto,
$VoltajeMCU,
$BateriaTest,
$id_checklistMotivo,
$Observaciones,
$id_unidadtipo,
$URL_foto,
$id_unidad,
$Fecha,
$TecnicoResponsable	 ) {
	 $this->Id = $Id;
	$this->VoltajeReguladorBat = $VoltajeReguladorBat;
	$this->VoltajeReguladorMCU = $VoltajeReguladorMCU;
	$this->SmartBox = $SmartBox;
	$this->SMSenvio = $SMSenvio;
	$this->SMSrecibo = $SMSrecibo;
	$this->Flujometro = $Flujometro;
	$this->Solenoide = $Solenoide;
	$this->SensorNivelBajo = $SensorNivelBajo;
	$this->SensorNivelAlto = $SensorNivelAlto;
	$this->VoltajeMCU = $VoltajeMCU;
	$this->BateriaTest = $BateriaTest;
	$this->id_checklistMotivo = $id_checklistMotivo;
	$this->Observaciones = $Observaciones;
	$this->id_unidadtipo = $id_unidadtipo;
	$this->URL_foto = $URL_foto;
	$this->id_unidad = $id_unidad;
	$this->Fecha = $Fecha;
	$this->TecnicoResponsable = $TecnicoResponsable;
  }
	 function get_Id() { return $this->Id; }
	function get_VoltajeReguladorBat() { return $this->VoltajeReguladorBat; }
	function get_VoltajeReguladorMCU() { return $this->VoltajeReguladorMCU; }
	function get_SmartBox() { return $this->SmartBox; }
	function get_SMSenvio() { return $this->SMSenvio; }
	function get_SMSrecibo() { return $this->SMSrecibo; }
	function get_Flujometro() { return $this->Flujometro; }
	function get_Solenoide() { return $this->Solenoide; }
	function get_SensorNivelBajo() { return $this->SensorNivelBajo; }
	function get_SensorNivelAlto() { return $this->SensorNivelAlto; }
	function get_VoltajeMCU() { return $this->VoltajeMCU; }
	function get_BateriaTest() { return $this->BateriaTest; }
	function get_id_checklistMotivo() { return $this->id_checklistMotivo; }
	function get_Observaciones() { return $this->Observaciones; }
	function get_id_unidadtipo() { return $this->id_unidadtipo; }
	function get_URL_foto() { return $this->URL_foto; }
	function get_id_unidad() { return $this->id_unidad; }
	function get_Fecha() { return $this->Fecha; }
  	function get_TecnicoResponsable() { return $this->TecnicoResponsable; } 

}
//testing 
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","4","2","100%");
//echo "ok".$apple->get_Id_UnidadTipo();

?>
<?php
class eventosDbEntity {

	public $Id;
	public $UNIDAD;
	public $USUARIO1;
	public $USUARIO2;
	public $USUARIO3;
	public $USUARIO4;
	public $ADMIN;
	public $MANTENCION;
	public $INTERNET;
	public $VerCodigo;
	public $LVOLTAJE;
	public $INV;
	public $VOLUMEN_MAX;
	public $TIMESTAMP;
	public $TIPO;
	public $TipoBat;

	function get_UNIDAD() { return $this->UNIDAD; }
	function get_USUARIO1() { return $this->USUARIO1; }
	function get_USUARIO2() { return $this->USUARIO2; }
	function get_USUARIO3() { return $this->USUARIO3; }
	function get_USUARIO4() { return $this->USUARIO4; }
	function get_ADMIN() { return $this->ADMIN; }
	function get_MANTENCION() { return $this->MANTENCION; }
	function get_INTERNET() { return $this->INTERNET; }
	function get_VerCodigo() { return $this->VerCodigo; }
	function get_LVOLTAJE() { return $this->LVOLTAJE; }
	function get_INV() { return $this->INV; }
	function get_VOLUMEN_MAX() { return $this->VOLUMEN_MAX; }
	function get_TIMESTAMP() { return $this->TIMESTAMP; }
	function get_TIPO() { return $this->TIPO; }
	function get_TipoBat() { return $this->TipoBat; }
}
//testing
//$apple = new unidadDbEntity("999","Caja","Cmile","99292312","1 min","10","on","4","2","100%");
//echo "ok".$apple->get_Id_UnidadTipo();

?>
<?php

class smstounidadesDbEntity
  {
    public $Id;
    public $Id_unidad;
    public $SMS;
    public $Recibido;
    public $CreateTime;
    public $ReceivedTime;
	    
    function __construct (
      $Id,
      $Id_unidad,
      $SMS,
      $Recibido,
      $CreateTime,
      $ReceivedTime)
      { 		
        $this->Id = $Id;
        $this->Id_unidad = $Id_unidad;
        $this->SMS = $SMS;
        $this->Recibido = $Recibido;
        $this->CreateTime = $CreateTime;
        $this->ReceivedTime = $ReceivedTime;
      }

    function get_Id() { return $this->Id; }
    function get_Id_unidad() { return $this->Id_unidad; }
    function get_SMS() { return $this->SMS; }
    function get_Recibido() { return $this->Recibido; }
    function get_CreateTime() { return $this->CreateTime; }
    function get_ReceivedTime() { return $this->ReceivedTime; }
  }

?>
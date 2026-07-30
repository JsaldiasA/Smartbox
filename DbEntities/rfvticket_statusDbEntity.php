<?php

class rfvticket_statusDbEntity
  {
    public $Id;
    public $Estado;
    public $Descripcion;

    function get_Id()
      {
        return $this->Id;
      }

    function get_Estado()
      {
        return $this->Estado;
      }

    function get_Descripcion()
      {
        return $this->Descripcion;
      }
  }

?>
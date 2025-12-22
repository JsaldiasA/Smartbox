<?php
class ticket_statusDbEntity
{
  public $Id;
  public $Estado;
  public $Descripcion;
	    
  function __construct
  (
    $Id,
    $Estado,
    $Descripcion,
  )

  { 		
    $this->Id= $Id;
    $this->Estado = $Estado;
    $this->Descripcion = $Descripcion;
  }

  function get_Id() {return $this->Id;}
  function get_Estado() {return $this->Estado;}
  function get_Descripcion() {return $this->Descripcion;}
}

?>
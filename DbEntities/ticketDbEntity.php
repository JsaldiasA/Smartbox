<?php
class ticketDbEntity
{
  public $Id;
  public $Nombre;
  public $Ubicacion;
  public $Descripcion;
  public $Usuario;
  public $FechaApertura;
  public $FechaCierre;
  public $Id_TicketStatus;
	    
  function __construct
  (
    $Id,
    $Nombre,
    $Ubicacion,
    $Descripcion,
    $Usuario,
    $FechaApertura,
    $FechaCierre,
    $Id_TicketStatus
  )

  { 		
    $this->Id= $Id;
    $this->Nombre = $Nombre;
    $this->Ubicacion = $Ubicacion;
    $this->Descripcion = $Descripcion;
    $this->Usuario = $Usuario;
    $this->FechaApertura = $FechaApertura;
    $this->FechaCierre = $FechaCierre;
    $this->Id_TicketStatus = $Id_TicketStatus;
  }

  function get_Id() {return $this->Id;}
  function get_Nombre() {return $this->Nombre;}
  function get_Ubicacion() {return $this->Ubicacion;}
  function get_Descripcion() {return $this->Descripcion;}
  function get_Usuario() {return $this->Usuario;}
  function get_FechaApertura() {return $this->FechaApertura;}
  function get_FechaCierre() {return $this->FechaCierre;}
  function get_Id_TicketStatus() {return $this->Id_TicketStatus;}
}

?>
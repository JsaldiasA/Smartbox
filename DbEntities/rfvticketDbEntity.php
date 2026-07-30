<?php

class rfvticketDbEntity
  {
    public $Id;
    public $Nombre;
    public $Descripcion;
    public $Usuario;
    public $FechaInicio;
    public $FechaCierre;
    public $Id_TicketPriority;
    public $Id_TicketStatus;
    public $MotivoDeCierre;

    function get_Id() {return $this->Id;}
    function get_Nombre() {return $this->Nombre;}
    function get_Descripcion() {return $this->Descripcion;}
    function get_Usuario() {return $this->Usuario;}
    function get_FechaInicio() {return $this->FechaInicio;}
    function get_FechaCierre() {return $this->FechaCierre;}
    function get_Id_TicketPriority() {return $this->Id_TicketPriority;}
    function get_Id_TicketStatus() {return $this->Id_TicketStatus;}
  }

?>
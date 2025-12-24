<?php

class ticket_priorityDbEntity
  {
    public $Id;
    public $Prioridad;
	    
    function __construct ($Id, $Prioridad)
      { 		
        $this->Id = $Id;
        $this->Prioridad = $Prioridad;
      }

    function get_Id()
      {
        return $this->Id;
      }

    function get_Prioridad()
      {
        return $this->Prioridad;
      }
  }

?>
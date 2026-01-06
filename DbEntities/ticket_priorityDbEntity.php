<?php

class ticket_priorityDbEntity
  {
    public $Id;
    public $Prioridad;

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
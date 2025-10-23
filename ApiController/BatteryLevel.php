<?php
class BatteryLevel {
	
  public $Level;
  public $HtmlTableField;
	    
  function __construct($level) {
	  		
	  		$this->level = $level;
	  
	  		$ImgUrl;
	  		if (strpos($level, ".") !== false) {
   				$this->HtmlTableField = 'NULL';
				return;
			}	
	        elseif($level < 101 && $level >= 80){	
                $ImgUrl = '/images/BatFull.jpg';
                }
            elseif ($level < 80 && $level >= 30){
               $ImgUrl ='/images/BatMedio.jpg';
                }
         	elseif($level < 30 && $level >= 10){
                $ImgUrl= '/images/BatBajo.jpg'; 
                }
			elseif($level < 10 && $level >= 1){
                $ImgUrl = '/images/BatEmpty.jpg'; 
            }
		 	elseif($level == 999){  
				$this->HtmlTableField = '<b><font color="red">Parametro Erroneo!</font></b>';
				return;
			 }
            else{              
                $this->HtmlTableField = 'NULL';
				return;
			}
	  
	  		$this->HtmlTableField = '<div  class="d-inline" >'.$level.'%</div><img  src="'.$ImgUrl.'" width="30" height="20">';
	
  }
  function get_level() {
    return $this->level;
  }
  function get_HtmlTableField() {
	  
    return $this->HtmlTableField;
  }
}
//testing 
//$apple = new BatteryLevel("999");
//echo "ok".$apple->get_HtmlTableField();

?>
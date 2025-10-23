<?php

$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath.'/DbEntities/unidadDbEntity.php';
require_once $sitebasepath.'/DbEntities/unidadtipoDbEntity.php';
require_once $sitebasepath.'/DbEntities/checklistDbEntity.php';
require_once $sitebasepath.'/DbEntities/checklistmotivoDbEntity.php';
require_once $sitebasepath.'/DbEntities/comandos_milesightDbEntity.php';
require_once $sitebasepath.'/DbEntities/eventosDbEntity.php';
require_once $sitebasepath.'/config/DbSirecorConfig.php';	

class Model {
	

  	function __construct( ) {
		
  	}
	
		function get_unidades()
	{ 			
		$sql = "SELECT * FROM `unidad`";
		$result = $this->executeSQL($sql);
		
		$Unidades = [];
			
		if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) 
		{
	    $Unidades[] = new 			unidadDbEntity($row["id"],$row["Nombre"],$row["tag"],$row["Numero"],$row["UltimaActualizacion"],$row["Volumen"],$row["Estado"],$row["id_unidadTipo"],$row["InvertirEntrada"],$row["BatNivel"]);
//cuidado con el casing, distinge de mayusculas y minusculas
		}
		}
		return $Unidades;
			 
	}
	
	function get_unidadtipos( ) 
	{ 			
		$sql = "SELECT * FROM `unidadtipo`";
		$result = $this->executeSQL($sql);
		
		$TiposDeUnidades = [];
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) 
			{
				$TiposDeUnidades[] = new unidadtipoDbEntity($row["Id"],$row["Nombre"],$row["Descripcion"]);
			}
		}
		return $TiposDeUnidades;
			 
	}
	
	function get_checklists( ) 
	{ 			
		$sql = "SELECT * FROM `checklist`";
		$result = $this->executeSQL($sql);
		
		$checklists = [];
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) 
			{
				$checklists[] = new checklistDbEntity($row["Id"],
				$row["VoltajeReguladorBat"],
				$row["VoltajeReguladorMCU"],
				$row["SmartBox"],
				$row["SMSenvio"],
				$row["SMSrecibo"],
				$row["Flujometro"],
				$row["Solenoide"],
				$row["SensorNivelBajo"],
				$row["SensorNivelAlto"],
				$row["VoltajeMCU"],
				$row["BateriaTest"],
				$row["id_checklistMotivo"],
				$row["Observaciones"],
				$row["id_unidadtipo"],
				$row["URL_foto"],
				$row["id_unidad"],
				$row["Fecha"],
				$row["TecnicoResponsable"]);
			}
		}
		return $checklists;		 
	}
	
	function get_checklistmotivos( ) 
	{ 			
		$sql = "SELECT * FROM `checklistmotivo`";
		$result = $this->executeSQL($sql);
		
		$checklistmotivos = [];
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) 
			{
				$checklistmotivos[] = new checklistmotivoDbEntity($row["id"],$row["Nombre"],$row["Descripcion"]);
			}
		}
		return $checklistmotivos;		 
	}
	
	function get_eventos() 
	{ 			
		$sql = "SELECT * FROM `eventos`";
		$result = $this->executeSQL($sql);
		
		$eventos = [];
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) 
			{
				$eventos[] = new eventosDbEntity($row["UNIDAD"],
				$row["USUARIO1"],
				$row["USUARIO2"],
				$row["USUARIO3"],
				$row["USUARIO4"],
				$row["ADMIN"],
				$row["MANTENCION"],
				$row["INTERNET"],
				$row["VerCodigo"],
				$row["LVOLTAJE"],
				$row["INV"],
				$row["VOLUMEN MAX"],
				$row["TIMESTAMP"],
				$row["TIPO"]);
			}
		}
		return $eventos;		 
	}
	
		function get_comandos_milesight() 
	{ 			
		$sql = "SELECT * FROM `comandos_milesight`";
		$result = $this->executeSQL($sql);
		
		$comandos_milesight = [];
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) 
			{
				$comandos_milesight[] = new comandos_milesightDbEntity($row["Id"],
				$row["Nombre"],
				$row["Comando_HEX"],
				$row["Comando_Base64"],
				$row["Descripcion"]);
			}
		}
		return $comandos_milesight;	 
	}
	
	function comando_milesightByNombre( $Nombre ) 
	{ 			
		$comandos_milesight = $this->get_comandos_milesight();
			
		foreach ($comandos_milesight as $comando) {
 			if($comando->get_Nombre() == $Nombre )
			{	
			return $comando;
			}
		}		
		return null;
			 
	}
	
	function UnidadTipoById( $Id_UnidadTipo ) 
	{ 			
		$unidadtipos = $this->get_unidadtipos();
			
		foreach ($unidadtipos as $unidadtipo) {
 			if($unidadtipo->get_Id() == $Id_UnidadTipo )
			{	
			return $unidadtipo;
			}
		}		
		return null;
			 
	}
	
	function CheckListMotivoById( $Id_ChecklistMotivo ) 
	{ 			
		$checklistmotivos = $this->get_checklistmotivos();
			
		foreach ($checklistmotivos as $checklistmotivo) {
 			if($checklistmotivo->get_id() == $Id_ChecklistMotivo )
			{	
			return $checklistmotivo;
			}
		}		
		return null;
	}
	
		function unidadByTag( $tag_unidad ) 
	{ 	
		$unidades = $this->get_unidades();
			
		foreach ($unidades as $unidad) {
 			if($unidad->get_tag() == $tag_unidad )
			{	
			return $unidad;
			}
		}		
		return null;
	}
	
	
	
	function UltimochecklistById_unidad( $Id_unidad ) 
	{ 			
	$sql = "SELECT * FROM `checklist` WHERE `id_unidad` = ".$Id_unidad." ORDER BY `Fecha` DESC LIMIT 1";
		$result = $this->executeSQL($sql);
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) 
			{
				$Ultimochecklist = new checklistDbEntity($row["Id"],
				$row["VoltajeReguladorBat"],
				$row["VoltajeReguladorMCU"],
				$row["SmartBox"],
				$row["SMSenvio"],
				$row["SMSrecibo"],
				$row["Flujometro"],
				$row["Solenoide"],
				$row["SensorNivelBajo"],
				$row["SensorNivelAlto"],
				$row["VoltajeMCU"],
				$row["BateriaTest"],
				$row["id_checklistMotivo"],
				$row["Observaciones"],
				$row["id_unidadtipo"],
				$row["URL_foto"],
				$row["id_unidad"],
				$row["Fecha"],
				$row["TecnicoResponsable"]);
			}
		}
		return $Ultimochecklist;	
		
	}
	
	function checklistById_unidad( $Id_unidad ) 
	{ 			
		$checklists = $this->get_checklists();
		$checklistsOfThisUnit= [];	
		foreach ($checklists as $checklist) {
 			if($checklist->get_id_unidad() == $Id_unidad )
			{	
			$checklistsOfThisUnit[] = $checklist;
			}
		}		
		return $checklistsOfThisUnit;
		
	}
	
		
	
	function executeSQL( $SQLscript ) 
	{ 			
		$dbConfig = new DbSirecorConfig();
		// Create connection
		$conn = new mysqli($dbConfig->get_servername(),$dbConfig->get_username(),$dbConfig->get_password(),$dbConfig->get_dbname());
		// Check connection
			if ($conn->connect_error) {
  		die("Connection failed: " . $conn->connect_error);
		}
		$sql = $SQLscript;
		$result = $conn->query($sql);

		return $result; 
	}

}

// testing
 //$model = new Model();
// $unidad = $model->UltimochecklistById_unidad(376);

// var_dump($unidad);

?>
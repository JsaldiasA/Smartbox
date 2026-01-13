<?php

$self = $_SERVER['PHP_SELF']; 
$thispath = dirname($_SERVER['PHP_SELF']);
$sitebasepath = $_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath.'/config/DbSirecorConfig.php';
require_once $sitebasepath.'/DbEntities/externalapps_monitorDbEntity.php';
require_once $sitebasepath.'/DbEntities/comandos_milesightDbEntity.php';
require_once $sitebasepath.'/DbEntities/unidadDbEntity.php';
require_once $sitebasepath.'/DbEntities/unidadtipoDbEntity.php';
require_once $sitebasepath.'/DbEntities/unidades_lastortolasDbEntity.php';
require_once $sitebasepath.'/DbEntities/checklistDbEntity.php';
require_once $sitebasepath.'/DbEntities/checklistmotivoDbEntity.php';
require_once $sitebasepath.'/DbEntities/ticketDbEntity.php';
require_once $sitebasepath.'/DbEntities/ticket_statusDbEntity.php';
require_once $sitebasepath.'/DbEntities/eventosDbEntity.php';
require_once $sitebasepath.'/DbEntities/smstounidadesDbEntity.php';
class Model
{
	function __construct()
		{

  		}

	function executeSQL($SQLscript)
		{
			$dbConfig = new DbSirecorConfig();
			$conn = new mysqli($dbConfig->get_servername(),$dbConfig->get_username(),$dbConfig->get_password(),$dbConfig->get_dbname());

			if ($conn->connect_error)
				{
  					die("Connection failed: " . $conn->connect_error);
				}

			$sql = $SQLscript;
			$result = $conn->query($sql);

			return $result;
		}
	
	function MYSQLfetchObj($SQLscript, $className)
		{

			$result = $this->executeSQL($SQLscript);

			$objects = [];

			if ($result->num_rows > 0) 
			{
   				while ($obj = mysqli_fetch_object($result, $className)) {
         		$objects[] = $obj;
    			}
			}

			return $objects;
		}	

	function get_externalapps_monitor()
		{
			$sql = "SELECT * FROM `externalapps_monitor`";
			$result = $this->executeSQL($sql);
			$externalapps_monitors = [];

			if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
						{
	    					$externalapps_monitors[] = new externalapps_monitorDbEntity
								(
									$row["id"],
									$row["LastUpdate"],
									$row["AppName"],
									$row["Description"]
								);
						}
				}

			return $externalapps_monitors;
		}

	function get_comandos_milesight()
		{
			$sql = "SELECT * FROM `comandos_milesight`";
			$result = $this->executeSQL($sql);
			$comandos_milesight = [];

			if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
						{
							$comandos_milesight[] = new comandos_milesightDbEntity
								(
									$row["Id"],
									$row["Nombre"],
									$row["Comando_HEX"],
									$row["Comando_Base64"],
									$row["Descripcion"]
								);
						}
				}

			return $comandos_milesight;
		}

	function comando_milesightByNombre($Nombre)
		{
			$comandos_milesight = $this->get_comandos_milesight();

			foreach ($comandos_milesight as $comando)
				{
 					if ($comando->get_Nombre() == $Nombre)
						{
							return $comando;
						}
				}

			return null;
		}

	function get_unidades()
		{
			$sql = "SELECT * FROM `unidad`";
			$result = $this->executeSQL($sql);
			$Unidades = [];
			$RegistrosDiarios = [];
			$RegistrosDiarios = $this->get_UltimoRegistroDiarioDeCadaUnidad();

			if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
						{
							foreach ($RegistrosDiarios as $r)
								{
									if($r->unidad_id == $row["id"] )
										{
											$UltimoRegistro = $r;
											break;
										}
								}

							$Unidades[] = new unidadDbEntity
								(
									$row["id"],
									$row["Serie"],
									$row["tag"],
									$row["Ubicacion"],
									$row["numero"],
									$row["UltimaActualizacion"],
									$row["Volumen"],
									$row["Estado"],
									$row["id_unidadTipo"],
									$row["InvertirEntrada"],
									$row["BatNivel"],
									$row["Temperatura"],
									$row["Humedad"],
									$row["EC"],
									$row["VolMax"],
									$row["FactorFlujometro"],
									$UltimoRegistro
								);	
						}
				}

			return $Unidades;
		}

	function unidadByTag($tag_unidad)
		{ 	
			$unidades = $this->get_unidades();
			
			foreach ($unidades as $unidad)
				{
 					if ($unidad->get_tag() == $tag_unidad)
						{	
							return $unidad;
						}
				}

			return null;
		}

	function get_unidadtipos()
		{
			$sql = "SELECT * FROM `unidadtipo`";
			$result = $this->executeSQL($sql);
			$TiposDeUnidades = [];

			if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
						{
							$TiposDeUnidades[] = new unidadtipoDbEntity
								(
									$row["Id"],
									$row["Nombre"],
									$row["Descripcion"],
									$row["IsMilesight"]
								);
						}
				}

			return $TiposDeUnidades;
		}

	function UnidadTipoById($Id_UnidadTipo)
		{
			$unidadtipos = $this->get_unidadtipos();

			foreach ($unidadtipos as $unidadtipo)
				{
 					if ($unidadtipo->get_Id() == $Id_UnidadTipo)
						{
							return $unidadtipo;
						}
				}

			return null;
		}

	function UnidadTipoByNombre($NombreUnidadTipo)
		{
			$unidadtipos = $this->get_unidadtipos();

			foreach ($unidadtipos as $unidadtipo)
				{
 					if ($unidadtipo->get_Nombre() == $NombreUnidadTipo)
						{
							return $unidadtipo;
						}
				}

			return null;
		}

	function get_unidades_lastortolas()
		{
			$sql = "SELECT * FROM `unidades_lastortolas` ORDER BY `id` DESC LIMIT 10000";
			return $this->MYSQLfetchObj($sql, 'unidades_lastortolasDbEntity');
		}

	function get_UltimoRegistroDiarioDeCadaUnidad()
		{ 			
			$sql = "SELECT * FROM unidades_lastortolas WHERE id in (SELECT max(id) FROM unidades_lastortolas GROUP BY unidad_id);";
		    return $this->MYSQLfetchObj($sql, 'unidades_lastortolasDbEntity');
		}

	function UltimoRegistroDiarioById_unidad($Id_unidad)
		{
			$RegistrosDiarios = $this->get_unidades_lastortolas();

			usort($RegistrosDiarios, function($a, $b)
				{
    				if ($a->DATETIME == $b->DATETIME)
						{
        					return 0;
    					}

    				return ($a->DATETIME > $b->DATETIME) ? -1 : 1;
				});

			foreach ($RegistrosDiarios as $r)
				{
 					if ($r->unidad_id == $Id_unidad)
						{
							return $r;
						}
				}

			// return null;
		}

	function get_eventos()
		{
			$sql = "SELECT * FROM eventos e ORDER BY TIMESTAMP DESC";
			$result = $this->executeSQL($sql);
			$eventos = [];

			if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
						{
							$eventos[] = new eventosDbEntity
								(
									$row["UNIDAD"],
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
									$row["TIPO"],
									$row["TipoBat"]
			    				);
						}
				}

			return $eventos;
		}

	function RegistrosIniciacionByTag($tag)
		{
			$RegistrosIniciacion = $this->get_eventos();
			$RegistrosIniciacionForThisUnit = [];

			foreach ($RegistrosIniciacion as $r)
				{
 					if ($r->get_UNIDAD() == $tag)
						{
							$RegistrosIniciacionForThisUnit[] = $r;
						}
				}

			return $RegistrosIniciacionForThisUnit;
		}

	function get_checklists()
		{
			$sql = "SELECT * FROM `checklist`";
			$result = $this->executeSQL($sql);
			$checklists = [];

			if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
						{
							$checklists[] = new checklistDbEntity
								(
									$row["Id"],
									$row["VoltajeReguladorBat"],
									$row["VoltajeReguladorMCU"],
									$row["SmartBox"],
									$row["SMSenvio"],
									$row["SMSrecibo"],
									$row["Flujometro"],
									$row["Solenoide"],
									$row["SensorNivelBajo"],
									$row["SensorNivelAlto"],
									$row["VoltajeBateria"],
									$row["VoltajeMCU"],
									$row["BateriaTest"],
									$row["id_checklistMotivo"],
									$row["Observaciones"],
									$row["id_unidadtipo"],
									$row["URL_foto"],
									$row["id_unidad"],
									$row["Fecha"],
									$row["TecnicoResponsable"]
								);
						}
				}

			return $checklists;
		}

	function checklistById_unidad($Id_unidad)
		{
			$checklists = $this->get_checklists();
			$checklistsOfThisUnit= [];

			foreach ($checklists as $checklist)
				{
 					if ($checklist->get_id_unidad() == $Id_unidad)
						{
							$checklistsOfThisUnit[] = $checklist;
						}
				}

			return $checklistsOfThisUnit;
		}

	function UltimochecklistById_unidad($Id_unidad)
		{
			$sql = "SELECT * FROM `checklist` WHERE `id_unidad` = ".$Id_unidad." ORDER BY `Fecha` DESC LIMIT 1";
			$result = $this->executeSQL($sql);

			if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
						{
							$Ultimochecklist = new checklistDbEntity
								(
									$row["Id"],
									$row["VoltajeReguladorBat"],
									$row["VoltajeReguladorMCU"],
									$row["SmartBox"],
									$row["SMSenvio"],
									$row["SMSrecibo"],
									$row["Flujometro"],
									$row["Solenoide"],
									$row["SensorNivelBajo"],
									$row["SensorNivelAlto"],
									$row["VoltajeBateria"],
									$row["VoltajeMCU"],
									$row["BateriaTest"],
									$row["id_checklistMotivo"],
									$row["Observaciones"],
									$row["id_unidadtipo"],
									$row["URL_foto"],
									$row["id_unidad"],
									$row["Fecha"],
									$row["TecnicoResponsable"]
								);
						}
				}

			return $Ultimochecklist;
		}

	function get_checklistmotivos()
		{
			$sql = "SELECT * FROM `checklistmotivo`";
			$result = $this->executeSQL($sql);
			$checklistmotivos = [];

			if ($result->num_rows > 0)
				{
					while($row = $result->fetch_assoc())
						{
							$checklistmotivos[] = new checklistmotivoDbEntity
								(
									$row["id"],
									$row["Nombre"],
									$row["Descripcion"]
								);
						}
				}

			return $checklistmotivos;
		}

	function CheckListMotivoById($Id_ChecklistMotivo)
		{
			$checklistmotivos = $this->get_checklistmotivos();

			foreach ($checklistmotivos as $checklistmotivo)
				{
 					if ($checklistmotivo->get_id() == $Id_ChecklistMotivo)
						{
							return $checklistmotivo;
						}
				}
			return null;
		}
	
	function ticketById($Id_ticket)
		{
			$tickets = $this->get_ticket();

			foreach ($tickets as $ticket)
				{
 					if ($ticket->get_id() == $Id_ticket)
						{
							return $ticket;
						}
				}
			return null;
		}

	function ticketStatusById($Id_ticketStatus)
		{
			$ticketStatuses = $this->get_ticket_status();

			foreach ($ticketStatuses as $ticketstatus)
				{
 					if ($ticketstatus->get_id() == $Id_ticketStatus)
						{
							return $ticketstatus;
						}
				}
			return null;
		}		
    // CRUD ticket
	function get_ticket()
	{
		$sql = "SELECT * FROM `ticket` ORDER BY id DESC";
		return $this->MYSQLfetchObj($sql, 'ticketDbEntity');
	}

	function update_ticket($obj)
	{
		$sql = "UPDATE `ticket` SET ";
		$allKeys = array_keys((array)$obj);
		foreach ($allKeys as $key ) 
		{
   					
			if($obj->$key == 'NULL' || $obj->$key == '' || $obj->$key == null  )
			{	
   				$sql = $sql.$key ." = null, ";	
			}
			else
			{
				$sql = $sql.$key ." = '".$obj->$key."', ";	
			}
		}
		$sql = substr($sql, 0, -2); // removing extra ', '
		$sql = $sql." WHERE Id =".$obj->Id;

		$this->executeSQL($sql);
	}

		function create_ticket($obj)
	{

		$allKeys = array_keys((array)$obj);

		$sql = "INSERT INTO `ticket` ( ";
		foreach ($allKeys as $key ) 
		{
   			$sql = $sql.$key .", ";
		}
		$sql = substr($sql, 0, -2); // removing extra ', '
		$sql = $sql." ) VALUES ( ";
		foreach ($obj as $value ) 
		{	
			if($value == 'NULL'|| $value == '' || $value == null)
			{	
   				$sql = $sql."null, ";
			}
			else
			{
				$sql = $sql."'".$value ."', ";
			}
		}
		$sql = substr($sql, 0, -2); // removing extra ', '
		$sql = $sql." )";

		$this->executeSQL($sql);
	}

	function delete_ticket($obj)
	{
		$id_obj= $obj->Id;
		$sql = "DELETE FROM `ticket` WHERE Id =".$id_obj;
		$this->executeSQL($sql);
	}

	function get_ticket_priority()
	{
		$sql = "SELECT * FROM `ticket_priority`";
		return $this->MYSQLfetchObj($sql, 'ticket_priorityDbEntity');
	}

	function get_ticket_status()
	{
		$sql = "SELECT * FROM `ticket_status`";
		return $this->MYSQLfetchObj($sql, 'ticket_statusDbEntity');
	}
	//CRUD SMSToUnidades
	function get_SMSToUnidades()
	{
		$sql = "SELECT * FROM `smstounidades`";
		return $this->MYSQLfetchObj($sql, 'smstounidadesDbEntity');
	}
	
	function update_SMSToUnidades($obj)
	{
		$sql = "UPDATE `smstounidades` SET ";
		$allKeys = array_keys((array)$obj);
		foreach ($allKeys as $key ) 
		{
   					
			if($obj->$key == 'NULL' || $obj->$key == '' || $obj->$key == null  )
			{	
   				$sql = $sql.$key ." = null, ";	
			}
			else
			{
				$sql = $sql.$key ." = '".$obj->$key."', ";	
			}
		}
		$sql = substr($sql, 0, -2); // removing extra ', '
		$sql = $sql." WHERE Id =".$obj->Id;

		$this->executeSQL($sql);
	}

		function create_SMSToUnidades($obj)
	{

		$allKeys = array_keys((array)$obj);

		$sql = "INSERT INTO `smstounidades` ( ";
		foreach ($allKeys as $key ) 
		{
   			$sql = $sql.$key .", ";
		}
		$sql = substr($sql, 0, -2); // removing extra ', '
		$sql = $sql." ) VALUES ( ";
		foreach ($obj as $value ) 
		{	
			if($value == 'NULL'|| $value == '' || $value == null)
			{	
   				$sql = $sql."null, ";
			}
			else
			{
				$sql = $sql."'".$value ."', ";
			}
		}
		$sql = substr($sql, 0, -2); // removing extra ', '
		$sql = $sql." )";

		$this->executeSQL($sql);
	}

	function delete_SMSToUnidades($obj)
	{
		$id_obj= $obj->Id;
		$sql = "DELETE FROM `smstounidades` WHERE Id =".$id_obj;
		$this->executeSQL($sql);
	}

	function smstounidadesById_unidadNotRecieved($Id_unidad)
	{
		$SMSToUnidades = $this->get_SMSToUnidades();
		foreach ($SMSToUnidades as $su)
		{
			if ( ($su->Id == $Id_unidad) && ($su->Recibido == 0))
			{
				return $su;
			}
		}
		return null;
	}	
}

?>
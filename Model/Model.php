<?php


/// NOTE: no usar datatype BIT en la base de datos, usar BOOL.
// NOTE 2: todas las columnas Id debe ser con I mayuscula y d minuscula.
// Note 3: Las clases Dbentities deben tener el mismo nombre que la tabla + 'DbEntity'  OJO con las manyusculas y minusculas

$self = $_SERVER['PHP_SELF']; 
$thispath = dirname($_SERVER['PHP_SELF']);
$sitebasepath = $_SERVER['DOCUMENT_ROOT'];

require_once $sitebasepath.'/config/DbSirecorConfig.php';

foreach (glob($sitebasepath."/DbEntities/*.php") as $filename)
{
    require_once $filename;
}

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

	function MYSQLSelect($TableName)
		{

			$sql = "SELECT * FROM `".$TableName."` ORDER BY Id DESC";
			return $this->MYSQLfetchObj($sql, $TableName.'DbEntity');
		}
	
	function MYSQLSelectWHERE($TableName ,$key , $value)
		{
			$sql = "SELECT * FROM `".$TableName."` WHERE ".$key." = '".$value."' ORDER BY Id DESC";
			return $this->MYSQLfetchObj($sql, $TableName.'DbEntity');
		}		

	function MYSQLSelectWHERELIMIT($TableName ,$key , $value,$LIMIT)
		{
			$sql = "SELECT * FROM `".$TableName."` WHERE ".$key." = '".$value."' ORDER BY Id DESC LIMIT ".$LIMIT;
			return $this->MYSQLfetchObj($sql, $TableName.'DbEntity');
		}		

	function MYSQLUpdate($TableName, $obj)
		{

			$sql = "UPDATE `".$TableName."` SET ";
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

	function MYSQLInsertInto($TableName, $obj)
		{

		$allKeys = array_keys((array)$obj);

		$sql = "INSERT INTO `".$TableName."` ( ";
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
	
	function MYSQLDelete($TableName, $obj)
		{
			$id_obj= $obj->Id;
			$sql = "DELETE FROM `".$TableName."` WHERE Id =".$id_obj;
			$this->executeSQL($sql);
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
			return $this->MYSQLSelect('unidad');		
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
			$sql = "SELECT * FROM `unidadtipo` ";
			return $this->MYSQLfetchObj($sql, 'unidadtipoDbEntity');
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

	function RegistrosDiariosById_unidad($Id_unidad)
		{
			$sql = "SELECT * FROM `unidades_lastortolas` WHERE unidad_id = ".$Id_unidad." ORDER BY `id` DESC LIMIT 10000";
			return $this->MYSQLfetchObj($sql, 'unidades_lastortolasDbEntity');
			// return null;
		}		

	function get_eventos()
		{
			$sql = "SELECT * FROM `eventos` ORDER BY `TIMESTAMP` DESC ";
			return $this->MYSQLfetchObj($sql, 'eventosDbEntity');
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

	
		function checklistsWHERE($key, $value)
	{
		$sql = "SELECT * FROM `checklist` WHERE ".$key." = ".$value." ORDER BY Id DESC";
		return $this->MYSQLfetchObj($sql, 'checklistDbEntity');
	}	

	function UltimochecklistById_unidad($Id_unidad)
		{
			$sql = "SELECT * FROM `checklist` WHERE `id_unidad` = ".$Id_unidad." ORDER BY `Fecha` DESC LIMIT 1";
			return $this->MYSQLfetchObj($sql, 'checklistDbEntity')[0];
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

	function get_ticket_status()
	{
		$sql = "SELECT * FROM `ticket_status`";
		return $this->MYSQLfetchObj($sql, 'ticket_statusDbEntity');
	}
}

?>
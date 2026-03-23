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

	function get_unidades()
		{
			return $this->MYSQLSelect('unidad');		
		}


	function get_UltimoRegistroDiarioDeCadaUnidad()
		{ 			
			$sql = "SELECT * FROM unidades_lastortolas WHERE id in (SELECT max(id) FROM unidades_lastortolas GROUP BY unidad_id);";
		    return $this->MYSQLfetchObj($sql, 'unidades_lastortolasDbEntity');
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

    // CRUD ticket
	function get_ticket()
	{
		$sql = "SELECT * FROM `ticket` ORDER BY id DESC";
		return $this->MYSQLfetchObj($sql, 'ticketDbEntity');
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
}

?>
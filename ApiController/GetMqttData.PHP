<?php

//Tomando datos desde solicitud HTTP GET
$data= $_GET['JsonData'];
$obj = json_decode($data);

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new model();

$UnidadExistente = $Model->MYSQLSelectWHERE('unidad','tag',$obj->devEUI)[0];

date_default_timezone_set('America/Santiago');
$FechaActualString = date("Y-m-d H:i:s");
$FechaActualObj = new Datetime ($FechaActualString);

//Insertando En tabla RowData
$sql = "INSERT INTO `rowdata`(`RowData`) VALUES ('{$data}');";
$result = $Model->executeSQL($sql);

//Parseando la data del String que viene desde Sirecor
if( $obj->deviceName === "sensor humedad test")
{
	$NOMBRE= $obj->deviceName;
	$UNIDAD= $obj->devEUI; 
	$ESTADO= $obj->temperature;
	$VOLUMEN=$obj->moisture;
	$BATNIVEL = $obj->battery ?? "0";
	$CAUDAL= $obj->ec;
	$Temperatura = $obj->temperature;
	$Humedad = $obj->moisture;
	$EC = $obj->ec;
}
else // si es caja u511 soleniod valve controller
{
	// si la unidad se esta registrando por primera vez
	if( is_null($UnidadExistente) ) 
	{
		$NewUnidad= new unidadDbEntity();
		
		$NewUnidad->Id = "0";
		$NewUnidad->Serie = $obj->deviceName;
		$NewUnidad->tag = $obj->devEUI;
		$NewUnidad->Estado = $obj->valve_1;
		$NewUnidad->Volumen = $obj->valve_2_pulse ?? "0";
		$NewUnidad->BatNivel = $obj->battery ?? "0";

		$Model->MYSQLInsertInto('unidad',$NewUnidad);

		$NewUnidadCreada = $Model->MYSQLSelectWHERE('unidad','tag',$obj->devEUI)[0];

		$RegistroDiario= new unidades_lastortolasDbEntity();

		$RegistroDiario->Id = "0";
		$RegistroDiario->unidad_id = $NewUnidadCreada->Id;
		$RegistroDiario->ESTADO = $obj->valve_1;
		$RegistroDiario->VOLUMEN = $obj->valve_2_pulse ?? "0";
		$RegistroDiario->CAUDAL =  "0";
		$RegistroDiario->VOLTAJE =  $obj->battery ?? "0";
		$RegistroDiario->SENAL = "0";

		$Model->MYSQLInsertInto('unidades_lastortolas',$RegistroDiario);

	}
	else
	{
		// calculando la diferencia de tiempo con el ultimo registro.
		$Anterior = new Datetime ($UnidadExistente->get_UltimaActualizacion());
		$DiferenciaTiempo = ($FechaActualObj->getTimestamp() - $Anterior->getTimestamp())/60; // diferencia en minutos
		
		//Verificar si la unidad esta sincronizando
		$IsSincronizando; // si el mensaje json proveniente de la unidad milesight no envia informacion de V1 o V2, la caja se considera sincronizando
		if(( property_exists($obj,'valve_1') && isset($obj->valve_1) ) || ( property_exists($obj,'valve_1') && isset($obj->valve_1) )  ) 
		{
			$IsSincronizando = '0';
		} else {
			$IsSincronizando = '1';
		}	
		//Tomando datos desde el Json
		//Nivel de bateria
		$NewBATNIVEL =  (property_exists($obj,'battery') && isset($obj->battery) ) ? $obj->battery : ($UnidadExistente->BatNivel ?? '0');
		//Valve1
		$NewESTADO = (property_exists($obj,'valve_1') && isset($obj->valve_1) ) ? $obj->valve_1 : $UnidadExistente->Estado ;
		$NewVOLUMEN = (property_exists($obj,'valve_2_pulse') && isset($obj->valve_2_pulse) ) ? $obj->valve_2_pulse :  ( $UnidadExistente->Volumen ?? '0'); // TODO: utilizando V2 para volumen, falta hacer el cambio
		//Valve2
		$NewESTADO2 = (property_exists($obj,'valve_2') && isset($obj->valve_2) ) ? $obj->valve_2 : $UnidadExistente->Estado2 ;
		$NewVOLUMEN2 = (property_exists($obj,'valve_2_pulse') && isset($obj->valve_2_pulse) ) ? $obj->valve_2_pulse : ( $UnidadExistente->Volumen2 ?? '0');
	
		
		// calculando el caudal, basandose en la diferencia de volumen divido por diferencia de tiempo con el ultimo registro
		//Valve1
		$DiferenciaVolumen = (int)$NewVOLUMEN - (int)$UnidadExistente->get_Volumen();
		$NewCAUDAL = ( $DiferenciaVolumen < 2 ) ? '0' : ($DiferenciaVolumen/$DiferenciaTiempo); // si la diferencia es menor a 2 para no contar caudal de un solo pulso
		//Valve2
		$DiferenciaVolumen2 = (int)$NewVOLUMEN2 - (int)( $UnidadExistente->Volumen2 ?? '0');
		$NewCAUDAL2 = ( $DiferenciaVolumen < 2 ) ? '0' : ($DiferenciaVolumen/$DiferenciaTiempo); // si la diferencia es menor a 2 para no contar caudal de un solo pulso

		//Insertando la informacion tomada del Json en la base de datos
		$sql = "INSERT INTO unidades_lastortolas
		( unidad_id, ESTADO, VOLUMEN, CAUDAL, SENAL, VOLTAJE, `DATETIME`, ESTADO2, VOLUMEN2, CAUDAL2, SINCRONIZANDO)
		VALUES( ".$UnidadExistente->get_id().", '{$NewESTADO}' ,'{$NewVOLUMEN}','{$NewCAUDAL}','0','{$NewBATNIVEL}','{$FechaActualString}' , '{$NewESTADO}' ,'{$NewVOLUMEN}','{$NewCAUDAL}','{$IsSincronizando}');";

		$result = $Model->executeSQL($sql);
		
		// EVENTOS
		// Cambio de estado (SCE)
		if(   $NewESTADO != $UnidadExistente->Estado )  // evento cambio de estado (SCE).
        {
          $messageType = $Model->MYSQLSelectWHERE('eventmessagetype','Id','1')[0];
          $NewObj = new eventmessageDbEntity();
          $NewObj->Id = '0' ;
          $NewObj->MessageText = '{ "NewStatus": "'.(($NewESTADO == '1') ? 'ON' : 'OFF').'", "LastStatus": "'. $UnidadExistente->Estado .'"  }';
          $NewObj->CreationDate = $FechaActualString;
          $NewObj->Id_MessageType = '1';
          $NewObj->Id_unidad		 = $UnidadExistente->Id;
          $NewObj->checked = '0';
          $NewObj->EmailSended = '0';
          $NewObj->DontSend  =  $messageType->SendEmail == "1" ? "0" : "1";  
          $Model->MYSQLInsertInto('eventmessage' ,$NewObj);  
        }

		// Caudal con valvula off (VOF)
		if( $NewCAUDAL && $NewESTADO == "0" && (float)$NewCAUDAL > 0 ) { // Alerta (VOF), caudal con valvula off
		
			$unidadEM = $Model->MYSQLSelectWHERE('eventmessage','Id_unidad',$UnidadExistente->Id );
			$lastVOFmessage = null;
			$VOFmessageTypeId = '2';
			$VOFmessageType = $Model->MYSQLSelectWHERE('eventmessagetype','Id',$VOFmessageTypeId)[0];
			foreach($unidadEM as $Message) { 
				if($Message->Id_MessageType == $VOFmessageTypeId ) $lastVOFmessage = $Message;     
				break;
			}
			if($lastVOFmessage)
			{
				$FechaLastVOFMessage= date_create($lastVOFmessage->CreationDate);
				$DateDiff= date_diff($FechaActualObj,$FechaLastVOFMessage);
		
				if ($DateDiff->format("%i") > 30) { // crear mensaje, si no existe otro mensaje hace 30 minutos.
					$NewObj = new eventmessageDbEntity();
				} 
			}
			else  {
				$NewObj = new eventmessageDbEntity();
			} 
			if (isset($NewObj)) {
				$NewObj->Id = '0' ;
				$NewObj->MessageText = '{  "Caudal": "'.$NewCAUDAL.'", "Valvula": "OFF" }';
				$NewObj->CreationDate = $FechaActualString;
				$NewObj->Id_MessageType = '2';
				$NewObj->Id_unidad		 = $UnidadExistente->Id;
				$NewObj->checked = '0';
				$NewObj->EmailSended = '0';
				$NewObj->DontSend  =  $VOFmessageType->SendEmail == "1" ? "0" : "1";  
				$Model->MYSQLInsertInto('eventmessage' ,$NewObj);   
			}
		}
		// Alerta de volumen Maximo alcanzado (VMax)
		if( $NewVOLUMEN && $NewESTADO == "1" && ( $UnidadExistente->VolMax != null || $UnidadExistente->VolMax != '' ) && (int)$NewVOLUMEN > (int)$UnidadExistente->VolMax ) //Alerta Volumen Maximo
		{
			$unidadEM = $Model->MYSQLSelectWHERE('eventmessage','Id_unidad',$UnidadExistente->Id );
			$lastVMAXmessage = null;
			$VMAXmessageTypeId = '8'; // VMAX type, ver BD
			$VMAXmessageType = $Model->MYSQLSelectWHERE('eventmessagetype','Id',$VMAXmessageTypeId)[0];
			foreach($unidadEM as $Message) { 
				if($Message->Id_MessageType == $VMAXmessageTypeId ) $lastVMAXmessage = $Message;     
				break;
			}
			if($lastVMAXmessage)
			{
				$FechaLastVMAXMessage= date_create($lastVMAXmessage->CreationDate);
				$DateDiff= date_diff($FechaActualObj,$FechaLastVMAXMessage);
		
				if ($DateDiff->format("%i") > 10) { // crear mensaje, si no existe otro mensaje hace 10 minutos.
					$NewObj = new eventmessageDbEntity();
				} 
			}
			else  {
				$NewObj = new eventmessageDbEntity();
			} 
			if (isset($NewObj)) {
				$NewObj->Id = '0' ;
				$NewObj->MessageText = '{  "VolumenActual": "'.$NewVOLUMEN.'", "Volumen Maximo": "'.$UnidadExistente->VolMax.'" }';
				$NewObj->CreationDate = $FechaActualString;
				$NewObj->Id_MessageType = $VMAXmessageTypeId;
				$NewObj->Id_unidad		 = $UnidadExistente->Id;
				$NewObj->checked = '0';
				$NewObj->EmailSended = '0';
				$NewObj->DontSend  =  $VMAXmessageType->SendEmail == "1" ? "0" : "1";  
				$Model->MYSQLInsertInto('eventmessage' ,$NewObj);   
			}
		}
	}
}

?>
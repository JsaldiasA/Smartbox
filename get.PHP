
<?php

header('Content-Type: text/plain');

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$model = new Model();

 $IP = $_SERVER['REMOTE_ADDR'];

//Tomando datos desde solicitud HTTP GET

if (isset($_GET['name']) )
{ 

  $data= $_GET['name'];

  //Insertando En tabla RowData
  $sql = "INSERT INTO `rowdata`(`RowData`,`IP`) VALUES ('{$data}','{$IP}');";
  $result = $model->executeSQL($sql);


  //Parseando la data del String que viene desde Sirecor

  $UNIDAD= substr($data,  0, strpos($data,":"));
  $data= substr($data, (strpos($data,":")+1), strlen($data));
  // Extrayendo Estado
  //Verificando si es estanque o valvula
  if (strpos($data,"V") === 0) { 
    $ESTADO=substr($data,  0, 3); // si es solenoide el fomato es "Von"  o "Voff", por que comenzara con una V, la posicion es 0
    if($ESTADO=="Von"){ 
      $ESTADO="ON";
      $data= substr($data, 4, strlen($data));
    }
    if($ESTADO=="Vof"){ 
      $ESTADO="OFF";
      $data= substr($data, 5, strlen($data));
    }
  }
  else{
  $ESTADO=substr($data,  0, (strpos($data,"V"))); // si es estanque se toma todo hasta la "V" sieguente correspondiente al Volumen.
  $data= substr($data, (strpos($data,"V")+1), strlen($data));	
  }

  $VOLUMEN=substr($data,  0, strpos($data,"C"));
  $CAUDAL=substr($data,  (strpos($data,"C")+1), (strpos($data,"S")-(strpos($data,"C")+1)));
  $SENAL=substr($data,  (strpos($data,"S")+1), (strpos($data,"Vt")-(strpos($data,"S")+1)));
  $VOLTAJE=substr($data,  (strpos($data,"Vt")+2),strlen($data));

  if ($SENAL == "") {
    $SENAL="0";
    $VOLTAJE="0";
  }

  if ($SENAL == "NULL") {
    $SENAL="0";
  }
  if ($VOLUMEN == "NULL") {
    $VOLUMEN="0";
  }
  if ($CAUDAL == "NULL") {
    $CAUDAL="0";
  }
  if ($VOLTAJE == "NULL") {
    $VOLTAJE="0";
  }

  $unidadObj = $model->MYSQLSelectWHERE('unidad','tag',$UNIDAD)[0];
  if( is_null($unidadObj) ) // new unit
    {
    $sql =  "INSERT INTO sirecor.unidad
      (Id, Serie, tag, Ubicacion, numero, UltimaActualizacion, Volumen, Estado, id_unidadTipo, InvertirEntrada, BatNivel, Temperatura, Humedad, EC, VolMax, FactorFlujometro)
      VALUES(0, NULL, '{$UNIDAD}', NULL, NULL, current_timestamp(), NULL, '{$ESTADO}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

        $result = $model->executeSQL($sql);

        $unidadObj = $model->MYSQLSelectWHERE('unidad','tag',$UNIDAD)[0];

  $sql = "INSERT INTO unidades_lastortolas
        ( unidad_id, ESTADO, VOLUMEN, CAUDAL, SENAL, VOLTAJE, `DATETIME`)
        VALUES( ".$unidadObj->get_id().", '{$ESTADO}' ,{$VOLUMEN},{$CAUDAL},{$SENAL},{$VOLTAJE},date_add(NOW(), INTERVAL 15 MINUTE))";

        $result = $model->executeSQL($sql);

    }
    else
    {   
        if( $unidadObj->Estado != $ESTADO ) // evento cambio de estado.
        {
          date_default_timezone_set('America/Santiago');
          $FechaActual= date("Y-m-d H:i:s");

          $NewObj = new eventmessageDbEntity();// use the name of the table related to the db entity

          $NewObj->Id = '0' ;
          $NewObj->MessageText = '{  "NewStatus": "'.$ESTADO.'", "LastStatus": "'.$unidadObj->Estado.'"  }';
          $NewObj->CreationDate = $FechaActual;
          $NewObj->Id_MessageType = '1';
          $NewObj->Id_unidad		 = $unidadObj->Id;
          // SET Default values
          $model->MYSQLInsertInto('eventmessage' ,$NewObj);  
        }

        if( $unidadObj->Id_Last_RegistroDiario != null && $unidadObj->Id_Last_RegistroDiario != ''  )
        {
           $LastRegistro = $model->MYSQLSelectWHERE('unidades_lastortolas','Id',$unidadObj->Id_Last_RegistroDiario )[0];

          if( $unidadObj->Estado == "OFF" && (float)$LastRegistro->CAUDAL > 0 ) // evento cambio de estado.  VOF  ( water flow detected while the Valve is Closed )
          {
            // Getting the last VOF event
            
            $unidadEM = $model->MYSQLSelectWHERE('eventmessage','Id_unidad',$unidadObj->Id );
            $lastVOFmessage;
            $VOFmessageTypeId = '2';
            
            foreach($unidadEM as $Message){ 
              if($Message->Id_MessageType == $VOFmessageTypeId ) $lastVOFmessage = $Message;     
              break;
            }

            date_default_timezone_set('America/Santiago');
            $FechaActualStr= date("Y-m-d H:i:s");

            $FechaActual= date_create($FechaActualStr);

            if($lastVOFmessage)
            {
                $FechaLastVOFMessage= date_create($lastVOFmessage->CreationDate);
              $DateDiff= date_diff($FechaActual,$FechaLastVOFMessage);
        
              if ($DateDiff->format("%i") > 30)
              {
                  $NewObj = new eventmessageDbEntity();

                $NewObj->Id = '0' ;
                $NewObj->MessageText = '{  "Caudal": "'.$LastRegistro->CAUDAL.'", "Valvula": "OFF" }';
                $NewObj->CreationDate = $FechaActualStr;
                $NewObj->Id_MessageType = '2';
                $NewObj->Id_unidad		 = $unidadObj->Id;
                // SET Default values
                $model->MYSQLInsertInto('eventmessage' ,$NewObj);  
              } 

            }
            else
             {
                 $NewObj = new eventmessageDbEntity();

                $NewObj->Id = '0' ;
                $NewObj->MessageText = '{  "Caudal": "'.$LastRegistro->CAUDAL.'", "Valvula": "OFF" }';
                $NewObj->CreationDate = $FechaActualStr;
                $NewObj->Id_MessageType = '2';
                $NewObj->Id_unidad		 = $unidadObj->Id;
                // SET Default values
                $model->MYSQLInsertInto('eventmessage' ,$NewObj);  
             } 
           

          }  
        
        }

        //Evento bateria baja

        if( (int)$VOLTAJE < 20 )
        {   
            $unidadEM = $model->MYSQLSelectWHERE('eventmessage','Id_unidad',$unidadObj->Id );

            $LBAmessageTypeId = '4'; // LBA Low Battery Alert event message type
            $lastLBAmessage;

            foreach($unidadEM as $Message){ 
              if($Message->Id_MessageType == $LBAmessageTypeId ) $lastLBAmessage = $Message;     
              break;
            }
            
            date_default_timezone_set('America/Santiago');
            $FechaActualStr= date("Y-m-d H:i:s");

            if($lastLBAmessage)
            {

              $DateDiff= date_diff( date_create($FechaActualStr) , date_create($lastLBAmessage->CreationDate) );
        
              if ($DateDiff->format("%i") > 30)
              {
                $NewObj = new eventmessageDbEntity();// use the name of the table related to the db entity

                $NewObj->Id = '0' ;
                $NewObj->MessageText = '{  "BatNivel": "'.$VOLTAJE.'" }';
                $NewObj->CreationDate = $FechaActualStr;
                $NewObj->Id_MessageType = '4';
                $NewObj->Id_unidad		 = $unidadObj->Id;
                // SET Default values
                $model->MYSQLInsertInto('eventmessage' ,$NewObj);  
              } 

            }
            else
             {
                $NewObj = new eventmessageDbEntity();// use the name of the table related to the db entity

                $NewObj->Id = '0' ;
                $NewObj->MessageText = '{  "BatNivel": "'.$VOLTAJEL.'" }';
                $NewObj->CreationDate = $FechaActualStr;
                $NewObj->Id_MessageType = '4';
                $NewObj->Id_unidad		 = $unidadObj->Id;
                // SET Default values
                $model->MYSQLInsertInto('eventmessage' ,$NewObj);   
             } 
        }    

        $sql = "INSERT INTO unidades_lastortolas
        ( unidad_id, ESTADO, VOLUMEN, CAUDAL, SENAL, VOLTAJE, `DATETIME`)
        VALUES( ".$unidadObj->get_id().", '{$ESTADO}' ,{$VOLUMEN},{$CAUDAL},{$SENAL},{$VOLTAJE},date_add(NOW(), INTERVAL 15 MINUTE))";

        $result = $model->executeSQL($sql);

        $sql = "UPDATE sirecor.unidad
        SET UltimaActualizacion=current_timestamp(), Volumen={$VOLUMEN}, Estado='{$ESTADO}', BatNivel={$VOLTAJE}
        WHERE Id = ".$unidadObj->get_id();

        $result = $model->executeSQL($sql);

        $SMSToUnidades = $model->MYSQLSelectWHERE('smstounidades','Id_unidad',$unidadObj->get_id());
        
        $smstounit = NULL;

        foreach ($SMSToUnidades as $su)
        {
          if ($su->Recibido == '0')
          {
            $smstounit = $su;
          }
        } 

        if( $smstounit != null)
        {
            $smstounit->Recibido = '1';
            $result = $model->MYSQLUpdate('smstounidades',$smstounit);
            echo '#'.$smstounit->SMS.'$'; 
        }

    }
}

if( isset($_GET['Evento']) )
{

  $data= $_GET['Evento'];
   //Insertando En tabla Ro wData
  $sql = "INSERT INTO `rowdata`(`RowData`,`IP`) VALUES ('{$data}','{$IP}');";
  $result = $model->executeSQL($sql);
  // ejemplo: { "MessageType": "ACT" , "Version": "TestW2" , "Internet": "15" , "TipoBatt": "LI" , "Factor": "45" , "tag": "AV-AD-DF-45-45" }
  $evento = json_decode($data);
  $INTERNET =     $evento->Internet;
  $VerCodigo  = $evento->Version;
  $LVOLTAJE   = $evento->Factor;
  $TIPO  = $evento->MessageType;
  $TipoBat = $evento->TipoBatt;
  $UNIDAD = $evento->tag;

  $sql = "INSERT INTO `eventos` (`UNIDAD`, `USUARIO1`, `USUARIO2`, `USUARIO3`, `USUARIO4`, `ADMIN`, `MANTENCION`, `INTERNET`, `VerCodigo`, `LVOLTAJE`, `INV`, `VOLUMEN MAX`, `TIMESTAMP`, `TIPO`,`TipoBat`) VALUES ('{$UNIDAD}', '', '', '', '', '', '', '{$INTERNET}', '{$VerCodigo}', '{$LVOLTAJE}', '', '', current_timestamp(), '{$TIPO}','{$TipoBat}')";
	
  $result=$model->executeSQL( $sql);

    $unidadObj = $model->MYSQLSelectWHERE('unidad','tag',$evento->tag)[0];

  date_default_timezone_set('America/Santiago');
  $FechaActualStr= date("Y-m-d H:i:s");

  $NewObj = new eventmessageDbEntity();// use the name of the table related to the db entity

  $NewObj->Id = '0' ;
  $NewObj->MessageText = $data;
  $NewObj->CreationDate = $FechaActualStr;
  $NewObj->Id_MessageType = '3';
  $NewObj->Id_unidad		 = $unidadObj->Id;
                // SET Default values
  $model->MYSQLInsertInto('eventmessage' ,$NewObj);  



}
  
?>
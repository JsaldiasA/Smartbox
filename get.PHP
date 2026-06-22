
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
   //Insertando En tabla RowData
  $sql = "INSERT INTO `rowdata`(`RowData`,`IP`) VALUES ('{$data}','{$IP}');";
  $result = $model->executeSQL($sql);

 // ejemplo: { "MessageType": "ACT" , "Version": "TestW2" , "Internet": "15" , "TipoBatt": "LI" , "Factor": "45" }

  $evento = json_decode($data);
  $INTERNET =     $evento->Internet;
  $VerCodigo  = $evento->Version;
  $LVOLTAJE   = $evento->Factor;
  $TIPO  = $evento->MessageType;
  $TipoBat = $evento->TipoBatt;
  $UNIDAD = $evento->Tag;

  $sql = "INSERT INTO `eventos` (`UNIDAD`, `USUARIO1`, `USUARIO2`, `USUARIO3`, `USUARIO4`, `ADMIN`, `MANTENCION`, `INTERNET`, `VerCodigo`, `LVOLTAJE`, `INV`, `VOLUMEN MAX`, `TIMESTAMP`, `TIPO`,`TipoBat`) VALUES ('{$UNIDAD}', '', '', '', '', '', '', '{$INTERNET}', '{$VerCodigo}', '{$LVOLTAJE}', '', '', current_timestamp(), '{$TIPO}','{$TipoBat}')";
	
  $result=$model->executeSQL( $sql);

}
  
?>
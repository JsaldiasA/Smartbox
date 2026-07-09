<?php

$self=$_SERVER['PHP_SELF'];
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];
require_once $sitebasepath."/Model/model.php";

$Model = new model();

$data= $_GET['name'];

$StringFinal= substr($data,  -5); // deberia ser .fin* para las versiones del codigo 4.1 en adelante
$TIPO= substr($data,  0, 3);
$UNIDAD= substr($data,  strpos($data,".V*")+3, strpos($data,".U*")-(strpos($data,".V*")+3) );
$TipoBat;

$unidadObj = $model->MYSQLSelectWHERE('unidad','tag',$UNIDAD)[0];
date_default_timezone_set('America/Santiago');
  $FechaActualStr= date("Y-m-d H:i:s");

if($StringFinal==".fin*"){ 
	if( $TIPO == "INI" or $TIPO == "ACT" or $TIPO == "ERR"  ){
			
		$ADMIN= substr($data, strpos($data,".A*")-8,8);
		$USUARIO1=substr($data,  strpos($data,".A*")+3, strpos($data,".U1*")-(strpos($data,".A*")+3));
		$USUARIO2=substr($data,  strpos($data,".U1*")+4, strpos($data,".U2*")-(strpos($data,".U1*")+4));
		$USUARIO3="Nodata";
		$USUARIO4="Nodata";
		$MANTENCION="Nodata";
		$INTERNET=substr($data,  strpos($data,".inicio*")+8, strpos($data,".IN*")-(strpos($data,".inicio*")+8));
		$VerCodigo=substr($data,  3, strpos($data,".V*")-3);
		$VOLUMEN=substr($data,  strpos($data,".U2*")+4, strpos($data,".C*")-(strpos($data,".U2*")+4));
		$INV=substr($data,  strpos($data,".C*")+3, strpos($data,".I*")-(strpos($data,".C*")+3));
		$TipoBat =substr($data,  strpos($data,".I*")+3, strpos($data,".L*")-(strpos($data,".I*")+3)) ;
		$LVOLTAJE=substr($data,  (strpos($data,".L*")+3),2);

		  $NewObj = new eventmessageDbEntity();// use the name of the table related to the db entity

			$NewObj->Id = '0' ;
			$NewObj->MessageText = $data;
			$NewObj->CreationDate = $FechaActualStr;
			$NewObj->Id_MessageType = ($TIPO == "INI") ? ( '5' ) : (($TIPO == "ACT") ? ('6') : ('7')); // 5 = type iniciar 6 = type actualizar 7 = error
			$NewObj->Id_unidad		 = $unidadObj->Id;
			$NewObj->checked = '0';
							// SET Default values
			$model->MYSQLInsertInto('eventmessage' ,$NewObj);  
	}
}	
else
{
	if( $TIPO == "ERR" ){
			
		$ADMIN= "Nodata";
		$USUARIO1="Nodata";
		$USUARIO2="Nodata";
		$USUARIO3="Nodata";
		$USUARIO4="Nodata";
		$MANTENCION="Nodata";
		$INTERNET="Nodata";
		$VerCodigo="Nodata";
		$VOLUMEN="Nodata";
		$INV="Nodata";
		$LVOLTAJE="Nodata";
	}
	else
	{
		$TIPO= substr($data,  1, 3);
		$UNIDAD= substr($data,  4, strpos($data,".U*")-4);
		$ADMIN= substr($data, strpos($data,".U*")+3,strpos($data,".A*")-(strpos($data,".U*")+3));
		$USUARIO1=substr($data,  strpos($data,".A*")+3, strpos($data,".U1*")-(strpos($data,".A*")+3));
		$USUARIO2=substr($data,  strpos($data,".U1*")+4, strpos($data,".U2*")-(strpos($data,".U1*")+4));
		$USUARIO3=substr($data,  strpos($data,".U2*")+4, strpos($data,".U3*")-(strpos($data,".U2*")+4));
		$USUARIO4=substr($data,  strpos($data,".U3*")+4, strpos($data,".U4*")-(strpos($data,".U3*")+4));
		$MANTENCION=substr($data,  strpos($data,".U4*")+4, strpos($data,".M*")-(strpos($data,".U4*")+4));
		$VOLUMEN=substr($data,  strpos($data,".M*")+3, strpos($data,".C*")-(strpos($data,".M*")+3));
		$INV=substr($data,  strpos($data,".C*")+3, strpos($data,".I*")-(strpos($data,".C*")+3));
		$LVOLTAJE=substr($data,  (strpos($data,".I*")+3),strlen($data));
	}
}

$IP = $_SERVER['REMOTE_ADDR'];

//Insertando En tabla RowData
$sql = "INSERT INTO `rowdata`(`RowData`,`IP`) VALUES ('{$data}','{$IP}');";

$result=$Model->executeSQL( $sql);

$sql = "INSERT INTO `eventos` (`UNIDAD`, `USUARIO1`, `USUARIO2`, `USUARIO3`, `USUARIO4`, `ADMIN`, `MANTENCION`, `INTERNET`, `VerCodigo`, `LVOLTAJE`, `INV`, `VOLUMEN MAX`, `TIMESTAMP`, `TIPO`,`TipoBat`) VALUES ('{$UNIDAD}', '{$USUARIO1}', '{$USUARIO2}', '{$USUARIO3}', '{$USUARIO4}', '{$ADMIN}', '{$MANTENCION}', '{$INTERNET}', '{$VerCodigo}', '{$LVOLTAJE}', '{$INV}', '{$VOLUMEN}', current_timestamp(), '{$TIPO}','{$TipoBat}')";
	
$result=$Model->executeSQL( $sql);
	

 ?>
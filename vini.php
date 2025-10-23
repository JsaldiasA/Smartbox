<?php
//echo "hola";

$servername = "localhost:3306";
$username = "Sirecor_usuario";
$password = "Helegta1!";
$dbname = "sirecor";

//echo 'Hello ' . htmlspecialchars($_GET["name"]) . '!';
$data= $_GET['name'];


$Head= substr($data,  -5);
$TIPO= substr($data,  0, 3);
$UNIDAD= substr($data,  strpos($data,".V*")+3, strpos($data,".U*")-(strpos($data,".V*")+3) );

if($Head==".fin*"){ 
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
		$LVOLTAJE=substr($data,  (strpos($data,".I*")+3),2);
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
echo $UNIDAD;
//echo $data;
//echo '!';
//echo $ESTADO;
//echo '!';
//echo $VOLUMEN;
//echo '!';
//echo $CAUDAL;
//echo '!';
//echo $SENAL;
//echo '!';
//echo $VOLTAJE;
//echo '!';

//echo $UNIDAD;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$IP = $_SERVER['REMOTE_ADDR'];
$dataAndIP= $IP+$data;

echo $dataAndIP;
//Insertando En tabla RowData
$sql = "INSERT INTO `rowdata`(`RowData`,`IP`) VALUES ('{$data}','{$IP}');";

if ($conn->query($sql) === TRUE) {
 echo "ROW agregado exitosamente";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


//$VOLUMEN = intval($VOLUMEN);


$sql = "INSERT INTO `eventos` (`UNIDAD`, `USUARIO1`, `USUARIO2`, `USUARIO3`, `USUARIO4`, `ADMIN`, `MANTENCION`, `INTERNET`, `VerCodigo`, `LVOLTAJE`, `INV`, `VOLUMEN MAX`, `TIMESTAMP`, `TIPO`) VALUES ('{$UNIDAD}', '{$USUARIO1}', '{$USUARIO2}', '{$USUARIO3}', '{$USUARIO4}', '{$ADMIN}', '{$MANTENCION}', '{$INTERNET}', '{$VerCodigo}', '{$LVOLTAJE}', '{$INV}', '{$VOLUMEN}', current_timestamp(), '{$TIPO}')";
	
//$sql = "INSERT INTO `eventos` (`UNIDAD`, `USUARIO1`, `USUARIO2`, `USUARIO3`, `USUARIO4`, `ADMIN`, `MANTENCION`, `LVOLTAJE`, `INV`, `VOLUMEN MAX`, `TIMESTAMP`, `TIPO`) VALUES ('7', '7', '7', '7', '7', '77', '77', '7', '7', '7', current_timestamp(), '7')";

	
if ($conn->query($sql) === TRUE) {
 echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
 ?>
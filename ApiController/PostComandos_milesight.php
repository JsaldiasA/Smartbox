<?php


$self=$_SERVER['PHP_SELF']; 
$thispath=dirname($_SERVER['PHP_SELF']);
$sitebasepath=$_SERVER['DOCUMENT_ROOT'];

require($sitebasepath.'/vendor/autoload.php');
require_once $sitebasepath."/Model/model.php";


$Model = new model();

$tag= $_POST['tag'];
$ComandoNombre= $_POST['nombre'];
$token= $_POST['token'];



use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

try {
$server   = 'y612198b.ala.eu-central-1.emqxsl.com';
// TLS port
$port     = 8883;
$clientId = rand(5, 15);
$username = 'testcsharp';
$password = 'password';
$clean_session = false;

$connectionSettings  = (new ConnectionSettings)
  ->setUsername($username)
  ->setPassword($password)
  ->setKeepAliveInterval(60)
  ->setConnectTimeout(3)
  ->setUseTls(true)
  ->setTlsSelfSignedAllowed(true);

$mqtt = new MqttClient($server, $port, $clientId, MqttClient::MQTT_3_1_1);

$mqtt->connect($connectionSettings, $clean_session);

$mqtt->subscribe('downlink/24e124460e221474', function ($topic, $message) {
    printf("Received message on topic [%s]: %s\n", $topic, $message);
}, 0);

$model = new model();
$comandos = $model->get_comandos_milesight();
foreach ($comandos as $x) {if($x->get_Nombre() == $ComandoNombre) {$comando = $x->get_Comando_Base64();}}
// echo $comando;

$payload = array(
  'confirmed' => true,
  'fport' => 85,
  'data' => $comando

);
$mqtt->publish('downlink/'.$tag, json_encode($payload), 0);

echo "Operación realizada con éxito. tag: ".$tag." nombre:".$ComandoNombre." token:".$token;
}

//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}

?>
<?php

header("Access-Control-Allow-Origin: *");

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
$server   = 'h1811c6e.ala.us-east-1.emqxsl.com';
$port     = 8883;
$clientId = rand(5, 15);
$username = 'eco3_command';
$password = 'eco3spa';
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

$mqtt->subscribe('downlink/'.$tag, function ($topic, $message) {
    printf("Received message on topic [%s]: %s\n", $topic, $message);
}, 0);

$model = new model();
$comandos = $model->MYSQLSelect('comandos_milesight');
foreach ($comandos as $x) {if($x->get_Nombre() == $ComandoNombre) {$comando = $x->get_Comando_Base64();}}
// echo $comando;

$payload = array(
  'confirmed' => true,
  'fport' => 85,
  'data' => $comando
);

$mqtt->publish('downlink/'.$tag, json_encode($payload), 0);

echo "Operacion realizada con exito. tag: ".$tag." nombre:".$ComandoNombre." token:".$token;
}

//catch exception
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}

?>
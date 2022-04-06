<?php

$host = '';
$user = '';
$base = '';
$passe = '';

try{
	$bdd = new PDO('mysql:host='.$host.';dbname='.$base, $user, $passe, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
}catch(Exception $e){
	echo 'Erreur : '.$e->getMessage().'<br />';
	echo 'N° : '.$e->getCode();
}

session_start();

# Augmenter la durée de la session à 3h
// ini_set('session.gc_maxlifetime', 10800);

require_once('fonctions.php');


?>
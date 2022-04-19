<?php
session_start();
require_once '../../include/connexion_bdd.php';

// FERMETURE DU VORTEX EN CAS DE DECONNEXION
$id_planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']);

	/* JOUEUR CONNECTE */
	//SI le joueur est présent alors il sera affiché 1
	$CONNEXION=$bdd->prepare('UPDATE membre SET connexion = ? WHERE id = ?');
	$CONNEXION->execute(array(0,$id_membre));

	// RECUPERER LID DE LA PORTE CONNECTE
	$v=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$v->execute(array($id_planete_utilise));
	$id_porte_connecte=$v->fetch();

	// PERMET DE RECUPERER L'ID DU MEMBRE
	$ve=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$ve->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
	$cible=$ve->fetch();
	
		$actif=$bdd->prepare('UPDATE portail SET actif = ? , interagir = ?, porte_connecte = ?, id_membre = ? WHERE id_planete = ?');
		$actif->execute(array(0,0,0,0,$id_planete_utilise));
		
		//UPDATE DESACTIVATION DE LA PORTE DU JOUEUR
		$portail_actif=$bdd->prepare('UPDATE portail SET actif = ?, interagir = ?, porte_connecte = ?, id_membre = ? WHERE id_planete = ?');
		$portail_actif->execute(array(0,0,0,0,htmlentities($id_porte_connecte['porte_connecte'])));

$_SESSION = array();
session_destroy();

header("Location: ./../../");



?>
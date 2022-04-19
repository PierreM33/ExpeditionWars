<?php

	require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);
	
	
	$stck_unite = $bdd->prepare('UPDATE construction_caserne SET nombre_formation = ? AND time = ? WHERE id_membre = ?'); 
	$stck_unite->execute(array(0,0,1));

	//Update des troupes
	$req_augmentation_unite = $bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite + ? WHERE id_caserne = ? AND id_planete = ?'); 
	$req_augmentation_unite->execute(array($nom_demande,htmlentities($resCas['id']),$planete_utilise));

header('Location: '.pathView().'caserne/caserne_general.php');
?>
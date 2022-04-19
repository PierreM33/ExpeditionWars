<?php

			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);


//Rajouter le temps si cela ne marche passthru
//Liste des vaisseau en cours pour le combats
$table=$bdd->prepare('SELECT * FROM vaisseau_selection ');
$table->execute(array());
$liste_vaisseau=$table->fetch();



$id_membre_attaquant = htmlentities($liste_vaisseau['id_membre']);
$id_planete_attaquant = htmlentities($liste_vaisseau['id_planete_origine']);
$id_planete_defenseur = htmlentities($liste_vaisseau['planete_vise']);
$id_membre_defenseur = htmlentities($liste_vaisseau['id_membre_vise']);


// L'ATTAQUANT
$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array($id_membre_attaquant));
$m=$req_m->fetch();

//DEFENSEUR
$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array($id_membre_defenseur));
$mbr=$req_m->fetch();


$pseudo_attaquant = htmlentities($m['pseudo']);
$pseudo_defenseur = htmlentities($mbr['pseudo']);


?>
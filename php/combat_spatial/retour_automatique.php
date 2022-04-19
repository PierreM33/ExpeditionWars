<?php


//ON RECUPERE LES COORDONNEES DU JOUEUR ET ON LE RENVOI SUR SA PLANETE
/*
	$id_membre_attaquant = htmlentities($liste_vaisseau['id_membre']);
	$id_planete_attaquant = htmlentities($liste_vaisseau['id_planete']);
	$id_planete_defenseur = htmlentities($liste_vaisseau['planete_vise']);
	$id_membre_defenseur = htmlentities($liste_vaisseau['id_membre_vise']);
	$id_action = $liste_vaisseau['id'];*/

//RECUPERER LES INFOS DU JOUEURS
// RECUPERATION DU CALCUL DE TEMPS D'ORIGINE

$nouveau_temps = time() + $stockage_valeur_deplacement;
//ON VA FAIRE UN UPDATE DE L'ACTION ET LE PASSER EN MODE RETOUR
//On va changer le numero de l'action à passer en transport
//On update la cible comme sa propre planete
//EN fonction du joueur et de l'id action
$Up = $bdd->prepare('UPDATE vaisseau_action SET planete_vise = ?, id_membre_vise = ? , nom_action = ? , temps = ? WHERE id_membre = ? AND id = ?');
$Up->execute(array($id_planete_attaquant,$id_membre_attaquant,2,$nouveau_temps, $id_membre_attaquant, $id_action ));

//ATTAQUE ACTION 1
//MOUVEMENT VERS PLANETE ALLIE ACTION 2
//MOUVEMENT VERS ESPACE ACTION 3
?>
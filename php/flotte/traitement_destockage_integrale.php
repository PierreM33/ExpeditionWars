<?php

// On va récuperer les stocks du vaisseaux sur la planète.
//Verifier qu'on retirer pas plus qu'il y en a sur le vaisseau
if($_POST)
	{
		require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

//Récupère le vaisseau
$lst_v=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id = ?');
$lst_v->execute(array($id_membre,$planete_utilise,strip_tags($_POST['id_vaisseau'])));
$place_dispo=$lst_v->fetch();



		$stock_gold = htmlentities( htmlspecialchars($place_dispo['stock_gold']));
		$stock_titane = htmlentities( htmlspecialchars($place_dispo['stock_titane']));
		$stock_cristal = htmlentities( htmlspecialchars($place_dispo['stock_cristal']));
		$stock_orinia = htmlentities( htmlspecialchars($place_dispo['stock_orinia']));
		$stock_orinium = htmlentities( htmlspecialchars($place_dispo['stock_orinium']));
		
		$fret = $stock_cristal + $stock_gold + $stock_titane + $stock_orinia + $stock_orinium;
		

		//On retire les ressources au vaisseau
		$p=$bdd->prepare('UPDATE vaisseau_joueur SET stock_gold = stock_gold-? , stock_titane = stock_titane-? , stock_cristal = stock_cristal-? , stock_orinia = stock_orinia-? , stock_orinium = stock_orinium-? , fret=fret+?  WHERE id_membre = ? AND id_planete = ? AND id = ?');
		$p->execute(array($stock_gold,$stock_titane,$stock_cristal,$stock_orinia,$stock_orinium,$fret,$id_membre,$planete_utilise,strip_tags($_POST['id_vaisseau'])));	



		//Retrait des ressources
		$r=$bdd->prepare('UPDATE ressource SET gold = gold+?, titane=titane+?, cristal=cristal+?, orinia=orinia+?, orinium=orinium+? WHERE id_planete = ? AND id_membre = ? ');
		$r->execute(array($stock_gold,$stock_titane,$stock_cristal,$stock_orinia,$stock_orinium,$planete_utilise,$id_membre));	

		$_SESSION['error'] = '<p class="green">Votre vaisseau est déchargé.</p>';
			header('Location: '.pathView().'./flotte/transport_ressource.php');
	
	}

	else
	{
	$_SESSION['error'] = '<p class="red">Problème d\envoi du formulaire.</p>';
	header('Location: '.pathView().'./flotte/transport_ressource.php');
	}

?>
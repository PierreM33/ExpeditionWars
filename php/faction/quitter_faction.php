<?php

if($_POST)
	{
	require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
				//On delete de la faction le joueur
				$r=$bdd->prepare('DELETE FROM faction_joueur WHERE id_membre = ?');
				$r->execute(array($id_membre));
				
				$r=$bdd->prepare('DELETE FROM chat_joueur_faction WHERE id_membre = ?');
				$r->execute(array($id_membre));
				
				$r=$bdd->prepare('UPDATE point_honneur SET nombre_point_honneur = nombre_point_honneur-? WHERE id_membre = ?');
				$r->execute(array(1000,$id_membre));
				
				header('Location: '.pathView().'./faction/liste_faction.php');
				$_SESSION['error'] = '<p class="green">Vous avez quitté votre faction.</p>';
	
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./faction/liste_faction.php');
	?>
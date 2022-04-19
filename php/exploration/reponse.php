<?php

	
if($_POST['reponse'])
	{
		require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']); 
	
	// La réponse est égale à la valeur1	
	$valeur = strip_tags($_POST['reponse']);

	//LECTURE DE SELECTION EXPLO JOUEUR
	$se=$bdd->prepare('SELECT * FROM exploration_joueur WHERE id_planete = ? AND id_membre = ?');
	$se->execute(array($planete_utilise,$id_membre));
	$explo=$se->fetch();


	//LECTURE DE LA MISSION RECUPERER DANS L'EXPLORATION JOUEUR
	$req=$bdd->prepare('SELECT * FROM mission WHERE numero_mission=? AND etape=?');
	$req->execute(array(htmlentities($explo['numero_mission']),htmlentities($explo['etape'])));
	$miss=$req->fetch();

	//LECTURE DE SELECTION EXPLO JOUEUR
	$se=$bdd->prepare('SELECT * FROM mission_choix WHERE etape_suivante_id = ? AND numero_mission = ?');
	$se->execute(array($valeur,htmlentities($explo['numero_mission'])));
	$ex=$se->fetch();
	
	// On récupère donc le numero de la mission et l'id dans la bdd pour avoir la bonne ligne de la valeur et du gain.
	
	
	$augmentation_tour = 1;

		if($_POST['reponse'] = $valeur)
		{
			//UP du temps, tour fin et de l'heure
			$se=$bdd->prepare('UPDATE exploration_joueur SET tour = tour+?, fin = ?, etape = ?, heure_depart = NOW() WHERE id_planete = ? AND id_membre = ?');
			$se->execute(array($augmentation_tour,htmlentities($ex['gain']),$valeur,$planete_utilise,$id_membre));

			
			//LECTURE DE SELECTION EXPLO JOUEUR
				$se=$bdd->prepare('SELECT * FROM exploration_joueur WHERE id_planete = ? AND id_membre = ?');
				$se->execute(array($planete_utilise,$id_membre));
				$explo=$se->fetch();
			
			// Si le chiffre est autre que 0 dans la ligne d'exploration du joueur alors, les etapes continue sinon il remporte son gain.
			if(htmlentities($explo['fin']) > 0)
			{
			header('Location: '.pathView().'exploration/mission_resultat.php');
			$_SESSION['error'] = '<p class="green">Votre &eacute;quipe &agrave; franchi la porte avec succ&egrave;s. Elle vous transmettra sont rapport dans quelques secondes.</p>';
			}
			else
			{
			header('Location: '.pathView().'exploration/accueil_exploration.php');
			$_SESSION['error'] = '<p class="green">Votre &eacute;quipe &agrave; franchi la porte avec succ&egrave;s. Elle vous transmettra sont rapport dans quelques secondes.</p>';
			}
		}
		else
		$_SESSION['error'] = '<p class="green"> Erreur lors du chargement de la mission.</p>';

	}
	else
	$_SESSION['error'] = '<p class="green">Aucune &eacute;quipe n\'a &eacute;t&eacute; s&eacute;lectionn&eacute;.</p>';	

?>
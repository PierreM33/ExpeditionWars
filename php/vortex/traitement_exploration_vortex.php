<?php

		
// VORTEX
if($_POST)
	{
		
		require_once '../../include/connexion_bdd.php';
		
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
		$id_membre=htmlentities($_SESSION['id']);
		
		//Recuperation de l"energie
		$req_ress = $bdd->prepare("SELECT * FROM ressource WHERE id_planete = ? ");
		$req_ress->execute(array($planete_utilise));
		$user_ress=$req_ress->fetch();
		
		//LECTURE DE SELECTION EXPLO JOUEUR
		$selet=$bdd->prepare('SELECT * FROM exploration_joueur WHERE id_planete = ? AND id_membre = ?');
		$selet->execute(array($planete_utilise,$id_membre));
		$s=$selet->fetch();
		
		$energie=htmlentities($user_ress['energie']);	

		if($energie >= 100)
			{
				$conso=-100;
				$up_energie=$bdd->prepare('UPDATE ressource SET energie = energie+? WHERE id_planete = ?');
				$up_energie->execute(array($conso,$planete_utilise));
				
				$actif=$bdd->prepare('UPDATE portail SET exploration = ?, protection_lien = ? WHERE id_planete = ?');
				$actif->execute(array(1,1,$planete_utilise));
				

				if($s['tour'] == 0 )
				{
				header('Location: '.pathphp().'exploration/verification_mission.php');

				}
				else
				{

				header('Location: '.pathView().'exploration/accueil_exploration.php');	
				}
						

			}
			else
			{
			$_SESSION['error'] = '<p class="red"> Vous manquez d\'énergie. Ouvrir un vortex nécéssite 100 points d\'énergie. </p>';
			header('Location: '.pathView().'vortex/page_portail_spatial.php');
			}
	}
	else
	$_SESSION['error'] = '<p class="red"> Erreur. </p>';

?>
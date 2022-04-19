<?php


if($_POST)
	{

require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']); 
	
		//On update la protection pour eviter la triche
		$se=$bdd->prepare('UPDATE exploration_joueur SET protection=? WHERE id_planete = ? AND id_membre = ?');
		$se->execute(array(1,$planete_utilise,$id_membre));
		
		header('Location: '.pathView().'exploration/mission.php');
		
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur.</p>';	

?>
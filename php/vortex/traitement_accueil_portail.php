<?php
require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);

		
		//verifie si le portail est actif ou non
		$a=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ? AND id_membre = ?');
		$a->execute(array($planete_utilise,$id_membre));
		$actif=$a->fetch();	


if(htmlentities($actif['actif']) > 0)
	{
	header('Location: '.pathView().'vortex/page_vortex.php');
	}
	else
	{
		header('Location: '.pathView().'vortex/page_portail_spatial.php');	
	}
		
header('Location: '.pathView().'vortex/page_portail_spatial.php');
?>
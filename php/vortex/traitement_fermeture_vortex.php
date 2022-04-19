<?php

		
// VORTEX
if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
		$id_membre=htmlentities($_SESSION['id']);
		
	// RECUPERER LID DE LA PORTE CONNECTE
	$v=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$v->execute(array($planete_utilise));
	$id_porte_connecte=$v->fetch();

	// PERMET DE RECUPERER L'ID DU MEMBRE
	$ve=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$ve->execute(array($id_porte_connecte['porte_connecte']));
	$cible=$ve->fetch();
	
		$actif=$bdd->prepare('UPDATE portail SET actif = ? , interagir = ?, porte_connecte = ?, id_membre = ?, protection_lien = ?, temps = ? WHERE id_planete = ?');
		$actif->execute(array(0,0,0,0,0,0,$planete_utilise));

		
		//UPDATE DESACTIVATION DE LA PORTE DU JOUEUR
		$portail_actif=$bdd->prepare('UPDATE portail SET actif = ?, interagir = ?, porte_connecte = ?, id_membre = ? , temps = ? WHERE id_planete = ?');
		$portail_actif->execute(array(0,0,0,0,0,$id_porte_connecte['porte_connecte']));

		header('Location: '.pathView().'vortex/page_portail_spatial.php');
}
else
$_SESSION['error'] = '<p class="red">Erreur lors de la fermeture du vortex.</p>';

?>
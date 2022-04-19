<?php

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


$message_combat= 'Rapport de combat spatial entre le joueur : ' . $m['pseudo'] . ' et ' . $mbr['pseudo'] . ' cliquez sur le lien : <br /><br />';
$message_combat .= '<a href="'. pathView() .'flotte/rapport_combat.php?numero=' . $_GET['numero'] . '">Rapport de combat</a>'; 
	
								
$message_defenseur=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_defenseur->execute(array($id_membre_attaquant,$id_membre_defenseur,$message_combat,time(),0," Rapport de Combat avec le joueur : " . $m['pseudo']));

$message_attaquant=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_attaquant->execute(array($id_membre_defenseur,$id_membre_attaquant,$message_combat,time(),0," Rapport de Combat avec le joueur : " . $mbr['pseudo']));

?>
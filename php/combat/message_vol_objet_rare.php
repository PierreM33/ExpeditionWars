<?php

$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array($id_membre));
$m=$req_m->fetch();

$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array(htmlentities($cible['id_membre'])));
$mbr=$req_m->fetch();

$message_combat_un=" Pendant votre attaque vous avez dérobé " . $nombre_objet . " rare à votre adversaire.";
$message_combat_deux=" Pendant l'attaque il vous a été dérobé " . $nombre_objet . " rare.";
	
								
								
$message_defenseur=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_defenseur->execute(array($id_membre,htmlentities($cible['id_membre']),$message_combat_deux,time(),0," Rapport de vol avec le joueur : " . $m['pseudo'] . ""));

$message_attaquant=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_attaquant->execute(array(htmlentities($cible['id_membre']),$id_membre,$message_combat_un,time(),0," Rapport de vol avec le joueur : " . $mbr['pseudo'] . ""));
 



?>


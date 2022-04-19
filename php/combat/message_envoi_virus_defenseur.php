<?php

$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array($id_membre));
$m=$req_m->fetch();

$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array(htmlentities(htmlspecialchars($cible['id_membre']))));
$mbr=$req_m->fetch();

// METTRE UN   'S'   A ESCLAVE OU NON
if(ceil($total_perte) > 1) { $esclaves = "esclaves"; } else $esclaves = "esclave";

$message_combat="Rapport de combat entre le joueur : " . htmlentities(htmlspecialchars($m['pseudo'])) . " et " .  htmlentities(htmlspecialchars($mbr['pseudo'])) . "
Votre plan&egrave;te vient de recevoir un virus mortelle par le portail. Vous venez de perdre une partie de votre population suite &agrave; l'&eacute;pid&eacute;mie . Vos pertes sont estim&eacute; &agrave; " . ceil($total_perte )  . ".";


		
																
$message_defenseur=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_defenseur->execute(array($id_membre,htmlentities(htmlspecialchars($cible['id_membre'])),$message_combat,time(),0," Rapport de Combat avec le joueur : " . htmlentities(htmlspecialchars($m['pseudo'])) . ""));




?>
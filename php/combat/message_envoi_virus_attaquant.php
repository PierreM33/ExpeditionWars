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
Votre attaque de virus mortelle par le portail c'est d&eacute;roul&eacute; convenablement. Suite &agrave; l'&eacute;pid&eacute;mie les pertes ennemis sont estim&eacute; &agrave; " . ceil($total_perte) . ".";

 
$message_attaquant=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_attaquant->execute(array(htmlentities(htmlspecialchars($cible['id_membre'])),$id_membre,$message_combat,time(),0," Rapport de Combat avec le joueur : " . htmlentities(htmlspecialchars($mbr['pseudo'])) . ""));
 




?>
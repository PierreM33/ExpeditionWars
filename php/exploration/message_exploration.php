<?php

// RETIRE LE 10/05/2018 l'exploration devenant instantané il est inutile d'envoyer un message
$message_miss= ' Votre équipe d\'exploration est partie en mission.';


$message=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message->execute(array($id_membre,$id_membre,$message_miss,time(),0," Exploration Mission "));

?>
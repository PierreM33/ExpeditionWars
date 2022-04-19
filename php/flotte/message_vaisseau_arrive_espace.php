<?php

//Planete du joueur ciblé
$sele=$bdd->prepare('SELECT * FROM planete WHERE id =?');
$sele->execute(array($id_planete_attaquant));
$PLU=$sele->fetch();



						$message=" Votre flotte vient de se positionner dans l'espace comme convenu. Rendez vous dans votre gestion de flotte pour regarder sa position.
						Votre flotte se trouve dans le syst&agrave;me num&eacute;ro  <font color='red'><b>" . $systeme . "</b></font> au coordonn&eacute;e suivante : <font color='red'><b>" . $coordonnee . "</b></font>";

// Insertion du message			
$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
$msg->execute(array($id_membre_attaquant,$id_membre_attaquant,$message,time(),0,"Vaisseaux postionné dans l'espace."));




?>
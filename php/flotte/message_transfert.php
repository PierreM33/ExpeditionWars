<?php


//Planete du joueur ciblé
$sele=$bdd->prepare('SELECT * FROM planete WHERE id =?');
$sele->execute(array($id_planete_attaquant));
$PLU=$sele->fetch();

//Propre palnète
$sel=$bdd->prepare('SELECT * FROM planete WHERE id =?');
$sel->execute(array($id_planete_vise));
$PL=$sel->fetch();


						$message=" Vous venez de recevoir une flotte de la part du joueur " . htmlentities($PL['pseudo_membre']) . " 
						
						Rendez-vous dans votre hangar, sur la plan&egrave;te : " . htmlentities($PL['nom_planete']) . "
						";

// Insertion du message résultant de l'espionnage				
$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
$msg->execute(array($id_membre_attaquant,$id_membre_vise,$message,time(),0,"Transfert de vaisseaux venant du joueur : " . htmlentities($PL['pseudo_membre']) . ""));

$_SESSION['error'] = '<p class="green">Votre flotte &agrave; &eacute;t&eacute; transfer&eacute;.</p>';



?>
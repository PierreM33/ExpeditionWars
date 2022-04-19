<?php
// Message qui sera affiché dans la messagerie du joueur qui envoie l'espion
						$message="L'espion vient de nous transmettre sont rapport.
Votre ennemi poss&egrave;de les stocks de ressources suivant sur cette plan&egrave;te :    
Or : " . $l['gold'] ."
Titane : " . $l['titane'] . "
Cristal : " . $l['cristal'] . "
Orinia : " . $l['orinia'] . "
Orinium : " . $l['orinium'] . "


Il poss&egrave;de actuellement : " . $total_trp . " unit&eacute;s sur cette plan&egrave;te au moment du rapport de votre espion. 
Pour &egrave;viter de se faire capturer celui-ci ne reviendra pas sur votre plan&egrave;te. ";


// Insertion du message résultant de l'espionnage				
$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
$msg->execute(array($id_membre,$id_membre,$message,time(),0,"Rapport d'espionnage du joueur " . $m['pseudo'] . ""));

$_SESSION['error'] = '<p class="green">Voter espion &agrave; franchi le vortex et vous transmet des informations. Regardez votre messagerie.</p>';
?>
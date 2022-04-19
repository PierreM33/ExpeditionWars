<?php

// Message qui sera affiché dans la messagerie du joueur qui envoie est espionné
// retiré : Matière Organique: " . $l['organique'] . " 
						$message="Un espion vient de franchir votre porte, vous l'avez captur&eacute; puis int&eacute;rrog&eacute;. Celui-ci aura sans doute transmis des informations avant sa capture.";

// Insertion du message résultant de l'espionnage				
$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
$msg->execute(array($id_membre,$m['id'],$message,time(),0,"Rapport d'espionnage du joueur " . $membre['pseudo'] . ""));

$_SESSION['error'] = '<p class="green">Voter espion &agrave; franchi le vortex et vous transmet des informations. Regardez votre messagerie.</p>';



?>
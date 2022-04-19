<?php
						// Insertion du message résultant de l'espionnage - Celui ci étant un échec.
						$message_dead = " Votre espion n'a visiblement pas r&eacute;ussi &agrave; s'infiltrer sur la plan&egrave;te cibl&eacute;e. Nous n'avons pas obtenu de nouvelles de celui-ci.";
						$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
						$msg->execute(array($id_membre,$id_membre,$message_dead,time(),0,"Rapport d'espionnage du joueur " . $m['pseudo'] . ""));
						
						$_SESSION['error'] = '<p class="green">Voter espion &agrave; franchi le vortex et vous transmet des informations. Regardez votre messagerie.</p>';
?>
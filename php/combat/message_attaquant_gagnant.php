<?php

$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array($id_membre));
$m=$req_m->fetch();

$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array( htmlentities(htmlspecialchars($cible['id_membre']))));
$mbr=$req_m->fetch();

// METTRE UN   'S'   A ESCLAVE OU NON
if(ceil($perte_population) > 1) { $esclaves = "esclaves"; } else $esclaves = "esclave";

$message_combat="
Rapport de combat entre le joueur : <b>" .  htmlentities(htmlspecialchars($m['pseudo'])) . " et " .  htmlentities(htmlspecialchars($mbr['pseudo'])) . "</b>

<u>Détails troupes attaquant:</u>
 
Soldat valharien :" . ceil($tr) . " unités.
Guerrier Orak :" . ceil($qu) . " unités.
Maitre Orak :" . ceil($ci) . " unités.
Robot Type 1 :" . ceil($si) . " unités.
Robot Type 2 :" . ceil($se) . " unités.
Soldat  :" . ceil($hu) . " unités.
Soldat Lourd :" . ceil($ne) . " unités.
Soldat Ancien :" . ceil($di) . " unités.


<u>Détails troupes en défense:</u>
 
Soldat valharien :" . ceil($dt) . " unités.
Guerrier Orak :" . ceil($dq) . " unités.
Maitre Orak :" . ceil($dc) . " unités.
Robot Type 1 :" . ceil($ds) . " unités.
Robot Type 2 :" . ceil($dse) . " unités.
Soldat :" . ceil($dh) . " unités.
Soldat Lourd :" . ceil($dn) . " unités.
Soldat Ancien :" . ceil($dd) . " unités.


<center> <b> COMPOSITION : </b></center>

Nombre d'unite de l'attaquant : " . ceil($nombre_total_unite_attaquant) . "
Nombre d'unite du defenseur : " . ceil($nombre_total_unite_defenseur) . "


<center> <b> RESULTAT : </b></center>

L'attaquant a perdu : " . ceil($perte_attaquant) . " unites 
Le defenseur a perdu : " . ceil($resultat_perte_defenseur) . " unites.


L'attaquant gagne le combat. Celui-ci recupere un certains nombre de ressources a son adversaire.
				
L'attaquant obtient : " . ceil($perte_population) . " ".$esclaves.".
Le vol de ressources vous rapporte : 
- Or :" . ceil($perte_gold) . "
- Titane : " . ceil($perte_titane) . "
- Cristal :" . ceil($perte_cristal) . "
- Orinia :" . ceil($perte_orinia) . "
- Orinium : " . ceil($perte_orinium) . "";


						
								
								
$message_defenseur=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_defenseur->execute(array($id_membre,htmlentities($cible['id_membre']),$message_combat,time(),0," Rapport de Combat avec le joueur : " . $m['pseudo'] . ""));

$message_attaquant=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_attaquant->execute(array(htmlentities($cible['id_membre']),$id_membre,$message_combat,time(),0," Rapport de Combat avec le joueur : " . $mbr['pseudo'] . ""));
 



?>
<?php

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']);

// RECUPERER LID DE LA PORTE CONNECTE
$v=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
$v->execute(array($planete_utilise));
$id_porte_connecte=$v->fetch();

// PERMET DE RECUPERER L'ID DU MEMBRE
$ve=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
$ve->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
$cible=$ve->fetch();

$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array($id_membre));
$m=$req_m->fetch();

$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$req_m->execute(array(htmlentities($cible['id_membre'])));
$mbr=$req_m->fetch();
// INSERTION DANS BDD DU COMBAT

$r=$bdd->prepare('INSERT INTO `sauvagarde_combat`(`id_planete_attaquant`, `pseudo_attaquant`, `id_planete_defenseur`, `pseudo_defenseur`, `atta_trois`, `atta_quatre`, `atta_cinq`, `atta_six`, `atta_sept`, `atta_huit`, `atta_neuf`, `atta_dix`, `def_trois`, `def_quatre`, `def_cinq`, `def_six`, `def_sept`, `def_huit`, `def_neuf`, `def_dix`, `perte_attaquant`, `perte_defenseur`, `perte_tot_att`, `perte_tot_def`, `gold`, `titane`, `cristal`, `orinia`, `orinium`, `organique`, `population`, `temps`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())');
$r->execute(array(

$planete_utilise,
$m['pseudo'],
htmlentities($id_porte_connecte['porte_connecte']),
$mbr['pseudo'],
$tr,
$qu,
$ci,
$si,
$se,
$hu,
$ne,
$di,
$dt,
$dq,
$dc,
$ds,
$dse, 
$dh,
$dn,
$dd,
$repartition_de_perte_de_attaquant,
$perte_distinct,
$resultat_perte_attaquant,
$perte_defenseur,
0,
0,
0,
0,
0,
0,
0,


));





?>
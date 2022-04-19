<?php

//PARTIE GUERRE ALLIANCE

$id_membre_vise = htmlentities($cible['id_membre']);

//En cas de victoire sur un adversaire d'une guerre il faut ajouter les points de guerre
$recup=$bdd->prepare('SELECT * FROM alliance_membre WHERE id_membre = ?');
$recup->execute(array($id_membre));
$REC=$recup->fetch();

$ID_ALLIANCE_UN = htmlentities($REC['id_alliance']);

//RECUPERER LE NUMERO DE l'alliance vise
$recup=$bdd->prepare('SELECT * FROM alliance_membre WHERE id_membre = ?');
$recup->execute(array($id_membre_vise));
$REC_B=$recup->fetch();

$ID_ALLIANCE_DEUX = htmlentities($REC_B['id_alliance']);

// Ajouter les points à l'alliance en fonction de l'alliance

// ca ne marche pas
// Ajoute 2 points a l'attaquant
$historique_G=$bdd->prepare('UPDATE alliance_guerre SET point = point + ? WHERE id_alliance_un = ?  AND id_alliance_deux = ? ');
$historique_G->execute(array(5,$ID_ALLIANCE_UN,$ID_ALLIANCE_DEUX));


?>
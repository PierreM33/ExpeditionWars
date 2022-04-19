<?php

//Page de restriction d'attaque
//On ne pourra attaquer le joueur uniquement si

//Recupération des points
$pts=$bdd->prepare('SELECT * FROM membre WHERE id=?');
$pts->execute(array($id_membre));
$point=$pts->fetch();

$PTS_A = htmlentities($point['point']);

$id_membre_adverse = htmlentities($Coord_Joueur_vise['id_membre']);

//Recupération des points de l'adervsaire
$pt=$bdd->prepare('SELECT * FROM membre WHERE id=?');
$pt->execute(array($id_membre_adverse));
$pointA=$pt->fetch();

$PTS_B = htmlentities($pointA['point']);

//calcul de la protection
$total =($PTS_A * 95)/100;


$superieur = $PTS_A + $total;
$inferieur = $PTS_A - $total;


// PARTIE GUERRE //
//On va vérifier si le joueur est en guerre avec son ennemi

//En cas de victoire sur un adversaire d'une guerre il faut ajouter les points de guerre
$recup=$bdd->prepare('SELECT * FROM alliance_membre WHERE id_membre = ?');
$recup->execute(array($id_membre));
$REC=$recup->fetch();


//RECUPERER LE NUMERO DE l'alliance vise
$recup=$bdd->prepare('SELECT * FROM alliance_membre WHERE id_membre = ?');
$recup->execute(array($id_membre_adverse));
$REC_B=$recup->fetch();


$ID_ALLIANCE_UN = htmlentities($REC['id_alliance']);
$ID_ALLIANCE_DEUX = htmlentities($REC_B['id_alliance']);

$All=$bdd->prepare('SELECT * FROM alliance_guerre WHERE id_alliance_un = ? AND id_alliance_deux = ?');
$All->execute(array($ID_ALLIANCE_UN,$ID_ALLIANCE_DEUX));
$G=$All->fetch();

$etat = htmlentities($G['etat']);

//Si l'alliance 1 et en guerre avec l'alliance 2
if($ID_ALLIANCE_UN != $ID_ALLIANCE_DEUX)
{
	// ALors on regarde leurs alliances respective
	
}

?>
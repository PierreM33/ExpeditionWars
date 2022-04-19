<?php

			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);

/// SCRIPT DE VOL DE RESSOURCES
/// ON VA VERIRIFER LES STOCKS DE RESSOURCES QUE L'ATTAQUANT PEUT PRENDRE
/// ON RECUPERE EN TOUT 10%
/// 10% REPARTI EN FONCTION DE LA RESSOURCE QUE L'ONT VEUT "selection par le joueur en amont"
/// D'origine 10% repartie sur les 5 ressources
///


//VERIFIER LA PLACE DISPONIBLE
$selectionner=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ? ');
$selectionner->execute(array($id_membre_attaquant,$id_action));
while($vol_ress=$selectionner->fetch())
{
	
	//on récupère chaque vaisseau son fret
	$fret_vaisseau = htmlentities($vol_ress['fret']);

	$id_vaisseau = htmlentities($vol_ress['id']);
	
$fret_total = 0;
	//On ajoute le fret total des vaisseaux
$fret_total+=$fret_vaisseau;



//RECUPERATION DES RESSOURCES ENNEMIS ( VISE )
$ressources=$bdd->prepare('SELECT * FROM ressource WHERE id_membre = ? AND id_planete = ? ');
$ressources->execute(array($id_membre_defenseur,$id_planete_defenseur));
$R_Vise=$ressources->fetch();

$R_Vise['gold'];
$R_Vise['titane'];
$R_Vise['cristal'];
$R_Vise['orinia'];
$R_Vise['orinium'];
$R_Vise['organique'];

$gold_10 = ($R_Vise['gold']*2.5)/100;
$titane_10 = $R_Vise['titane']*2.5/100;
$cristal_10 = $R_Vise['cristal']*2.5/100;
$orinia_10 = $R_Vise['orinia']*2.5/100;
$ornium_10 = $R_Vise['orinium']*2.5/100;
$organique_10 = $R_Vise['organique']*2.5/100;

//On recupère le total des ressources de la planete
$ressources_total = htmlentities($R_Vise['gold']) + htmlentities($R_Vise['titane']) + htmlentities($R_Vise['cristal']) + htmlentities($R_Vise['orinia']) + htmlentities($R_Vise['orinium']) + htmlentities($R_Vise['organique']);


//On va diviser le fret en 5 et voler chacune des ressourdes
$FRET_PAR_RESSOURCE = $fret_vaisseau / 5;



//On va calculer la place dans le fret du vaisseau
$place_gold_dispo = $FRET_PAR_RESSOURCE - htmlentities($vol_ress['stock_gold']) ;
$place_titane_dispo = $FRET_PAR_RESSOURCE - htmlentities($vol_ress['stock_titane']);
$place_cristal_dispo = $FRET_PAR_RESSOURCE - htmlentities($vol_ress['stock_cristal']);
$place_orinia_dispo = $FRET_PAR_RESSOURCE - htmlentities($vol_ress['stock_orinia']);
$place_orinium_dispo = $FRET_PAR_RESSOURCE - htmlentities($vol_ress['stock_orinium']);


// Si la ressource est à zéro on va voler 0
if($place_gold_dispo == 0)
{
	$place_gold_dispo = 0;
}



//addition des frets
$ADD = $place_gold_dispo + $place_titane_dispo + $place_cristal_dispo + $place_orinia_dispo + $place_orinium_dispo;


// Donc nous avons la chaque ressources qui vaut autant que le fret disponible
//$ADD = $FRET_PAR_RESSOURCE * 5;

	$place_gold_dispo =  $FRET_PAR_RESSOURCE;
	$place_titane_dispo =  $FRET_PAR_RESSOURCE;
	$place_cristal_dispo =  $FRET_PAR_RESSOURCE;
	$place_orinia_dispo =  $FRET_PAR_RESSOURCE;
	$place_orinium_dispo =  $FRET_PAR_RESSOURCE;


// On va verifier les ressources de l'adversaire, qu'il soit possible de lui prendre que ce qu'il n'a. et Non pas plus sinon tricherie.
//SI le fret de chaque ressource est supérieur aux stock ennemi alors la valeur du vol sera égale aux ressources volé
//On va récupérer dans chacune des ressources le fret
$OR_RESTANT = htmlentities($R_Vise['gold']);
$TITANE_RESTANT = htmlentities($R_Vise['titane']);
$CRISTAL_RESTANT = htmlentities($R_Vise['cristal']);
$ORINIA_RESTANT = htmlentities($R_Vise['orinia']);
$ORINIUM_RESTANT = htmlentities($R_Vise['orinium']);


if($place_gold_dispo >= $OR_RESTANT)
{
	$place_gold_dispo = $OR_RESTANT;
}

if($place_titane_dispo >= $TITANE_RESTANT)
{
	$place_titane_dispo = $TITANE_RESTANT;
}

if($place_cristal_dispo >= $CRISTAL_RESTANT)
{
	$place_cristal_dispo = $CRISTAL_RESTANT;
}

if($place_orinia_dispo >= $ORINIA_RESTANT)
{
	$place_orinia_dispo = $ORINIA_RESTANT;
}

if($place_orinium_dispo >= $ORINIUM_RESTANT)
{
	$place_orinium_dispo = $ORINIUM_RESTANT;
}

//addition des frets
$ADD = $place_gold_dispo + $place_titane_dispo + $place_cristal_dispo + $place_orinia_dispo + $place_orinium_dispo;


// Si jamais le fret est à zéro alors tout est à zéro
if($ADD <= 0)
{
	$ADD = 0;
	$place_gold_dispo = 0;
	$place_titane_dispo = 0;
	$place_cristal_dispo = 0;
	$place_orinia_dispo = 0;
	$place_orinium_dispo = 0;
}

//On ajoutera autant de FRET_PAR_RESSOURCE dans la case du vaisseau.
$fpr=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ? AND id = ?');
$fpr->execute(array($id_membre,$id_action, $id_vaisseau));
$FPR=$fpr->fetch();


//On update chaque vaisseaux des ressources qu'il a volé.
$upv=$bdd->prepare('UPDATE vaisseau_joueur SET fret=fret-?, stock_gold= stock_gold+?, stock_titane=stock_titane+?, stock_cristal=stock_cristal+?, stock_orinia=stock_orinia+?, stock_orinium=stock_orinium+? WHERE id_membre = ? AND id =? AND id_action = ?');
$upv->execute(array($ADD,$place_gold_dispo,$place_titane_dispo,$place_cristal_dispo,$place_orinia_dispo,$place_orinium_dispo,$id_membre_attaquant,$id_vaisseau,$id_action));


//Update des ressources volé
$ress=$bdd->prepare('UPDATE ressource SET gold = gold-?, titane=titane-?, cristal= cristal-?, orinia=orinia-?, orinium=orinium-? WHERE id_membre = ? AND id_planete = ? ');
$ress->execute(array($place_gold_dispo,$place_titane_dispo,$place_cristal_dispo,$place_orinia_dispo,$place_orinium_dispo,$id_membre_defenseur,$id_planete_defenseur));


$VG = 0;
$VT = 0;
$VC = 0;
$VO = 0;
$VOR = 0;


$VG+= $place_gold_dispo;
$VT+= $place_titane_dispo;
$VC+= $place_cristal_dispo;
$VO+= $place_orinia_dispo;
$VOR+= $place_orinium_dispo;


}

if($VG == "")
{
	$VG = 0;
}
if($VT == "")
{
	$VT = 0;
}
if($VC == "")
{
	$VC = 0;
}
if($VO == "")
{
	$VO = 0;
}
if($VOR == "")
{
	$VOR = 0;
}



?>
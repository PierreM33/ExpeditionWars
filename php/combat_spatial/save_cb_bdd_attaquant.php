<?php

//INSERTION DANS LA BDD A CHAQUE TOUR 
$categorie='attaquant';

$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ? ');
$select->execute(array($id_membre_attaquant,$id_action));
while($s=$select->fetch())
{

$Reste_bouclier_ou_coque_apres_degats = 0;

//Si les degats sont inférieur à zero on le remplace par zéro
if($Reste_bouclier_ou_coque_apres_degats <= 0)
{
$Reste_bouclier_ou_coque_apres_degats = 0;
}

//$VALEUR_ATTAQUE_PAR_CATEGORIE = 0;

$insert=$bdd->prepare('INSERT INTO sauvegarde_composition_par_tour(nom_vaisseau,attaque,bouclier,defense,tour,categorie,
nombre_defense,
degat_fait_au_defense,
degat_fait_au_vaisseau,
degat_subi_par_vaisseau,
degat_subi_par_defense,
date,id_membre,id_ennemi,id_planete,numero_combat,sauvegarde) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW(),?,?,?,?,?)');
$insert->execute(array($s['nom_vaisseau'],$s['attaque'],$s['bouclier'],$s['defense'],$tour,$categorie,
'vide',
ceil($VALEUR_ATTAQUE_PAR_CATEGORIE),
ceil($ATTAQUE_DIVISER_PAGE_DEF),
ceil($ATTAQUE_DIVISER),
ceil($Degats_par_vaisseau_fait_par_les_defense),
$id_membre_attaquant,$id_membre_defenseur,$id_planete_defenseur,$numero_combat_spatial,"apres"));
}


//VOIR POURQUOI IL NE PREND PAS EN COMPTE LES CHASSEURS ('voir partit chasseur')


?>
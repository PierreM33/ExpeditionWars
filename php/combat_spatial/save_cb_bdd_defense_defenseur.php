<?php

//INSERTION DANS LA BDD A CHAQUE TOUR DES DEFENSES DE LA PLANETE
$categorie='defense_planete';

$d=$bdd->prepare('SELECT def.id, def.nom_defense,def.attaque,def.defense,def.cadence_tir,defj.nombre_unite,defj.id_planete,defj.id_defense FROM defense AS def LEFT JOIN defense_joueur AS defj ON def.id=defj.id_defense WHERE defj.id_planete = ? AND defj.unite_possede=? AND nombre_unite >= ?');
$d->execute(array($id_planete_defenseur,1,1));

while($defense_planete=$d->fetch())
{
$nom_defense = $defense_planete['nom_defense'];
$nombre_unite = htmlentities($defense_planete['nombre_unite']);

//Si les degats sont inférieur à zero on le remplace par zéro
if($Degats_par_vaisseau_fait_par_les_defense <= 0)
{
$Degats_par_vaisseau_fait_par_les_defense = 0;
}

//definition variable
//$VALEUR_ATTAQUE_PAR_CATEGORIE = 0;

$mise_a_jour_degats=$bdd->prepare('INSERT INTO sauvegarde_composition_par_tour(nom_vaisseau,attaque,bouclier,defense,date,tour,categorie,nombre_defense,
degat_fait_au_defense,
degat_fait_au_vaisseau,
degat_subi_par_vaisseau,
degat_subi_par_defense,
id_membre,id_ennemi,id_planete,id_vaisseau,id_defense,numero_combat,sauvegarde) VALUES(?,?,?,?,NOW(), ?,?,?,?,?, ?,?,?,?,?, ?,?,?,? )');
$mise_a_jour_degats->execute(array($nom_defense,$ch_attaque,0,$ch_defense,$tour,"defense_planete",$nombre_unite,
0,
$Degats_par_vaisseau_fait_par_les_defense,
$VALEUR_ATTAQUE_SUR_DEFENSE,
0,
$id_membre_attaquant,$id_membre_defenseur,$id_planete_defenseur,0,$defense_planete['id'],$numero_combat_spatial,"apres"));
									


}


?>
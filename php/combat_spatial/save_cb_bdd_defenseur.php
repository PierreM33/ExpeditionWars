<?php

$categorie='defenseur';

//SELECTIONNE LES VAISSEAUX DU DEFENSEUR
$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id_action = ? ');
$select->execute(array($id_membre_defenseur,$id_planete_defenseur,0));
while($sd=$select->fetch())
{

//Enregistre les vaisseaux du défenseur
$insert=$bdd->prepare('INSERT INTO sauvegarde_composition_par_tour(nom_vaisseau,attaque,bouclier,defense,tour,categorie,nombre_defense,
degat_fait_au_defense,
degat_fait_au_vaisseau,
degat_subi_par_vaisseau,
degat_subi_par_defense,
date,id_membre,id_ennemi,id_planete,numero_combat,sauvegarde) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW(),?,?,?,?,?)');
$insert->execute(array($sd['nom_vaisseau'],$sd['attaque'],$sd['bouclier'],$sd['defense'],$tour,$categorie,'vide',
'aucun',
ceil($ATTAQUE_DIVISER),
ceil($ATTAQUE_DIVISER_PAGE_DEF),
'aucun',
$id_membre_attaquant,$id_membre_defenseur,$id_planete_defenseur,$numero_combat_spatial,"apres"));

}

?>
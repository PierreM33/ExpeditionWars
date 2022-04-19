<?php
//FICHIER QUI SAUVEGARDE LES COMPOSITIONS AVANT LE COMBAT

$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ? ');
$select->execute(array($id_membre_attaquant,$id_action));
while($s=$select->fetch())
{
		$stock_gold = $s['stock_gold'];
		$stock_titane = $s['stock_titane'];
		$stock_cristal = $s['stock_cristal'];
		$stock_orinia = $s['stock_orinia'];
		$stock_orinium = $s['stock_orinium'];
		$surnom = $s['surnom'];
				
//AJOUTE LE VAISSEAU DANS LES COMPOSITION DE DEPART. 
//PENSER A REJOUTER LES AUTRES STATISTIQUES UNE FOIS FINI

$sav=$bdd->prepare('INSERT INTO sauvegarde_composition_avant_combat
(id_vaisseau, nom_vaisseau, surnom_vaisseau, attaque, bouclier, defense, vitesse, type, gabarit, poid, fret, chasseur, objet_un, objet_deux,
id_membre_vise, id_membre, id_hangar, planete_vise, id_planete_origine, nombre_unite, numero_combat, appartenance, stock_gold, stock_titane, stock_cristal, stock_orinia, stock_orinium) VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?)');
$sav->execute(array($s['id'],$s['nom_vaisseau'],$surnom,$s['attaque'],$s['bouclier'],$s['defense'],$s['vitesse'],$s['type'],$s['gabarit'],$s['poid'],$s['fret'],$s['chasseur'],$s['objet_un'],$s['objet_deux'],$id_membre_defenseur,$id_membre_attaquant,$s['id_hangar'],$id_planete_defenseur,$id_planete_attaquant,1,$numero_combat_spatial,'attaquant',$stock_gold,$stock_titane,$stock_cristal,$stock_orinia,$stock_orinium)); 

}


//SELECTIONNE LES VAISSEAUX DU DEFENSEUR
$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id_action = ?');
$select->execute(array($id_membre_defenseur,$id_planete_defenseur,0));
while($sd=$select->fetch())
{
//AJOUT DES DEFENSEURS
$sav=$bdd->prepare('INSERT INTO sauvegarde_composition_avant_combat(id_vaisseau,nom_vaisseau,attaque,bouclier,defense,vitesse,type,gabarit,poid,fret,chasseur,objet_un,objet_deux,id_membre_vise,id_membre,id_hangar,planete_vise,id_planete_origine,nombre_unite,numero_combat,appartenance) VALUES (?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?)');
$sav->execute(array($sd['id'],$sd['nom_vaisseau'],$sd['attaque'],$sd['bouclier'],$sd['defense'],$sd['vitesse'],$sd['type'],$sd['gabarit'],$sd['poid'],$sd['fret'],$sd['chasseur'],$sd['objet_un'],$sd['objet_deux'],$id_membre_attaquant,$id_membre_defenseur,$sd['id_hangar'],'aucune',$id_planete_defenseur,1,$numero_combat_spatial,'defenseur')); 

}

//AJOUT DES DEFENSES
$d=$bdd->prepare('SELECT def.id, def.nom_defense,def.attaque,def.defense,def.cadence_tir, defj.nombre_unite,defj.id_planete,defj.id_defense FROM defense AS def LEFT JOIN defense_joueur AS defj ON def.id=defj.id_defense WHERE defj.id_planete = ? AND defj.unite_possede=? AND defj.nombre_unite >= ?');
$d->execute(array($id_planete_defenseur,1,1));
while($defense_planete=$d->fetch())
{	

$sav=$bdd->prepare('INSERT INTO sauvegarde_composition_avant_combat(id_vaisseau,nom_vaisseau,attaque,bouclier,defense,vitesse,type,gabarit,poid,fret,chasseur,objet_un,objet_deux,id_membre_vise,id_membre,id_hangar,planete_vise,id_planete_origine,nombre_unite,numero_combat,appartenance) VALUES (?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?)');
$sav->execute(array($defense_planete['id'],$defense_planete['nom_defense'],$defense_planete['attaque'],'aucun',$defense_planete['defense'],0,'aucun',0,0,0,0,'aucun','aucun',$id_membre_attaquant,$id_membre_defenseur,'aucun','aucune',$defense_planete['id_planete'],htmlentities($defense_planete['nombre_unite']),$numero_combat_spatial,'defense')); 


}

?>
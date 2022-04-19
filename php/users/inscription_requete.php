<?php
						
$select=$bdd->prepare('SELECT * FROM planete WHERE id_membre = ?');
$select->execute(array($id_membre));
$select_pla=$select->fetch();

$id_planete=htmlentities($select_pla['id']);
$pseudo=htmlentities($select_pla['pseudo_membre']);
	
$insertmembretrois = $bdd->prepare("UPDATE membre SET planete_utilise = ? , credit = ? WHERE ID = $id_membre");
$insertmembretrois->execute(array($id_planete,0));			


$insertplanetedeux = $bdd->prepare("UPDATE planete SET id_population = ?, id_mine = ?, id_batiment = ?, id_defense = ?, id_caserne = ? WHERE ID = ?");
$insertplanetedeux->execute(array($id_planete,$id_planete,$id_planete,$id_planete,$id_planete,$id_planete));
	
//ALLIANCE DEMANDE
$all_demande = $bdd->prepare('INSERT INTO alliance_demande_joueur(demande,id_all_regard,id_membre) VALUES (?,?,?)');
$all_demande->execute(array(0,0,$id_membre));

//ALLIANCE MEMBRE
$all_membre = $bdd->prepare('INSERT INTO alliance_membre(id_membre,id_alliance,nom_alliance) VALUES (?,?,?)');
$all_membre->execute(array($id_membre,0,"Aucune"));


// RESSOURCES PAR PLANETE	
$insertressource = $bdd->prepare('INSERT INTO ressource(gold,titane,cristal,orinia,orinium,energie,organique,temps,id_planete,id_membre) VALUES (?,?,?,?,?,?,?,NOW(),?,?)');
$insertressource->execute(array(10000,10000,10000,10000,10000,700,0,$id_planete,$id_membre));
																																							
																																							
// POPULATION PAR PLANETE																			
$insertpopulation = $bdd->prepare('INSERT INTO population(id_planete,civil,chercheur,soldat,ouvrier,pilote,esclave,population) VALUES (?,?,?,?,?,?,?,?)');
$insertpopulation->execute(array($id_planete,0,0,0,0,0,0,1000));

//Soit 72 eures
$temps_protection = time()+259200;

//PROTECTION
$protection_j=$bdd->prepare('INSERT INTO protection_joueur(date_inscription,id_membre,id_planete,protection_temps) VALUES (NOW(),?,?,?)');
$protection_j->execute(array($id_membre,$id_planete,$temps_protection));


//SALLE DE CONTROLE ATTAQUE OUI OU NON
$attaquesdc=$bdd->prepare('INSERT INTO attaque_sdc(id_membre,attaque_oui,id_planete) VALUES (?,?,?)');
$attaquesdc->execute(array($id_membre,0,$id_planete));

// MINES
$mines=$bdd->prepare('INSERT INTO mines_joueur(ouvrier,esclave,id_mine,id_planete,mine_possede) VALUES (:ouvrier, :esclave, :id_mine, :id_planete, :mine_possede)');

$values = array(
array(0,0,1,$id_planete,1),
array(0,0,2,$id_planete,1),
array(0,0,3,$id_planete,1),
array(0,0,4,$id_planete,1),
array(0,0,5,$id_planete,1),
array(0,0,6,$id_planete,0),
);

foreach ($values as $value) {

	$mines->bindValue(':ouvrier', $value[0], PDO::PARAM_STR);
	$mines->bindValue(':esclave', $value[1], PDO::PARAM_STR);
	$mines->bindValue(':id_mine', $value[2], PDO::PARAM_STR);
	$mines->bindValue(':id_planete', $value[3], PDO::PARAM_STR);
	$mines->bindValue(':mine_possede', $value[4], PDO::PARAM_STR);
  
  $mines->execute();
}

//ETABLISSEMENTS
$etablissement=$bdd->prepare('INSERT INTO etablissement_joueur(prix_gold, prix_titane, prix_cristal, prix_orinia, prix_orinium, prix_organique, temps, construction,niveau,etab_possede,id_etab,id_planete,joueur) VALUES (:prix_gold, :prix_titane, :prix_cristal, :prix_orinia, :prix_orinium, :prix_organique, :temps, :construction, :niveau, :etab_possede, :id_etab, :id_planete, :joueur)');

$values = array(
array(125,120,105,0,0,0,60,0,0,1,1,$id_planete,$id_membre),//laboratoire recherche
array(1000,1200,975,1500,0,0,720,0,0,1,2,$id_planete,$id_membre), // laboratoire defense
array(210,180,50,200,0,0,30,0,0,1,3,$id_planete,$id_membre), // Caserne
array(150,200,100,0,0,0,240,0,0,1,4,$id_planete,$id_membre),//centre espionnage
array(2500,2300,1650,1250,0,0,1500,0,0,1,5,$id_planete,$id_membre),// hangar spatial

);

//array(500,250,800,150,0,0,300,0,0,1,4,$id_planete,$id_membre), //entrepot artefact

foreach ($values as $value) {

	$etablissement->bindValue(':prix_gold', $value[0], PDO::PARAM_STR);
	$etablissement->bindValue(':prix_titane', $value[1], PDO::PARAM_STR);
	$etablissement->bindValue(':prix_cristal', $value[2], PDO::PARAM_STR);
	$etablissement->bindValue(':prix_orinia', $value[3], PDO::PARAM_STR);
	$etablissement->bindValue(':prix_orinium', $value[4], PDO::PARAM_STR);
	$etablissement->bindValue(':prix_organique', $value[5], PDO::PARAM_STR);
	$etablissement->bindValue(':temps', $value[6], PDO::PARAM_STR);
	$etablissement->bindValue(':construction', $value[7], PDO::PARAM_STR);
	$etablissement->bindValue(':niveau', $value[8], PDO::PARAM_STR);
	$etablissement->bindValue(':etab_possede', $value[9], PDO::PARAM_STR);
	$etablissement->bindValue(':id_etab', $value[10], PDO::PARAM_STR);
	$etablissement->bindValue(':id_planete', $value[11], PDO::PARAM_STR);
	$etablissement->bindValue(':joueur', $value[12], PDO::PARAM_STR);
  
  $etablissement->execute();
}

//EQUIPE EXPLORATION 
$eq=$bdd->prepare('INSERT INTO equipe_exploration_joueur(id_equipe,id_planete,experience,niveau,nombre,disponible,temps,unite_possede) VALUES (:id_equipe,:id_planete,:experience,:niveau,:nombre,:disponible,:temps,:unite_possede)');

$values = array(
array(1,$id_planete,0,0,0,0,2312,0),
array(2,$id_planete,0,0,0,0,2312,0),

);

foreach ($values as $value) {


	$eq->bindValue(':id_equipe', $value[0], PDO::PARAM_STR);
	$eq->bindValue(':id_planete', $value[1], PDO::PARAM_STR);
	$eq->bindValue(':experience', $value[2], PDO::PARAM_STR);
	$eq->bindValue(':niveau', $value[3], PDO::PARAM_STR);
	$eq->bindValue(':nombre', $value[4], PDO::PARAM_STR);
	$eq->bindValue(':disponible', $value[5], PDO::PARAM_STR);
	$eq->bindValue(':temps', $value[6], PDO::PARAM_STR);
	$eq->bindValue(':unite_possede', $value[7], PDO::PARAM_STR);
  
  $eq->execute();
}


//CASERNE: UNITE DE LA CASERNE PAR JOUEUR
$cas=$bdd->prepare('INSERT INTO caserne_joueur(nombre_unite,id_planete,id_caserne,unite_possede,unite_combat) VALUES (:nombre_unite,:id_planete,:id_caserne,:unite_possede,:unite_combat)');

$values = array(
array(0,$id_planete,1,0,0),
array(0,$id_planete,2,0,0),
array(0,$id_planete,3,0,1),
array(0,$id_planete,4,0,1),
array(0,$id_planete,5,0,1),
array(0,$id_planete,6,0,1),
array(0,$id_planete,7,0,1),
array(0,$id_planete,8,0,1),
array(0,$id_planete,9,0,1),
array(0,$id_planete,10,0,1),
array(0,$id_planete,11,0,0),
);

foreach ($values as $value) {


	$cas->bindValue(':nombre_unite', $value[0], PDO::PARAM_STR);
	$cas->bindValue(':id_planete', $value[1], PDO::PARAM_STR);
	$cas->bindValue(':id_caserne', $value[2], PDO::PARAM_STR);
	$cas->bindValue(':unite_possede', $value[3], PDO::PARAM_STR);
	$cas->bindValue(':unite_combat', $value[4], PDO::PARAM_STR);
	
  $cas->execute();
}


//DEFENSE: UNITE PAR JOUEUR
$def=$bdd->prepare('INSERT INTO defense_joueur(nombre_unite,id_planete,id_defense,unite_possede) VALUES (:nombre_unite,:id_planete,:id_defense,:unite_possede)');

$values = array(
array(0,$id_planete,1,0),
array(0,$id_planete,2,0),
array(0,$id_planete,3,0),
array(0,$id_planete,4,0),
array(0,$id_planete,5,0),
array(0,$id_planete,6,0),
array(0,$id_planete,7,0),
array(0,$id_planete,8,0),
array(0,$id_planete,9,0),
array(0,$id_planete,10,0),
);

foreach ($values as $value) {


	$def->bindValue(':nombre_unite', $value[0], PDO::PARAM_STR);
	$def->bindValue(':id_planete', $value[1], PDO::PARAM_STR);
	$def->bindValue(':id_defense', $value[2], PDO::PARAM_STR);
	$def->bindValue(':unite_possede', $value[3], PDO::PARAM_STR);
	
  $def->execute();
}

//TECHNOLOGIES PAR JOUEUR
$technologie=$bdd->prepare('INSERT INTO technologie_joueur(prix_gold, prix_titane, prix_cristal, prix_orinia, prix_orinium, prix_organique,nombre_chercheur,niveau,temps,construction,technologie_possede,id_membre,id_technologie) VALUES (:prix_gold, :prix_titane, :prix_cristal, :prix_orinia, :prix_orinium, :prix_organique, :nombre_chercheur, :niveau, :temps, :construction, :technologie_possede, :id_membre, :id_technologie)');

$values = array(
//COMMUNE
array(150,150,150,150,150,0,3,0,300,0,0,$id_membre,1),//espionnage
array(0,0,0,300,300,0,2,0,150,0,0,$id_membre,2),//maitrise E
array(150,0,350,0,0,0,5,0,150,0,0,$id_membre,3), //Connaissance Ori
array(0,0,200,0,200,0,6,0,150,0,0,$id_membre,4), // astronautique
array(200,200,200,50,100,0,2,0,600,0,0,$id_membre,5), // radar orbite
array(100,150,0,0,0,0,3,0,180,0,0,$id_membre,6), //equipement terrestre
array(280,200,315,180,60,0,9,0,90,0,0,$id_membre,7), //equipement spatial

//VALHAR
array(500,0,500,500,0,0,50,0,600,0,0,$id_membre,8),//Savoir valhar
array(450,0,750,800,0,0,10,0,780,0,0,$id_membre,9),//Structure vaisseau
array(700,0,700,800,0,0,9,0,720,0,0,$id_membre,10),//armement
array(700,0,700,800,0,0,7,0,900,0,0,$id_membre,11),//coque
array(250,0,300,400,0,0,11,0,840,0,0,$id_membre,12),//sublu
array(500,0,700,1000,0,0,14,0,720,0,0,$id_membre,13),//hyper propulsion
array(850,0,400,800,0,0,11,0,600,0,0,$id_membre,14),//bouclier 1
array(1000,0,850,900,0,0,18,0,900,0,0,$id_membre,15),//bouclier 2
array(1000,0,750,800,0,0,22,0,1200,0,0,$id_membre,16),//armement enrichie

// ORAK
array(500,500,0,500,0,0,50,0,600,0,0,$id_membre,17),//savoir
array(700,800,0,700,0,0,6,0,780,0,0,$id_membre,18),//armement
array(800,700,0,600,0,0,9,0,720,0,0,$id_membre,19),//coque
array(750,800,0,450,0,0,9,0,900,0,0,$id_membre,20),//structure vaisseau
array(900,1000,0,400,0,0,10,0,720,0,0,$id_membre,21),//bouclier
array(350,250,0,400,0,0,13,0,600,0,0,$id_membre,22),//sublu
array(700,500,0,900,0,0,13,0,900,0,0,$id_membre,23),//hyper propulsion
array(250,300,0,200,0,0,5,0,780,0,0,$id_membre,24),//explosif
array(200,0,650,0,0,0,7,0,900,0,0,$id_membre,25),//cristal combat

//HUMAIN
//Mémo de l'ordre : prix_gold, prix_titane, prix_cristal, prix_orinia, prix_orinium, prix_organique,nombre_chercheur,niveau,temps,construction,technologie_possede,id_membre,id_technologie
array(500,500,0,0,500,0,39,0,600,0,0,$id_membre,26),//Savoir
array(550,800,0,0,700,0,7,0,780,0,0,$id_membre,27),//armement
array(450,700,0,0,600,0,10,0,720,0,0,$id_membre,28),//coque
array(250,300,0,0,200,0,8,0,840,0,0,$id_membre,29),//explosif
array(700,800,0,0,500,0,8,0,660,0,0,$id_membre,30),//structure
array(350,200,0,0,400,0,6,0,840,0,0,$id_membre,31),//sublu
array(1000,700,0,0,600,0,11,0,900,0,0,$id_membre,32),//Missiles enrichie orinium
//ne pas oublier la technologie rajouté en bas

//DROIDE
array(0,0,500,500,500,0,59,0,600,0,0,$id_membre,33),//Savoir droide
array(0,0,250,300,400,0,9,0,720,0,0,$id_membre,34),//connexion galaxtique
array(0,0,800,700,500,0,10,0,780,0,0,$id_membre,35),//armement
array(0,0,700,900,800,0,11,0,900,0,0,$id_membre,36),//bouclier nano
array(0,0,800,750,850,0,18,0,840,0,0,$id_membre,37),//coque
array(0,0,600,400,350,0,13,0,660,0,0,$id_membre,38),//structure nano robot
array(0,0,700,800,900,0,17,0,840,0,0,$id_membre,39),//hyper propulsion
array(0,0,850,950,600,0,19,0,900,0,0,$id_membre,40),//hyper espace


//ANKARIEN - INCONNU ( Ankarien signifie Ancien)
array(4500,4500,4500,4500,4500,0,92,0,5400,0,0,$id_membre,41),//savoir ankarien

///INCONNU  42 et 43 
array(0,0,300,400,500,0,100,0,1200,0,0,$id_membre,42), // drone
array(0,0,700,350,400,0,39,0,1260,0,0,$id_membre,43),// maitrise ETN

///ANKARIEN
array(750,800,900,700,456,0,69,0,1740,0,0,$id_membre,44),//armement
array(0,0,1400,1050,600,0,89,0,1800,0,0,$id_membre,45), //bouclier
array(850,900,800,950,900,0,79,0,2040,0,0,$id_membre,46), //Structure de vaisseaux Ankarien 
array(200,1500,250,900,0,0,60,0,2100,0,0,$id_membre,47),//Coque de vaisseaux Ankarien 
array(800,0,900,800,600,0,72,0,1980,0,0,$id_membre,48),// Hyper propulsion

// HUMAIN AJOUTE
array(700,800,0,0,700,0,12,0,740,0,0,$id_membre,49), //bouclier humain

//COMMUNE RAJOUTE
array(500,500,500,500,500,0,25,0,1800,0,0,$id_membre,50), //colonisation
array(600,0,0,0,600,0,55,0,3600,0,0,$id_membre,51), //boost attaque
array(0,1200,0,0,0,0,45,0,3600,0,0,$id_membre,52), //boost coque
array(0,0,600,600,0,0,65,0,3600,0,0,$id_membre,53), //boost bouclier

//INCONNU SUITE
//Or - Titane - Cristal - Orinia - Orinium - Matiere Organique
//Mémo de l'ordre : prix_gold, prix_titane, prix_cristal, prix_orinia, prix_orinium, prix_organique,nombre_chercheur,niveau,temps,construction,technologie_possede,id_membre,id_technologie
array(1195,0,2473,1306,1128,0,1796,0,18000,0,0,$id_membre,54), //Virus
);

foreach ($values as $value) {

	$technologie->bindValue(':prix_gold', $value[0], PDO::PARAM_STR);
	$technologie->bindValue(':prix_titane', $value[1], PDO::PARAM_STR);
	$technologie->bindValue(':prix_cristal', $value[2], PDO::PARAM_STR);
	$technologie->bindValue(':prix_orinia', $value[3], PDO::PARAM_STR);
	$technologie->bindValue(':prix_orinium', $value[4], PDO::PARAM_STR);
	$technologie->bindValue(':prix_organique', $value[5], PDO::PARAM_STR);
	$technologie->bindValue(':nombre_chercheur', $value[6], PDO::PARAM_STR);
	$technologie->bindValue(':niveau', $value[7], PDO::PARAM_STR);
	$technologie->bindValue(':temps', $value[8], PDO::PARAM_STR);
	$technologie->bindValue(':construction', $value[9], PDO::PARAM_STR);
	$technologie->bindValue(':technologie_possede', $value[10], PDO::PARAM_STR);
	$technologie->bindValue(':id_membre', $value[11], PDO::PARAM_STR);
	$technologie->bindValue(':id_technologie', $value[12], PDO::PARAM_STR);
  
  $technologie->execute();
}

//OBJET PAR JOUEUR
$objet=$bdd->prepare('INSERT INTO objet_joueur(id_objet,objet_possede,nombre_objet,id_planete,id_membre,ajout) VALUES (:id_objet,:objet_possede,:nombre_objet,:id_planete,:id_membre,:ajout)');

$values = array(
array(1,0,0,$id_planete,$id_membre,0),
array(2,0,0,$id_planete,$id_membre,0),
array(3,0,0,$id_planete,$id_membre,0),
array(4,0,0,$id_planete,$id_membre,1),
array(5,0,0,$id_planete,$id_membre,1),
array(6,0,0,$id_planete,$id_membre,1),
array(7,0,0,$id_planete,$id_membre,0),
array(8,0,0,$id_planete,$id_membre,1),
array(9,0,0,$id_planete,$id_membre,1),
array(10,0,0,$id_planete,$id_membre,1),
array(11,0,0,$id_planete,$id_membre,1),
array(12,0,0,$id_planete,$id_membre,1),
array(13,0,0,$id_planete,$id_membre,1),
array(14,0,0,$id_planete,$id_membre,0),
array(15,0,0,$id_planete,$id_membre,1),
array(16,0,0,$id_planete,$id_membre,1),
array(17,0,0,$id_planete,$id_membre,1),
array(18,0,0,$id_planete,$id_membre,1),
array(19,0,0,$id_planete,$id_membre,1),
array(20,0,0,$id_planete,$id_membre,1),
array(21,0,0,$id_planete,$id_membre,1),
array(22,0,0,$id_planete,$id_membre,1),
array(23,0,0,$id_planete,$id_membre,1),
array(24,0,0,$id_planete,$id_membre,1),
array(25,0,0,$id_planete,$id_membre,1),
array(26,0,0,$id_planete,$id_membre,1),
array(27,0,0,$id_planete,$id_membre,1),
array(28,0,0,$id_planete,$id_membre,1),
array(29,0,0,$id_planete,$id_membre,1),
array(30,0,0,$id_planete,$id_membre,1),
array(31,0,0,$id_planete,$id_membre,1),
array(32,0,0,$id_planete,$id_membre,1),
array(33,0,0,$id_planete,$id_membre,1),
array(34,0,0,$id_planete,$id_membre,1),
array(35,0,0,$id_planete,$id_membre,1),
array(36,0,0,$id_planete,$id_membre,1),
array(37,0,0,$id_planete,$id_membre,1),
array(38,0,0,$id_planete,$id_membre,1),
array(39,0,0,$id_planete,$id_membre,1),
array(40,0,0,$id_planete,$id_membre,1),
);

foreach ($values as $value) {


	$objet->bindValue(':id_objet', $value[0], PDO::PARAM_STR);
	$objet->bindValue(':objet_possede', $value[1], PDO::PARAM_STR);
	$objet->bindValue(':nombre_objet', $value[2], PDO::PARAM_STR);
	$objet->bindValue(':id_planete', $value[3], PDO::PARAM_STR);
	$objet->bindValue(':id_membre', $value[4], PDO::PARAM_STR);
	$objet->bindValue(':ajout', $value[5], PDO::PARAM_STR);
	
  $objet->execute();
}


// SAUVEGARDE ACHAT TECHNOLOGIES
$sauvegarde_achat_technologie=$bdd->prepare('INSERT INTO sauvegarde_achat_technologie(nom_technologie,id_cache,id_membre) VALUES (?,?,?)');
$sauvegarde_achat_technologie->execute(array('aucunachat',0,$id_membre));

// STRATEGIE
$strat=$bdd->prepare('INSERT INTO strategie(id_membre,pourcentage_attaque_au_defense,sortie_chasseur,coloniser_actif) VALUES (?,?,?,?)');
$strat->execute(array($id_membre,0,5,0));


//CHANTIER SPATIAL
$chantier_spatial=$bdd->prepare('INSERT INTO chantier_spatial(surnom_vaisseau, nom, prix_gold, prix_titane, prix_cristal, prix_orinia, prix_orinium, prix_organique, pilote, ouvrier, defense, attaque, bouclier, vitesse, poid, image, chasseur, place_chasseur, fret, type, race, vaisseau_possede, temps, gabarit, nom_objet_un, nom_objet_deux, nombre_objet_un, nombre_objet_deux, id_planete, id_joueur) 
VALUES (:surnom_vaisseau, :nom, :prix_gold, :prix_titane, :prix_cristal, :prix_orinia, :prix_orinium, :prix_organique, :pilote, :ouvrier, :defense, :attaque, :bouclier, :vitesse, :poid, :image, :chasseur, :place_chasseur, :fret, :type, :race, :vaisseau_possede, :temps, :gabarit, :nom_objet_un, :nom_objet_deux, :nombre_objet_un, :nombre_objet_deux, :id_planete, :id_joueur)');

$values = array(
array('', 'Chasseur Valharien', '6000', '900', '4500', '3000', '600', '0', 1, 1, '110', '60', '10', 120, 0, 'chval.gif', 0, 0, 0, 'Chasseur', 'valhar', 0, 1230, '1', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Chasseur Orak', '4500', '1800', '300', '3600', '600', '0', 1, 1, '100', '80', '0', 100, 0, 'chorak.gif', 0, 0, 0, 'Chasseur', 'orak', 0, 1200, '1', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Chasseur Humain', '3300', '6000', '600', '600', '4500', '0', 1, 1, '80', '100', '0', 90, 0, 'chum.gif', 0, 0, 0, 'Chasseur', 'humain', 0, 1170, '1', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Chasseur Droide', '750', '450', '3900', '2700', '2100', '0', 1, 1, '50', '70', '0', 100, 0, 'chdro.gif', 0, 0, 0, 'Chasseur', 'droide', 0, 1200, '1', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Chasseur Ankarien', '6000', '6000', '3600', '3450', '1800', '0', 1, 1, '120', '110', '20', 100, 0, 'chanka.gif', 0, 0, 0, 'Chasseur', 'ancien', 0, 1400, '1', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),

array('', 'Belsinka', '60000', '105000', '45000', '24000', '19500', '0', 2, 3, '3000', '4000', '2500', 1000, 0, 'belsinka.gif', 0, 2, 35000, 'Leger', 'valhar', 0, 2430, '2', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Vipere stellaire', '75000', '120000', '7500', '7500', '90000', '0', 2, 3, '3000', '4000', '2500', 1000, 0, 'vipere.gif', 0, 4, 35000, 'Leger', 'orak', 0, 2400, '2', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Intercepteur Y-95', '60000', '105000', '15000', '15000', '60000', '0', 2, 3, '3200', '2800', '2000', 1000, 0, 'y95.gif', 0, 6, 35000, 'Leger', 'humain', 0, 2370, '2', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'ZX-308', '60000', '105000', '45000', '24000', '19500', '0', 2, 3, '3000', '4000', '2500', 1000, 0, 'zx308.gif', 0,12, 35000, 'Leger', 'droide', 0, 2400, '2', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Croiseur B35', '60000', '105000', '45000', '24000', '19500', '0', 2, 3, '3000', '4000', '2500', 1000, 0, 'b35.gif', 0,12, 35000, 'Leger', 'ancien', 0, 3000, '2', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),

array('', 'Fregate TI', '240000', '60000', '225000', '195000', '60000', '0', 5, 15, '8500', '11000', '13000', 1000, 0, 'fregate.gif', 0, 6, 150000, 'Moyen', 'valhar', 0, 4530, '4', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Destroyer stellaire', '240000', '150000', '18000', '210000', '18000', '0', 5, 15, '8200', '11800', '9000', 1000, 0, 'destroyer.gif', 0, 9, 150000, 'Moyen', 'orak', 0, 4500, '4', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Croiseur Impérial X1', '135000', '225000', '45000', '48000', '195000', '0', 5, 15, '9400', '10600', '7000', 1000, 0, 'croiseur.gif', 0, 13, 150000, 'Moyen', 'humain', 0, 4070, '4', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Destructeur', '45000', '45000', '240000', '180000', '240000', '0', 5, 15, '8000', '12500', '13000', 1000, 0, 'destructeur.gif', 0, 18, 150000, 'Moyen', 'droide', 0, 4500, '4', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Bombardier', '165000', '210000', '165000', '216000', '216000', '0', 5, 15, '12000', '15000', '13500', 1000, 0, 'bombardier.gif', 0, 10, 150000, 'Moyen', 'ancien', 0, 4800, '4', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),

array('', 'Valkyr Mere', 345000, '15000',450000, '390000', 24000, '0', 10, '50',21000, '24500',22500, '1000', 0, 'valky.gif', 0, 10, 200000, 'Lourd', 'valhar', 0, 7400, '5', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Corhyp', 390000, '300000',78000, '345000', 75000, '0', 10, '50',21700, '24300',20000, '1000', 0, 'corhyp.gif', 0, 17, 200000, 'Lourd', 'orak', 0, 7200, '5', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Pactis B305', 360000, '390000',18000, '18000', 300000, '0', 10, '50',23000, '21000',18000, '1000', 0, 'pactis.gif', 0, 25, 200000, 'Lourd', 'humain', 0, 7000, '5', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Drone H308', 24000, '24000',420000, '390000', 330000, '0', 10, '50',20400, '25600',19000, '1000', 0, 'h308.gif', 0, 35, 200000, 'Lourd', 'droide', 0, 7200, '5', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),
array('', 'Amiral Anka', 270000, '320000',255000, '335000', 300000, '0', 10, '50',26000, '29000',27000, '1000', 0, 'amiral.gif', 0, 20, 200000, 'Lourd', 'ancien', 0, 8400, '5', 'aucun', 'aucun', '0', '0', $id_planete,$id_membre),

);

foreach ($values as $value) {


	$chantier_spatial->bindValue(':surnom_vaisseau', $value[0], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':nom', $value[1], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':prix_gold', $value[2], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':prix_titane', $value[3], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':prix_cristal', $value[4], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':prix_orinia', $value[5], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':prix_orinium', $value[6], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':prix_organique', $value[7], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':pilote', $value[8], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':ouvrier', $value[9], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':defense', $value[10], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':attaque', $value[11], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':bouclier', $value[12], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':vitesse', $value[13], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':poid', $value[14], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':image', $value[15], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':chasseur', $value[16], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':place_chasseur', $value[17], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':fret', $value[18], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':type', $value[19], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':race', $value[20], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':vaisseau_possede', $value[21], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':temps', $value[22], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':gabarit', $value[23], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':nom_objet_un', $value[24], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':nom_objet_deux', $value[25], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':nombre_objet_un', $value[26], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':nombre_objet_deux', $value[27], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':id_planete', $value[28], PDO::PARAM_STR);
	$chantier_spatial->bindValue(':id_joueur', $value[29], PDO::PARAM_STR);

	
  $chantier_spatial->execute();
}

//POINT FIDELITE
$fidelite=$bdd->prepare('INSERT INTO fidelite(id_membre,pseudo,point_f) VALUES (?,?,?)');
$fidelite->execute(array($id_membre,$pseudo,0));


$temps_c = time() + 84600;

//connexion_joueur
$con_j=$bdd->prepare('INSERT INTO connexion_joueur(id_membre,temps,valide,bonus) VALUES (?,?,?,?)');
$con_j->execute(array($id_membre,$temps_c,0,0));


//MORAL
$moral=$bdd->prepare('INSERT INTO moral(id_membre,pseudo_membre,moral) VALUES (?,?,?)');
$moral->execute(array($id_membre,$pseudo,0));

$temperer = "Temperé";
$plaine_montagne = "Plaine, Montagne";

//TERRITOIRE
$territoire=$bdd->prepare('INSERT INTO territoire_planete(id_membre,id_planete,territoire_total,territoire_decouvert,climant,zone) VALUES (?,?,?,?,?,?)');
$territoire->execute(array($id_membre,$id_planete,7,7,utf8_encode($temperer),utf8_encode($plaine_montagne)));

//INFRASTRUCTURE
$infrastructure=$bdd->prepare('INSERT INTO infrastructure(id_membre,id_planete,niveau,limite, gold, titane,cristal, orinia, orinium, nom) VALUES (?,?,?,?,?,?,?,?,?,?)');
$infrastructure->execute(array($id_membre,$id_planete,1,2000,250,250,250,250,250,"Campement"));

//NOMBRE DE TOURS DE COMBAT SPATIAL
$nb=$bdd->prepare('INSERT INTO nombre_tour(id_membre,nombre_tour) VALUES (?,?)');
$nb->execute(array($id_membre,10));

//PORTAIL
$portail=$bdd->prepare('INSERT INTO portail(id_planete,actif,exploration,interagir,id_membre,protection_lien) VALUES (?,?,?,?,?,?)');
$portail->execute(array($id_planete,0,0,0,0,0));

//POINT HONNEUR
$honneur=$bdd->prepare('INSERT INTO point_honneur(id_membre,nombre_point_honneur,pseudo) VALUES (?,?,?)');
$honneur->execute(array($id_membre,0,$pseudo));

//CHAT_JOUEUR
$chat=$bdd->prepare('INSERT INTO chat_joueur(id_membre,pseudo,message) VALUES (?,?,?)');
$chat->execute(array($id_membre,$pseudo,0));

//HISTORIQUE COMBAT SPATIAL
$historique=$bdd->prepare('INSERT INTO historique_combat_spatial_joueur(id_membre,combat_total,point_combat,victoire,defaite,match_nul,pseudo) VALUES (?,?,?,?,?,?,?)');
$historique->execute(array($id_membre,0,0,0,0,0,$pseudo));

// STABILITE
$Stabilite=$bdd->prepare('INSERT INTO stable(id_membre,stabilite,temps) VALUES (?,?,NOW())');
$Stabilite->execute(array($id_membre,0));

//LISTE MISSION
$Stabilite=$bdd->prepare('INSERT INTO mission_liste(id_membre,liste_mission) VALUES (?,?)');
$Stabilite->execute(array($id_membre,"[]"));


//QUETES
$quete=$bdd->prepare('INSERT INTO `quete` (`numero_quete`, `titre`, `texte`, `recompense`, `valide`, `id_membre` ,`quete_fini`) VALUES ( :numero_quete, :titre, :texte, :recompense, :valide, :id_membre, :quete_fini)');
$values = array(
array(1, 'Construction de bâtiments', 'Apprenez à construire un bâtiment "Laboratoire". Cliquez sur bâtiments, puis sur l\'onglet Etablissement. Sélectionnez ensuite le bâtiment à construire et empochez la récompense.', 'Gagnez 250 d\'or, 250 de titane et 250 de cristal ', 0, $id_membre,0),
array(2, 'Exploration', 'Pour obtenir votre récompense explorez votre première planète et découvrez ce que vous réserve l\'univers.', 'Gagnez 1200 d\'or, 600 de titane et 600 de cristal ', 0, $id_membre,0),
array(3, 'Améliorer l\'infrastructure', 'Améliorer l\'infrastructure de votre planète en vous rendant sur la salle de contrôle. Cliquez sur " TERRTOIRE DE LA PLANETE " et agrandissez votre village.', 'Gagnez 1.000 d\'or et 1.000  de titane.', 0, $id_membre,0),
array(4, 'Utiliser votre population', 'Pour obtenir votre récompense il vous faudra utiliser votre population, transformez votre population en ouvriers, scientifiques, soldats, pilotes ou civils pour obtenir votre récompense.', 'Gagnez 100 de population supplémentaire.', 0, $id_membre,0),
array(5, 'Intégrer une faction', 'Pour obtenir votre récompense il vous faudra intégrer la faction de votre choix. Rendez vous dans la partie faction situé à gauche pour cela.', 'Gagnez 100 soldats dans votre population.', 0, $id_membre,0),
array(6, 'Achat d\'un vaisseau', 'Acheter votre premier vaisseau dans le hangar spatial et obtenez une énorme récompense.', 'Gagnez 10.000 de chacune des ressources', 0, $id_membre,0),
);


foreach ($values as $value) {


	$quete->bindValue(':numero_quete', $value[0], PDO::PARAM_STR);
	$quete->bindValue(':titre', $value[1], PDO::PARAM_STR);
	$quete->bindValue(':texte', $value[2], PDO::PARAM_STR);
	$quete->bindValue(':recompense', $value[3], PDO::PARAM_STR);
	$quete->bindValue(':valide', $value[4], PDO::PARAM_STR);
	$quete->bindValue(':id_membre', $value[5], PDO::PARAM_STR);
		$quete->bindValue(':quete_fini', $value[6], PDO::PARAM_STR);
	
  $quete->execute();
}


//MESSAGE DE BIENVENU
$obj_message = " Bienvenue";
$message_B = "Bienvenue sur Expedition-Wars, vous allez maintenant devoir diriger un empire, nous avons mis à votre disposition des tutoriels pour que vous puissiez vous familiariser avec le jeu. 
Si toutefois vous avez des questions n'hésite pas à les poser sur discord du jeu, l'onglet se trouve en haut à gauche.
Des vidéos sont également en cours des créations. La plupart seront des tutoriels, mais il sera possible d'obtenir des informations au travers des vidéos.
De plus pour chaque énigme, il est possible de trouver les solutions dans les énigmes elles-mêmes.

Nous vous souhaitons une bonne expérience.

Le staff.";


$message=$bdd->prepare('INSERT INTO messagerie(id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES ( ?,?,?,NOW(),?,?)');
$message->execute(array(
$id_membre,
$id_membre,
$message_B,
0,
$obj_message

));

//MESSAGE NUMERO 2
//MESSAGE DE BIENVENU
$obj_message2 = "Histoire";
$message_B2 = "Bien le bonjour. Vous venez d'entrer dans un univers où se déroulent une histoire et des évènements. Tout au long de votre règne vous allez être confronté à divers joueurs.
Au-delà de votre empire, une ancienne civilisation créatrice du portail spatial a laissé des vestiges à travers l'univers. Vous devrez explorer les planètes de la galaxie pour y trouver tous ses secrets.

L'utilisation du portail est un facteur primordial pour votre empire, ne le négligez pas.

Votre Conseiller.";


$message=$bdd->prepare('INSERT INTO messagerie(id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES ( ?,?,?,NOW(),?,?)');
$message->execute(array(
$id_membre,
$id_membre,
$message_B2,
0,
$obj_message2

));


//Description des objets
$description_objet1 = "Cette Amulette est pourvue d'une force incroyable, seulement seul elle ne vous sert à rien, 5 d'entre elles ont été dissimulées dans l'univers, il vous en faudra 3 pour pouvoir résoudre l'énigme finale de la Cité caché.";
$description_objet2 = "Diamant dans lesquel se trouve une énergie indispensable pour débloquer l'accès à la dernière cité.Il vous faudra cumuler 3 diamants.";


//On insere egalement les objets_rare.
$insertion=$bdd->prepare('INSERT INTO objet_rare(id_objet_rare,id_membre,id_planete,nombre_objet,nom_objet,description,image) VALUES(?,?,?,?,?,?,?)');
$insertion->execute(array(1,$id_membre,$id_planete,0,"Amulette D'irakhan",$description_objet1,"amulette_rare.png"));

//On insere egalement les objets_rare.
$insertion=$bdd->prepare('INSERT INTO objet_rare(id_objet_rare,id_membre,id_planete,nombre_objet,nom_objet,description,image) VALUES(?,?,?,?,?,?,?)');
$insertion->execute(array(2,$id_membre,$id_planete,0,"Diamant",$description_objet2,"diamant.png"));


//Insertion des HEROS
//On insere egalement les objets_rare.
$insertion_heros=$bdd->prepare('INSERT INTO heros(id_membre,niveau,bonus,experience,experience_max,nom) VALUES(?,?,?,?,?,?)');
$insertion_heros->execute(array($id_membre,1,1,0,100,$pseudo));

?>
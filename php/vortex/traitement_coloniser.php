<?php

if($_POST)
{
	require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);
	
	//MEMBRE
	$ps=$bdd->prepare('SELECT * FROM membre WHERE id =?');
	$ps->execute(array($id_membre));
	$pseud=$ps->fetch();
	
	$pseudo = htmlentities($pseud['pseudo']);
	
	//ON RECUPERE LA FACTION DU JOUEUR
	$faction=$bdd->prepare('SELECT * FROM faction_joueur WHERE id_membre = ? ');
	$faction->execute(array($id_membre));
	$Fact=$faction->fetch();

	//ON RECUPERE ENSUITE LES LOIS ADOPTE DE CETTE FACTION POUR RECUPERER LA PRODUCTION SUPPLEMENTAIRE
	$faction_loi=$bdd->prepare('SELECT * FROM faction_loi WHERE faction = ? AND adopte = ? AND numero = ?');
	$faction_loi->execute(array(htmlentities($Fact['nom_faction']),1,0));
	$Fa_L=$faction_loi->fetch();
	
	//ON RAJOUTE LE POURCENTAGE DE PRODUCTION DE LA FACTION
	if(htmlentities($Fa_L['effet']) == "coloniser+1")
	{
	$faction = 1;

	}
	else
	{
	$faction = 0;

	}
	
	// OBTENIR LA LISTE DES UNITES COLONS
	$nb=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$nb->execute(array($planete_utilise,11));
	$nombre_colon=$nb->fetch();
	
	// OBTENIR LE NIVEAU DE LA TECHNO COLONISATION
	$lvl_esp=$bdd->prepare('SELECT * FROM technologie_joueur WHERE id_membre = ? AND id_technologie = ?');
	$lvl_esp->execute(array($id_membre,50));
	$t=$lvl_esp->fetch();
	
	//COMPTE LE NOMBRE DE PLANETE POSSEDE
	$pl=$bdd->prepare('SELECT * FROM planete WHERE id_membre = ?');
	$pl->execute(array($id_membre));
	$nbr_col=$pl->rowCount();
	
	//On retire la planete mère
	$colonie = $nbr_col-1;
	
	$nom_de_colonie = strip_tags($_POST['nom']);
	
	// RECUPERER LID DE LA PORTE CONNECTE
	$va=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$va->execute(array($planete_utilise));
	$id_porte_connecte=$va->fetch();
	
	//VERIFIE SI LA PLANETE EST OQP OU NON
	$pla=$bdd->prepare('SELECT * FROM planete WHERE id = ?');
	$pla->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
	$adres=$pla->fetch();

	//Adresse de la planete convoité et id de la planete
	$id_P = htmlentities($adres['id']);
	$adresse = htmlentities($adres['coordonnee_terrestre']);
	
		$R = htmlentities($t['niveau']) + $faction ;
		
if($id_P != 0)
{	
	
	if($colonie == 0)
	{
		$colon_besoin = 100;
	}
	else
	{
		$colon_besoin = $colonie * 100; 
	}
	
	if(htmlentities($nombre_colon['nombre_unite']) >= $colon_besoin)
		{
			if(is_numeric($nombre_colon['nombre_unite']))
				{
				
				if($R > $colonie)
					{
						if($nom_de_colonie != "")
						{
						


						//CASERNE RETRAIT COLONS
						$nb=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-? WHERE id_planete = ? AND id_caserne = ?');
						$nb->execute(array($colon_besoin,$planete_utilise,11));
						
						
						//SALLE DE CONTROLE ATTAQUE OUI OU NON
$ins=$bdd->prepare('INSERT INTO attaque_sdc(id_membre,attaque_oui,id_planete) VALUES (?,?,?)');
$ins->execute(array($id_membre,0,$id_P));
						
						//CASERNE: UNITE DE LA CASERNE PAR JOUEUR
$cas=$bdd->prepare('INSERT INTO caserne_joueur(nombre_unite,id_planete,id_caserne,unite_possede,unite_combat) VALUES (:nombre_unite,:id_planete,:id_caserne,:unite_possede,:unite_combat)');

$values = array(
array(0,$id_P,1,0,0),
array(0,$id_P,2,0,0),
array(0,$id_P,3,0,1),
array(0,$id_P,4,0,1),
array(0,$id_P,5,0,1),
array(0,$id_P,6,0,1),
array(0,$id_P,7,0,1),
array(0,$id_P,8,0,1),
array(0,$id_P,9,0,1),
array(0,$id_P,10,0,1),
array(0,$id_P,11,0,0),
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
						array(0,$id_P,1,0),
						array(0,$id_P,2,0),
						array(0,$id_P,3,0),
						array(0,$id_P,4,0),
						array(0,$id_P,5,0),
						array(0,$id_P,6,0),
						array(0,$id_P,7,0),
						array(0,$id_P,8,0),
						array(0,$id_P,9,0),
						array(0,$id_P,10,0),
						);
						foreach ($values as $value) {


						$def->bindValue(':nombre_unite', $value[0], PDO::PARAM_STR);
						$def->bindValue(':id_planete', $value[1], PDO::PARAM_STR);
						$def->bindValue(':id_defense', $value[2], PDO::PARAM_STR);
						$def->bindValue(':unite_possede', $value[3], PDO::PARAM_STR);

						$def->execute();
						}
						
						// selectionne un chiffre et le rajoute avant le .jpg pour definir l'image de la planète.
						$avatar = rand(1,16);
						$avatar_planete = $avatar . ".jpg";
						
					
						//GAIN DE LA PLANETE LES PLANETES DU JOUEUR
						$i=$bdd->prepare('UPDATE planete SET nom_planete = ?, planete_mere = ?, avatar_p=?, id_membre = ?, id_mine = ?, id_defense = ?, id_population = ?, id_caserne = ?, id_batiment = ?, planete_occupe = ?, pseudo_membre=? WHERE planete = ? AND coordonnee_terrestre = ?');
						$i->execute(array($nom_de_colonie,0,$avatar_planete,$id_membre,$id_P,$id_P,$id_P,$id_P,$id_P,1,$pseudo,1,$adresse)); 
					

	
						// RESSOURCES PAR PLANETE	
						$insertressource = $bdd->prepare('INSERT INTO ressource(gold,titane,cristal,orinia,orinium,energie,organique,temps,id_planete,id_membre) VALUES (?,?,?,?,?,?,?,NOW(),?,?)');
						$insertressource->execute(array(1500,1500,1400,1050,0,500,0,$id_P,$id_membre));
																																
																																
						// POPULATION PAR PLANETE																			
						$insertpopulation = $bdd->prepare('INSERT INTO population(id_planete,civil,chercheur,soldat,ouvrier,pilote,esclave,population) VALUES (?,?,?,?,?,?,?,?)');
						$insertpopulation->execute(array($id_P,0,0,0,0,0,0,$colon_besoin));
						
						//PORTE SPATIAL
						$ins=$bdd->prepare('INSERT INTO portail(id_planete,actif,exploration,interagir,porte_connecte,id_membre) VALUES (?,?,?,?,?,?)');
						$ins->execute(array($id_P,0,0,0,0,0));
						
						$temperer = "Temperé";
						$plaine_montagne = "Plaine, Montagne";
						//TERRITOIRE
						$territoire=$bdd->prepare('INSERT INTO territoire_planete(id_membre,id_planete,territoire_total,territoire_decouvert,climant,zone) VALUES (?,?,?,?,?,?)');
						$territoire->execute(array($id_membre,$id_P,7,0,utf8_encode($temperer),utf8_encode($plaine_montagne)));

						//INFRASTRUCTURE
						$infrastructure=$bdd->prepare('INSERT INTO infrastructure(id_membre,id_planete,niveau,limite, gold, titane,cristal,orinia, orinium,nom) VALUES (?,?,?,?,?,?,?,?,?,?)');
						$infrastructure->execute(array($id_membre,$id_P,1,2000,250,250,250,250,250,"Campement"));


//CHANTIER SPATIAL
$chantier_spatial=$bdd->prepare('INSERT INTO chantier_spatial(surnom_vaisseau, nom, prix_gold, prix_titane, prix_cristal, prix_orinia, prix_orinium, prix_organique, pilote, ouvrier, defense, attaque, bouclier, vitesse, poid, image, chasseur, place_chasseur, fret, type, race, vaisseau_possede, temps, gabarit, nom_objet_un, nom_objet_deux, nombre_objet_un, nombre_objet_deux, id_planete, id_joueur) 
VALUES (:surnom_vaisseau, :nom, :prix_gold, :prix_titane, :prix_cristal, :prix_orinia, :prix_orinium, :prix_organique, :pilote, :ouvrier, :defense, :attaque, :bouclier, :vitesse, :poid, :image, :chasseur, :place_chasseur, :fret, :type, :race, :vaisseau_possede, :temps, :gabarit, :nom_objet_un, :nom_objet_deux, :nombre_objet_un, :nombre_objet_deux, :id_planete, :id_joueur)');

$values = array(
array('', 'Chasseur Valharien', '2000', '300', '1500', '1000', '200', '0', 1, 1, '110', '60', '10', 120, 0, 'chval.gif', 0, 0, 0, 'Chasseur', 'valhar', 0, 1230, '1', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Chasseur Orak', '1500', '600', '100', '1200', '200', '0', 1, 1, '100', '80', '0', 100, 0, 'chorak.gif', 0, 0, 0, 'Chasseur', 'orak', 0, 1200, '1', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Chasseur Humain', '1100', '2000', '200', '200', '1500', '0', 1, 1, '80', '100', '0', 90, 0, 'chum.gif', 0, 0, 0, 'Chasseur', 'humain', 0, 1170, '1', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Chasseur Droide', '250', '150', '1300', '900', '700', '0', 1, 1, '50', '70', '0', 100, 0, 'chdro.gif', 0, 0, 0, 'Chasseur', 'droide', 0, 1200, '1', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Chasseur Ankarien', '2000', '2000', '1200', '1150', '600', '0', 1, 1, '120', '110', '20', 100, 0, 'chanka.gif', 0, 0, 0, 'Chasseur', 'ancien', 0, 1400, '1', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),

array('', 'Belsinka', '20000', '35000', '15000', '8000', '6500', '0', 2, 3, '3000', '4000', '2500', 1000, 0, 'belsinka.gif', 0, 2, 35000, 'Leger', 'valhar', 0, 2430, '2', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Vipere stellaire', '25000', '40000', '2500', '2500', '30000', '0', 2, 3, '3000', '4000', '2500', 1000, 0, 'vipere.gif', 0, 4, 35000, 'Leger', 'orak', 0, 2400, '2', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Intercepteur Y-95', '20000', '35000', '5000', '5000', '20000', '0', 2, 3, '3200', '2800', '2000', 1000, 0, 'y95.gif', 0, 6, 35000, 'Leger', 'humain', 0, 2370, '2', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'ZX-308', '20000', '35000', '15000', '8000', '6500', '0', 2, 3, '3000', '4000', '2500', 1000, 0, 'zx308.gif', 0,12, 35000, 'Leger', 'droide', 0, 2400, '2', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Croiseur B35', '20000', '35000', '15000', '8000', '6500', '0', 2, 3, '3000', '4000', '2500', 1000, 0, 'b35.gif', 0,12, 35000, 'Leger', 'ancien', 0, 3000, '2', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),

array('', 'Fregate TI', '80000', '20000', '75000', '65000', '20000', '0', 5, 15, '8500', '11000', '13000', 1000, 0, 'fregate.gif', 0, 6, 150000, 'Moyen', 'valhar', 0, 4530, '4', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Destroyer stellaire', '80000', '50000', '6000', '70000', '6000', '0', 5, 15, '8200', '11800', '9000', 1000, 0, 'destroyer.gif', 0, 9, 150000, 'Moyen', 'orak', 0, 4500, '4', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Croiseur Impérial X1', '45000', '75000', '15000', '16000', '65000', '0', 5, 15, '9400', '10600', '7000', 1000, 0, 'croiseur.gif', 0, 13, 150000, 'Moyen', 'humain', 0, 4070, '4', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Destructeur', '15000', '15000', '80000', '60000', '80000', '0', 5, 15, '8000', '12500', '13000', 1000, 0, 'destructeur.gif', 0, 18, 150000, 'Moyen', 'droide', 0, 4500, '4', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Bombardier', '55000', '70000', '55000', '72000', '72000', '0', 5, 15, '12000', '15000', '13500', 1000, 0, 'bombardier.gif', 0, 10, 150000, 'Moyen', 'ancien', 0, 4800, '4', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),

array('', 'Valkyr Mere', 115000, '5000',150000, '130000', 8000, '0', 10, '50',21000, '24500',22500, '1000', 0, 'valky.gif', 0, 10, 200000, 'Lourd', 'valhar', 0, 7400, '5', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Corhyp', 130000, '100000',26000, '115000', 25000, '0', 10, '50',21700, '24300',20000, '1000', 0, 'corhyp.gif', 0, 17, 200000, 'Lourd', 'orak', 0, 7200, '5', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Pactis B305', 120000, '130000',6000, '6000', 100000, '0', 10, '50',23000, '21000',18000, '1000', 0, 'pactis.gif', 0, 25, 200000, 'Lourd', 'humain', 0, 7000, '5', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Drone H308', 8000, '8000',140000, '130000', 110000, '0', 10, '50',20400, '25600',19000, '1000', 0, 'h308.gif', 0, 35, 200000, 'Lourd', 'droide', 0, 7200, '5', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),
array('', 'Amiral Anka', 90000, '106800',85000, '111800', 98400, '0', 10, '50',26000, '29000',27000, '1000', 0, 'amiral.gif', 0, 20, 200000, 'Lourd', 'ancien', 0, 8400, '5', 'aucun', 'aucun', '0', '0', $id_P,$id_membre),

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

//OBJET PAR JOUEUR
$objet=$bdd->prepare('INSERT INTO objet_joueur(id_objet,objet_possede,nombre_objet,id_planete,id_membre,ajout) VALUES (:id_objet,:objet_possede,:nombre_objet,:id_planete,:id_membre,:ajout)');

$values = array(
array(1,0,0,$id_P,$id_membre,0),
array(2,0,0,$id_P,$id_membre,0),
array(3,0,0,$id_P,$id_membre,0),
array(4,0,0,$id_P,$id_membre,1),
array(5,0,0,$id_P,$id_membre,1),
array(6,0,0,$id_P,$id_membre,1),
array(7,0,0,$id_P,$id_membre,0),
array(8,0,0,$id_P,$id_membre,1),
array(9,0,0,$id_P,$id_membre,1),
array(10,0,0,$id_P,$id_membre,1),
array(11,0,0,$id_P,$id_membre,1),
array(12,0,0,$id_P,$id_membre,1),
array(13,0,0,$id_P,$id_membre,1),
array(14,0,0,$id_P,$id_membre,0),
array(15,0,0,$id_P,$id_membre,1),
array(16,0,0,$id_P,$id_membre,1),
array(17,0,0,$id_P,$id_membre,1),
array(18,0,0,$id_P,$id_membre,1),
array(19,0,0,$id_P,$id_membre,1),
array(20,0,0,$id_P,$id_membre,1),
array(21,0,0,$id_P,$id_membre,1),
array(22,0,0,$id_P,$id_membre,1),
array(23,0,0,$id_P,$id_membre,1),
array(24,0,0,$id_P,$id_membre,1),
array(25,0,0,$id_P,$id_membre,1),
array(26,0,0,$id_P,$id_membre,1),
array(27,0,0,$id_P,$id_membre,1),
array(28,0,0,$id_P,$id_membre,1),
array(29,0,0,$id_P,$id_membre,1),
array(30,0,0,$id_P,$id_membre,1),
array(31,0,0,$id_P,$id_membre,1),
array(32,0,0,$id_P,$id_membre,1),
array(33,0,0,$id_P,$id_membre,1),
array(34,0,0,$id_P,$id_membre,1),
array(35,0,0,$id_P,$id_membre,1),
array(36,0,0,$id_P,$id_membre,1),
array(37,0,0,$id_P,$id_membre,1),
array(38,0,0,$id_P,$id_membre,1),
array(39,0,0,$id_P,$id_membre,1),
array(40,0,0,$id_P,$id_membre,1),
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


//EQUIPE EXPLORATION 
$eq=$bdd->prepare('INSERT INTO equipe_exploration_joueur(id_equipe,id_planete,experience,niveau,nombre,disponible,temps,unite_possede) VALUES (:id_equipe,:id_planete,:experience,:niveau,:nombre,:disponible,:temps,:unite_possede)');

$values = array(
array(1,$id_P,0,0,0,0,2312,0),
array(2,$id_P,0,0,0,0,2312,0),

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




//ETABLISSEMENTS
$etablissement=$bdd->prepare('INSERT INTO etablissement_joueur(prix_gold, prix_titane, prix_cristal, prix_orinia, prix_orinium, prix_organique, temps, construction,niveau,etab_possede,id_etab,id_planete,joueur) VALUES (:prix_gold, :prix_titane, :prix_cristal, :prix_orinia, :prix_orinium, :prix_organique, :temps, :construction, :niveau, :etab_possede, :id_etab, :id_planete, :joueur)');

$values = array(
array(125,120,105,0,0,0,260,0,0,1,1,$id_P,$id_membre),//laboratoire recherche
array(1000,1200,975,3500,0,0,1890,0,0,1,2,$id_P,$id_membre), // laboratoire defense
array(210,180,50,200,0,0,222,0,0,1,3,$id_P,$id_membre), // Caserne
array(500,250,800,150,0,0,300,0,0,1,4,$id_P,$id_membre), //centre espionnage
array(2500,2300,1650,1250,0,0,2251,0,0,1,5,$id_P,$id_membre),// hangar spatial
);

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

// MINES
$mines=$bdd->prepare('INSERT INTO mines_joueur(ouvrier,esclave,id_mine,id_planete,mine_possede) VALUES (:ouvrier, :esclave, :id_mine, :id_planete, :mine_possede)');

$values = array(
array(0,0,1,$id_P,0),
array(0,0,2,$id_P,0),
array(0,0,3,$id_P,0),
array(0,0,4,$id_P,0),
array(0,0,5,$id_P,0),
array(0,0,6,$id_P,0),
);

foreach ($values as $value) {

	$mines->bindValue(':ouvrier', $value[0], PDO::PARAM_STR);
	$mines->bindValue(':esclave', $value[1], PDO::PARAM_STR);
	$mines->bindValue(':id_mine', $value[2], PDO::PARAM_STR);
	$mines->bindValue(':id_planete', $value[3], PDO::PARAM_STR);
	$mines->bindValue(':mine_possede', $value[4], PDO::PARAM_STR);
  
  $mines->execute();
}



//Description des objets
$description_objet1 = "Cette Amulette est pourvue d'une force incroyable, seulement seul elle ne vous sert à rien, 5 d'entre elles ont été dissimulées dans l'univers, il vous en faudra 3 pour pouvoir résoudre l'énigme finale de la Cité caché.";
$description_objet2 = "Diamant dans lesquel se trouve une énergie indispensable pour débloquer l'accès à la dernière cité.Il vous faudra cumuler 3 diamants.";


//On insere egalement les objets_rare.
$insertion=$bdd->prepare('INSERT INTO objet_rare(id_objet_rare,id_membre,id_planete,nombre_objet,nom_objet,description,image) VALUES(?,?,?,?,?,?,?)');
$insertion->execute(array(1,$id_membre,$id_P,0,"Amulette D'irakhan",$description_objet1,"amulette_rare.png"));

//On insere egalement les objets_rare.
$insertion=$bdd->prepare('INSERT INTO objet_rare(id_objet_rare,id_membre,id_planete,nombre_objet,nom_objet,description,image) VALUES(?,?,?,?,?,?,?)');
$insertion->execute(array(2,$id_membre,$id_P,0,"Diamant",$description_objet2,"diamant.png"));



//On va couper le vortex
	
		$actif=$bdd->prepare('UPDATE portail SET actif = ? , interagir = ?, porte_connecte = ?, id_membre = ? WHERE id_planete = ?');
		$actif->execute(array(0,0,0,0,$planete_utilise));



					$_SESSION['error'] = '<p class="green">Colonisation r&eacute;ussi.</p>';
				}
				else
				$_SESSION['error'] = '<p class="red">Nom de planète vide.</p>';			
			}
				else
				$_SESSION['error'] = '<p class="red">Vous poss&eacute;dez plus de colonie que le niveau de technologie requi.</p>';
			}
			else
			$_SESSION['error'] = '<p class="red">Erreur il doit s\'agir d\'un nombre.</p>';
		}
		else
		$_SESSION['error'] = '<p class="red">Le nombre de colon doit &ecirc;tre sup&eacute;rieur &agrave; ' . $colon_besoin . ' .</p>';	
	}
	else
	$_SESSION['error'] = '<p class="red"> ' . $id_P . '</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un probl&egrave;me est survenu lors de l\'envoi du formulaire.</p>';

					header('Location: '.pathView().'vortex/page_portail_spatial.php');


?>
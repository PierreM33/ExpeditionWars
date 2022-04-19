<?php 
@ini_set('display_errors', 'on');
 // SCRIPT DE COMBAT //
if($_POST)
	{
		
	require_once '../../include/connexion_bdd.php';
	
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
	

// ATTAQUANT LISTE DES POST ---- TOUTE LES UNITEES
$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique,cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array($planete_utilise,3));
$trois=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique,cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array($planete_utilise,4));
$quatre=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique,cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array($planete_utilise,5));
$cinq=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique,cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array($planete_utilise,6));
$six=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique,cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array($planete_utilise,7));
$sept=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique,cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array($planete_utilise,8));
$huit=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique,cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array($planete_utilise,9));
$neuf=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique,cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array($planete_utilise,10));
$dix=$reqCas->fetch();

//----------------------------------------------//
//------------DEFENSEUR TOUTES UNITEES----------// 
//----------------------------------------------//
$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique, cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array(htmlentities($id_porte_connecte['porte_connecte']),3));
$def_trois=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique, cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array(htmlentities($id_porte_connecte['porte_connecte']),4));
$def_quatre=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique, cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array(htmlentities($id_porte_connecte['porte_connecte']),5));
$def_cinq=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique, cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array(htmlentities($id_porte_connecte['porte_connecte']),6));
$def_six=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique, cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array(htmlentities($id_porte_connecte['porte_connecte']),7));
$def_sept=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique, cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array(htmlentities($id_porte_connecte['porte_connecte']),8));
$def_huit=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique, cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array(htmlentities($id_porte_connecte['porte_connecte']),9));
$def_neuf=$reqCas->fetch();

$reqCas=$bdd->prepare('SELECT cas.id, cas.nom_unite, cas.attaque, cas.defense, cas.attaque_mecanique, cas.defense_mecanique, cas.pv, cj.nombre_unite, cj.id_caserne, cj.id_planete, cj.unite_possede FROM caserne AS cas LEFT JOIN caserne_joueur AS cj ON cas.id=cj.id_caserne WHERE cj.id_planete = ? AND cj.id_caserne = ? ');
$reqCas->execute(array(htmlentities($id_porte_connecte['porte_connecte']),10));
$def_dix=$reqCas->fetch();

//RESSOURCES DEFENSEUR
$ressource=$bdd->prepare('SELECT * FROM ressource WHERE id_membre = ? AND id_planete = ?');
$ressource->execute(array(htmlentities($cible['id_membre']),htmlentities($id_porte_connecte['porte_connecte'])));
$ress=$ressource->fetch();

// POPULATION DEFENSEUR
$population=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?');
$population->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
$pop=$population->fetch();


// RACE DES JOUEURS
//ATTAQUANT
$r_a=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$r_a->execute(array($id_membre));
$ra=$r_a->fetch();
//DEFENSEUR
$r_d=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$r_d->execute(array(htmlentities($cible['id_membre'])));
$rd=$r_d->fetch();

$race_att=$ra['race']; //race attaquant
$race_def=$rd['race']; //race_defenseur
$droide="droide";



if($_POST['trois'] == 0)
{
	$_POST['trois'] = 0;
	
}

if($_POST['quatre'] == 0)
{
	$_POST['quatre'] = 0;
	
}

if($_POST['cinq'] == 0)
{
	$_POST['cinq'] = 0;
	
}

if($_POST['six'] == 0)
{
	$_POST['six'] = 0;
	
}

if($_POST['sept'] == 0)
{
	$_POST['sept'] = 0;
	
}

if($_POST['huit'] == 0)
{
	$_POST['huit'] = 0;
	
}

if($_POST['neuf'] == 0)
{
	$_POST['neuf'] = 0;
	
}

if($_POST['dix'] == 0)
{
	$_POST['dix'] = 0;
	
}
//------------ATTAQUANT ------------//
	// POST 3
	$total_attaque_trois=$trois['attaque']*$_POST['trois'];
	$total_defense_trois=$trois['defense']*$_POST['trois'];
	$total_pv_trois=$trois['pv']*$_POST['trois'];
	$total_attaque_trois_AM=$trois['attaque_mecanique']*$_POST['trois'];
	$total_defense_trois_DM=$trois['defense_mecanique']*$_POST['trois'];
	
	//POST 4
	$total_attaque_quatre=$quatre['attaque']*$_POST['quatre'];
	$total_defense_quatre=$quatre['defense']*$_POST['quatre'];
	$total_pv_quatre=$quatre['pv']*$_POST['quatre'];
	$total_attaque_quatre_AM=$quatre['attaque_mecanique']*$_POST['quatre'];
	$total_defense_quatre_DM=$quatre['defense_mecanique']*$_POST['quatre'];
	
	//POST 5
	$total_attaque_cinq=$cinq['attaque']*$_POST['cinq'];
	$total_defense_cinq=$cinq['defense']*$_POST['cinq'];
	$total_pv_cinq=$cinq['pv']*$_POST['cinq'];
	$total_attaque_cinq_AM=$cinq['attaque_mecanique']*$_POST['cinq'];
	$total_defense_cinq_DM=$cinq['defense_mecanique']*$_POST['cinq'];
	
	//POST 6
	$total_attaque_six=$six['attaque']*$_POST['six'];
	$total_defense_six=$six['defense']*$_POST['six'];
	$total_pv_six=$six['pv']*$_POST['six'];
	$total_attaque_six_AM=$six['attaque_mecanique']*$_POST['six'];
	$total_defense_six_DM=$six['defense_mecanique']*$_POST['six'];
	
	//POST 7
	$total_attaque_sept=$sept['attaque']*$_POST['sept'];
	$total_defense_sept=$sept['defense']*$_POST['sept'];
	$total_pv_sept=$sept['pv']*$_POST['sept'];
	$total_attaque_sept_AM=$sept['attaque_mecanique']*$_POST['sept'];
	$total_defense_sept_DM=$sept['defense_mecanique']*$_POST['sept'];
	
		//POST 8
	$total_attaque_huit=$huit['attaque']*$_POST['huit'];
	$total_defense_huit=$huit['defense']*$_POST['huit'];
	$total_pv_huit=$huit['pv']*$_POST['huit'];
	$total_attaque_huit_AM=$huit['attaque_mecanique']*$_POST['huit'];
	$total_defense_huit_DM=$huit['defense_mecanique']*$_POST['huit'];
	
		//POST 9
	$total_attaque_neuf=$neuf['attaque']*$_POST['neuf'];
	$total_defense_neuf=$neuf['defense']*$_POST['neuf'];
	$total_pv_neuf=$neuf['pv']*$_POST['neuf'];
	$total_attaque_neuf_AM=$neuf['attaque_mecanique']*$_POST['neuf'];
	$total_defense_neuf_DM=$neuf['defense_mecanique']*$_POST['neuf'];
	
		//POST 10
	$total_attaque_dix=$dix['attaque']*$_POST['dix'];
	$total_defense_dix=$dix['defense']*$_POST['dix'];
	$total_pv_dix=$dix['pv']*$_POST['dix'];
	$total_attaque_dix_AM=$dix['attaque_mecanique']*$_POST['dix'];
	$total_defense_dix_DM=$dix['defense_mecanique']*$_POST['dix'];
	
	
	// TOTAL DE TOUS
	$total_puissance_combat_attaquant = $total_attaque_trois + $total_attaque_quatre + $total_attaque_cinq + $total_attaque_six + $total_attaque_sept + $total_attaque_huit + $total_attaque_neuf + $total_attaque_dix;
	$total_defense_combat_attaquant = $total_defense_trois + $total_defense_quatre + $total_defense_cinq + $total_defense_six + $total_defense_sept + $total_defense_huit + $total_defense_neuf + $total_defense_dix;
	$total_pv_attaquant = $total_pv_trois + $total_pv_quatre + $total_pv_cinq + $total_pv_six + $total_pv_sept + $total_pv_huit + $total_pv_neuf + $total_pv_dix;
	
	// TOTAL DES ATTAQUES ET DEFENSE DROIDE
	$total_puissance_combat_attanquant_mecanique = $total_attaque_trois_AM + $total_attaque_quatre_AM + $total_attaque_cinq_AM + $total_attaque_six_AM + $total_attaque_sept_AM + $total_attaque_huit_AM + $total_attaque_neuf_AM + $total_attaque_dix_AM;
	$total_defense_combat_attaquant_mecanique = $total_defense_trois_DM + $total_defense_quatre_DM + $total_defense_cinq_DM + $total_defense_six_DM + $total_defense_sept_DM + $total_defense_huit_DM + $total_defense_neuf_DM + $total_defense_dix_DM;
	
	// COMPTER LE NOMBRE DE TROUPE ENVOYER
	$tr=strip_tags($_POST['trois']);
	$qu=strip_tags($_POST['quatre']);
	$ci=strip_tags($_POST['cinq']);
	$si=strip_tags($_POST['six']);
	$se=strip_tags($_POST['sept']);
	$hu=strip_tags($_POST['huit']);
	$ne=strip_tags($_POST['neuf']);
	$di=strip_tags($_POST['dix']);
	
	$nombre_total_unite_attaquant = $tr + $qu + $ci + $si + $se + $hu + $ne + $di;
	
	
// --------------------------------------------//		
// ----------------DEFENSEUR ------------------//		
// -------------------------------------------//	

	// DEFENSEUR "TROIS"
	$total_attaque_def_trois=$def_trois['attaque']*$def_trois['nombre_unite'];
	$total_defense_def_trois=$def_trois['defense']*$def_trois['nombre_unite'];
	$total_pv_def_trois=$def_trois['pv']*$def_trois['nombre_unite'];
	$total_attaque_def_trois_AM=$def_trois['attaque_mecanique']*$def_trois['nombre_unite'];
	$total_defense_def_trois_DM=$def_trois['defense_mecanique']*$def_trois['nombre_unite'];
	
	// DEFENSEUR "QUATRE"
	$total_attaque_def_quatre=$def_quatre['attaque']*$def_quatre['nombre_unite'];
	$total_defense_def_quatre=$def_quatre['defense']*$def_quatre['nombre_unite'];
	$total_pv_def_quatre=$def_quatre['pv']*$def_quatre['nombre_unite'];
	$total_attaque_def_quatre_AM=$def_quatre['attaque_mecanique']*$def_quatre['nombre_unite'];
	$total_defense_def_quatre_DM=$def_quatre['defense_mecanique']*$def_quatre['nombre_unite'];
	
	// DEFENSEUR "cinq"
	$total_attaque_def_cinq=$def_cinq['attaque']*$def_cinq['nombre_unite'];
	$total_defense_def_cinq=$def_cinq['defense']*$def_cinq['nombre_unite'];
	$total_pv_def_cinq=$def_cinq['pv']*$def_cinq['nombre_unite'];
	$total_attaque_def_cinq_AM=$def_cinq['attaque_mecanique']*$def_cinq['nombre_unite'];
	$total_defense_def_cinq_DM=$def_cinq['defense_mecanique']*$def_cinq['nombre_unite'];
	
		// DEFENSEUR "six"
	$total_attaque_def_six=$def_six['attaque']*$def_six['nombre_unite'];
	$total_defense_def_six=$def_six['defense']*$def_six['nombre_unite'];
	$total_pv_def_six=$def_six['pv']*$def_six['nombre_unite'];
	$total_attaque_def_six_AM=$def_six['attaque_mecanique']*$def_six['nombre_unite'];
	$total_defense_def_six_DM=$def_six['defense_mecanique']*$def_six['nombre_unite'];
	
		// DEFENSEUR "sept"
	$total_attaque_def_sept=$def_sept['attaque']*$def_sept['nombre_unite'];
	$total_defense_def_sept=$def_sept['defense']*$def_sept['nombre_unite'];
	$total_pv_def_sept=$def_sept['pv']*$def_sept['nombre_unite'];
	$total_attaque_def_sept_AM=$def_sept['attaque_mecanique']*$def_sept['nombre_unite'];
	$total_defense_def_sept_DM=$def_sept['defense_mecanique']*$def_sept['nombre_unite'];
	
		// DEFENSEUR "huit"
	$total_attaque_def_huit=$def_huit['attaque']*$def_huit['nombre_unite'];
	$total_defense_def_huit=$def_huit['defense']*$def_huit['nombre_unite'];
	$total_pv_def_huit=$def_huit['pv']*$def_huit['nombre_unite'];
	$total_attaque_def_huit_AM=$def_huit['attaque_mecanique']*$def_huit['nombre_unite'];
	$total_defense_def_huit_DM=$def_huit['defense_mecanique']*$def_huit['nombre_unite'];
	
		// DEFENSEUR "neuf"
	$total_attaque_def_neuf=$def_neuf['attaque']*$def_neuf['nombre_unite'];
	$total_defense_def_neuf=$def_neuf['defense']*$def_neuf['nombre_unite'];
	$total_pv_def_neuf=$def_neuf['pv']*$def_neuf['nombre_unite'];
	$total_attaque_def_neuf_AM=$def_neuf['attaque_mecanique']*$def_neuf['nombre_unite'];
	$total_defense_def_neuf_DM=$def_neuf['defense_mecanique']*$def_neuf['nombre_unite'];
	
		// DEFENSEUR "dix"
	$total_attaque_def_dix=$def_dix['attaque']*$def_dix['nombre_unite'];
	$total_defense_def_dix=$def_dix['defense']*$def_dix['nombre_unite'];
	$total_pv_def_dix=$def_dix['pv']*$def_dix['nombre_unite'];
	$total_attaque_def_dix_AM=$def_dix['attaque_mecanique']*$def_dix['nombre_unite'];
	$total_defense_def_dix_DM=$def_dix['defense_mecanique']*$def_dix['nombre_unite'];
	
	
	//TOTAL DEFENSEUR:
	$dt=htmlentities($def_trois['nombre_unite']); 
	$dq=htmlentities($def_quatre['nombre_unite']);
	$dc=htmlentities($def_cinq['nombre_unite']); 
	$ds=htmlentities($def_six['nombre_unite']); 
	$dse=htmlentities($def_sept['nombre_unite']); 
	$dh=htmlentities($def_huit['nombre_unite']);
	$dn=htmlentities($def_neuf['nombre_unite']); 
	$dd=htmlentities($def_dix['nombre_unite']);

	

	
	//TOTAL DE TOUS
	$total_puissance_combat_defenseur = $total_attaque_def_trois + $total_attaque_def_quatre + $total_attaque_def_cinq + $total_attaque_def_six + $total_attaque_def_sept + $total_attaque_def_huit + $total_attaque_def_neuf + $total_attaque_def_dix;
	$total_defense_combat_defenseur = $total_defense_def_trois + $total_defense_def_quatre + $total_defense_def_cinq + $total_defense_def_six + $total_defense_def_sept + $total_defense_def_huit + $total_defense_def_neuf + $total_defense_def_dix;
	$total_pv_defenseur = $total_pv_def_trois + $total_pv_def_quatre + $total_pv_def_cinq + $total_pv_def_six + $total_pv_def_sept + $total_pv_def_huit + $total_pv_def_neuf + $total_pv_def_dix;
	// TOTAL DES ATTAQUES ET DEFENSE DROIDE DU DEFENSEUR
	$total_puissance_combat_defenseur_mecanique = $total_attaque_def_trois_AM + $total_attaque_def_quatre_AM + $total_attaque_def_cinq_AM + $total_attaque_def_six_AM + $total_attaque_def_sept_AM + $total_attaque_def_huit_AM + $total_attaque_def_neuf_AM + $total_attaque_def_dix_AM;
	$total_defense_combat_defenseur_mecanique =  $total_defense_def_trois_DM + $total_defense_def_quatre_DM + $total_defense_def_cinq_DM + $total_defense_def_six_DM + $total_defense_def_sept_DM + $total_defense_def_huit_DM + $total_defense_def_neuf_DM + $total_defense_def_dix_DM;

	$nombre_total_unite_defenseur = ($def_trois['nombre_unite']) + ($def_quatre['nombre_unite']) + ($def_cinq['nombre_unite']) + ($def_six['nombre_unite']) + ($def_sept['nombre_unite']) + ($def_huit['nombre_unite']) + ($def_neuf['nombre_unite']) + ($def_dix['nombre_unite']);
	
//	-------------------------------//
// VERIFICATION DES POST //
//	-------------------------------//	


	//-----ATTAQUANT----//
	// PERMET DE SAVOIR SI LES POST SONT UTILISE
	if($_POST['trois'] > 0){$trois=1;}else{$trois=0;} // PERMET DE SAVOIR SI ON UTILISE LE POST 3
	if($_POST['quatre'] > 0){$quatre=1;}else{$quatre=0;} // PERMET DE SAVOIR SI ON UTILISE LE POST 4
	if($_POST['cinq'] > 0){$cinq=1;}else{$cinq=0;} // PERMET DE SAVOIR SI ON UTILISE LE POST 5
	if($_POST['six'] > 0){$six=1;}else{$six=0;} // PERMET DE SAVOIR SI ON UTILISE LE POST 6
	if($_POST['sept'] > 0){$sept=1;}else{$sept=0;} // PERMET DE SAVOIR SI ON UTILISE LE POST 7
	if($_POST['huit'] > 0){$huit=1;}else{$huit=0;} // PERMET DE SAVOIR SI ON UTILISE LE POST 8
	if($_POST['neuf'] > 0){$neuf=1;}else{$neuf=0;} // PERMET DE SAVOIR SI ON UTILISE LE POST 9
	if($_POST['dix'] > 0){$dix=1;}else{$dix=0;} // PERMET DE SAVOIR SI ON UTILISE LE POST 10
	
	$separation_attaquant= $trois + $quatre + $cinq + $six + $sept + $huit + $neuf + $dix; // ADDITIONNE LES POST UTILISE
	
	//----DEFENSEUR-----//
	if($def_trois['nombre_unite'] > 0){$def_trois=1;}else{$def_trois=0;} // PERMET DE SAVOIR SI ON UTILISE LA REQUETE "D"
	if($def_quatre['nombre_unite'] > 0){$def_quatre=1;}else{$def_quatre=0;}
	if($def_cinq['nombre_unite'] > 0){$def_cinq=1;}else{$def_cinq=0;}
	if($def_six['nombre_unite'] > 0){$def_six=1;}else{$def_six=0;}
	if($def_sept['nombre_unite'] > 0){$def_sept=1;}else{$def_sept=0;}
	if($def_huit['nombre_unite'] > 0){$def_huit=1;}else{$def_huit=0;}
	if($def_neuf['nombre_unite'] > 0){$def_neuf=1;}else{$def_neuf=0;}
	if($def_dix['nombre_unite'] > 0){$def_dix=1;}else{$def_dix=0;}
	
	$separation_defenseur = $def_trois + $def_quatre + $def_cinq + $def_six + $def_sept + $def_huit + $def_neuf + $def_dix; // PERMET DE SAVOIR COMBIEN DE CATEGORIE DE TROUPES EST UTILISE POUR DEFENDRE
	
	if($separation_defenseur <= 0)
	{
		$separation_defenseur = 1;
	}
 
		

	if(!empty($_POST['id_cache_trois']) OR !empty($_POST['id_cache_quatre']) OR !empty($_POST['id_cache_cinq']) OR !empty($_POST['id_cache_six']) OR !empty($_POST['id_cache_sept']) OR !empty($_POST['id_cache_huit']) OR !empty($_POST['id_cache_neuf']) OR !empty($_POST['id_cache_dix'])) 
	{ 	 		
			if(is_numeric($_POST['id_cache_trois']) || is_numeric($_POST['id_cache_quatre']) || is_numeric($_POST['id_cache_cinq']) || is_numeric($_POST['id_cache_six']) || is_numeric($_POST['id_cache_sept']) || is_numeric($_POST['id_cache_huit']) || is_numeric($_POST['id_cache_neuf']) || is_numeric($_POST['id_cache_dix'])) 
			{ 	 
				if($nombre_total_unite_attaquant > 0)
				{
					
													$date = time()+86400;
								//Ajoute une attaque au joueur
								$up_att=$bdd->prepare('INSERT INTO nombre_attaque(id_membre,id_membre_vise,temps,nombre_attaque,pseudo,pseudo_vise) VALUES(?,?,?,?,? ,?)');
								$up_att->execute(array($id_membre,htmlentities($cible['id_membre']),$date,1,$ra['pseudo'],$rd['pseudo']));
								
								//Si la race de l'attaquant et du defenseur est different de droide
							if($race_att != $droide AND $race_def != $droide)
								{
									

								
								$r_tot_attaquant = $total_puissance_combat_attaquant-$total_defense_combat_defenseur; // CALCUL DE L'ATTAQUE TOTALE DE L ATTAQUANT RESTANT APRES DIFFERENCE ENTRE ATTAQUE ET DEFENSE DU DEFENSEUR.
								$r_tot_defense = $total_puissance_combat_defenseur -$total_defense_combat_attaquant;// PAREIL MAIS POUR LA DEFENSE

								if($r_tot_attaquant >= 0) // SI LE RESULTAT DE L ATTAQUANT EST UNE VALEUR POSITIVE
								{
								
									$pv_restant_d=$total_pv_defenseur-$r_tot_attaquant; // CALCUL PV RESTANT DU DEFENSEUR			
									$reste_defenseur=$pv_restant_d/100; // POUR RETROUVER LE NOMBRE DE TROUPES DU DEFENSEUR ON DIVISE PAR 100 (voir modifier par ses PV mais resultats pas top)
									/*echo "</br> Nombre d'unité de l'attaquant : " . ceil($nombre_total_unite_attaquant) . "</br>";
									echo " -- Troupes restant au défenseur : " . ceil($reste_defenseur) . "</br>";*/
									
									// inversion pour connaitre le nombre exacte de perte du defenseur.
									$resultat_perte_defenseur = $nombre_total_unite_defenseur - $reste_defenseur;
								
									if($resultat_perte_defenseur > $nombre_total_unite_defenseur) // SI la perte est plus importante que le nombre totale de troupe envoyé.
										{
										$resultat_perte_defenseur = $nombre_total_unite_defenseur;
										}

									
									$repartition_de_perte_du_defenseur = $resultat_perte_defenseur / $separation_defenseur;

									// echo " -- Répartition de la perte du défenseur : " . ceil($repartition_de_perte_du_defenseur) . "</br>";				
									
									$global_perte_attaquant=$total_puissance_combat_defenseur/1.5; // PERTE QUI ENGLOBE TOUTE LES UNITEES --- ON UTILISE LE DIVISER PAR "1.5" CAR LE DEFENSEUR NE FAIT PAS L'INTEGRALITE DES DEGATS PUISQU'IL PERD.
									$perte_attaquant=$global_perte_attaquant/100; // POUR RETROUVER LE NOMBRE DE TROUPES PERDU PAR L ATTAQUANT ON DIVISE PAR SES PV
									
									// echo " -- Perte attaquant total : " . ceil($perte_attaquant) . " /-/ Perte par catégorie : " . ceil($perte_distinct) . "</br>";
									$perte_distinct=$perte_attaquant/$separation_attaquant; // ON DIVISE ICI LE RESULTAT PAR LE NOMBRE DE POST ENVOYER POUR REPARTIR LES PERTES
								
									//-----------------------------------------------------------------------------///
									//--------------------VICTOIRE DE L'ATTAQUANT GAIN ----------------------------///
									//-----------------------------------------------------------------------------///
									
									
									// ON VA AJOUTER UN SCRIPT PERMETTANT DE PRENDRE UN POURCENTAGE PLUS IMPORTANT EN FONCTION DU NOMBRE DE TROUPES ENVOYER PAR L'ATTAQUANT
									$difference_entre_armer = $nombre_total_unite_attaquant - $nombre_total_unite_defenseur;
							
									
									$nouveau_coef = 5;
									
									if($difference_entre_armer >= 100 AND $difference_entre_armer <= 499)
									{
										$nouveau_coef = 20;
									}
									elseif($difference_entre_armer >= 500)
									{
										
										$nouveau_coef = 50;
										
									}
								
									//RESSOURCES DU DEFENSEUR CALCUL DE PERTE
									$perte_population=(10*$pop['population'])/100;
									$perte_gold=($nouveau_coef*$ress['gold'])/100;
									$perte_titane=($nouveau_coef*$ress['titane'])/100;
									$perte_cristal=($nouveau_coef*$ress['cristal'])/100;
									$perte_orinia=($nouveau_coef*$ress['orinia'])/100;
									$perte_orinium=($nouveau_coef*$ress['orinium'])/100;


									// PERTE DES RESSOURCES DU JOUEUR ATTAQUE
									$perte=$bdd->prepare('UPDATE ressource SET gold=gold-?, titane=titane-?, cristal=cristal-?, orinia=orinia-?, orinium=orinium-?  WHERE id_planete = ? AND id_membre = ?');
									$perte->execute(array(ceil($perte_gold),ceil($perte_titane),ceil($perte_cristal),ceil($perte_orinia),ceil($perte_orinium),htmlentities($id_porte_connecte['porte_connecte']),htmlentities($cible['id_membre'])));
									
									if($perte_population < 1)
									{
										$perte_population = 0;
									}
									

									//PERTE DE LA POPULATION
									$perte_population_defenseur=$bdd->prepare('UPDATE population SET population = population - ? WHERE id_planete = ?');
									$perte_population_defenseur->execute(array(ceil($perte_population),$id_porte_connecte['porte_connecte']));
									
									// VOL DE RESSOURCE GRACE A LA VICTOIRE
									$vol=$bdd->prepare('UPDATE ressource SET gold=gold+?, titane=titane+?, cristal=cristal+?, orinia=orinia+?, orinium=orinium+?  WHERE id_planete = ? AND id_membre = ?');
									$vol->execute(array(ceil($perte_gold),ceil($perte_titane),ceil($perte_cristal),ceil($perte_orinia),ceil($perte_orinium),$planete_utilise,$id_membre));
									
									//VOL DE POPULATION EN ESCLAVE
									$vol_popu=$bdd->prepare('UPDATE population SET esclave=esclave+? WHERE id_planete = ?');
									$vol_popu->execute(array(ceil($perte_population),$planete_utilise));
									
									//Si victoire de l'attaquant, on peut voler un objet rare.
									$REQ=$bdd->prepare('SELECT * FROM objet_rare WHERE id_planete = ? AND id_membre = ?');
									$REQ->execute(array($id_porte_connecte['porte_connecte'],$cible['id_membre']));
									$REQU=$REQ->fetch();

									$nombre_objet = $REQU['nombre_objet'];
									

									//On ajoute la condition
									if($nombre_objet > 0)
									{

									//On retire l'objet d'un coté puis on l'ajoute de l'autre
									$retrait=$bdd->prepare('UPDATE objet_rare SET nombre_objet=nombre_objet+? WHERE id_membre = ? AND id_planete = ?');
									$retrait->execute(array($nombre_objet,$id_membre,$planete_utilise));

									$ajout=$bdd->prepare('UPDATE objet_rare SET nombre_objet=nombre_objet-? WHERE id_membre = ? AND id_planete = ?');
									$ajout->execute(array($nombre_objet,$cible['id_membre'],$id_porte_connecte['porte_connecte']));
									
									require_once "message_vol_objet_rare.php";
									}
									
									require_once "point_guerre.php";
						
									if(ceil($perte_attaquant) > 1)//
									{
										// METTRE PLUSIEURS UPDATE DE RETRAIT DE TROUPES
										
											if($trois != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_trois'])));
											
											}
											if($quatre != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_quatre'])));
											
											}
											if($cinq != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_cinq'])));
											
											}
											if($six != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_six'])));
											
											}
											if($sept != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_sept'])));
											
											}
											if($huit != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_huit'])));
											
											}
											if($neuf != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_neuf'])));
											
											}
											if($dix != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_dix'])));
											
											}
											// RETRAIT DES TROUPES AU DEFENSEUR:
											require_once "perte_defenseur_attaquant_gagnant.php";
											require_once "insert_combat_victoire_attaquant_bdd.php";
											require_once "message_attaquant_gagnant.php";
											$_SESSION['error'] = '<p class="green"> Consulter votre messagerie pour obtenir le rapport de combat.</p>';

										
									}
									else// RETIRER SUR UNE SEULE UNITE
									{
										//PERTE ATTAQUANT /--/ NE METTRE QU'UN SEUL CHAMPS EN DELETE CAR PERTE D'UNE SEULE UNITE.
										// ON VERIFIE LES POST QUI SONT ENVOYE, L'UNITE PERDU SERA CELLE DU PREMIER CHAMPS
										
										$retrait_valide = 0;// permet de verifier si on passe au post suivant

											if($trois != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_trois'])));
											
											$retrait_valide = 1;
											}
											if($quatre != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_quatre'])));
											
											$retrait_valide == 1;
											}
											if($cinq != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_cinq'])));
											
											$retrait_valide == 1;
											}
											if($six != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_six'])));
											
											$retrait_valide == 1;
											}
											if($sept != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_sept'])));
											
											$retrait_valide == 1;
											}
											if($huit != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_huit'])));
											
											$retrait_valide == 1;
											}
											if($neuf != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_neuf'])));
											
											$retrait_valide == 1;
											}
											if($dix != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),$planete_utilise,strip_tags($_POST['id_cache_dix'])));
											
											$retrait_valide == 1;
											}
											// RETRAIT DES TROUPES AU DEFENSEUR:
											require_once "perte_defenseur_attaquant_gagnant.php";
											require_once "insert_combat_victoire_attaquant_bdd.php";
											require_once "message_attaquant_gagnant.php";
											$_SESSION['error'] = '<p class="green"> Consulter votre messagerie pour obtenir le rapport de combat.</p>';
											
									}
						
								}
								else // SI RESULTAT ATTAQUANT NEGATIF ON PASSE ICI
								//-------------------------------------------------------------------------------------------------//
								//-----------------------------// VICTOIRE DU DEFENSEUR //--------------------------------------//
								//------------------------------------------------------------------------------------//
								//--------------------------------------------------------------------------------------------//
								{
								$pv_restant_a=$total_pv_attaquant-$r_tot_defense; // CALCUL PV RESTANT ATTAQUANT
								$reste_attaquant=$pv_restant_a/100; // POUR RETROUVER LE NOMBRE DE TROUPES DE ATTAQUANT ON DIVISE PAR SES PV GLOBAL

								
								// inversion pour connaitre le nombre exacte de perte du defenseur.
								$resultat_perte_attaquant = $nombre_total_unite_attaquant - $reste_attaquant;
													
								if($resultat_perte_attaquant > $nombre_total_unite_attaquant) // SI la perte est plus importante que le nombre totale de troupe envoyé.
									{
									$resultat_perte_attaquant = $nombre_total_unite_attaquant;
									}
								
								$repartition_de_perte_de_attaquant = $resultat_perte_attaquant / $separation_attaquant;
								
								//echo " -- Répartition de la perte de l'attaquant : " . ceil($repartition_de_perte_de_attaquant) . "</br>";
								
								$global_perte_defenseur=$total_puissance_combat_attaquant/1.5; // PERTE QUI ENGLOBE TOUTE LES UNITEES
								$perte_defenseur=$global_perte_defenseur/100; // POUR RETROUVER LE NOMBRE DE TROUPES PERDU PAR DEFENSEUR ON DIVISE PAR SES PV
								$perte_distinct=$perte_defenseur/$separation_defenseur;// a modifier le zero // ON DIVISE ICI LE RESULTAT PAR LE NOMBRE DE POST ENVOYER POUR REPARTIR LES PERTES
								//echo " -- Perte defenseur : " . ceil($perte_defenseur) . " /-/ Perte par catégorie : " . ceil($perte_distinct) . "</br>";
								//echo " </br> Le défenseur gagne le combat .";
								
				
								
									if(ceil($perte_defenseur) > 1)// SI LA PERTE EST INFERIEUR AU NOMBRE DE POST RETIRER SEULEMENT SUR LE PREMIER POST
									{
														
										if($def_trois != 0 )
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),3));
											
											}
											
											if($def_quatre != 0 )
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),4));
											
											}
											
											if($def_cinq != 0 )
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),5));
											
											}
											
											if($def_six != 0 )
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),6));
											
											}
											
											if($def_sept != 0 )
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),7));
											
											}
											
											if($def_huit != 0 )
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),8));
											
											}
											
											if($def_neuf != 0 )
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),9));
											
											}
											
											if($def_dix != 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),10));
											
											}
											// RETRAIT DES TROUPES AU DEFENSEUR:
											require_once "perte_attaquant_defenseur_gagnant.php";
											require_once "insert_combat_victoire_defenseur_bdd.php";
											require_once "message_defenseur_gagnant.php";
											$_SESSION['error'] = '<p class="green"> Consulter votre messagerie pour obtenir le rapport de combat.</p>';
											
											
									}
									else // RETRAIT 1 CATEGORIE
									{
										
									$retrait_valide = 0;// permet de verifier si on passe au post suivant
										if($def_trois != 0 )
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),3));
											
											$retrait_valide == 1;
											}
											
											if($def_quatre != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),4));
											
											$retrait_valide == 1;
											}
											
											if($def_cinq != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),5));
											
											$retrait_valide == 1;
											}
											
											if($def_six != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),6));
											
											$retrait_valide == 1;
											}
											
											if($def_sept != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),7));
											
											$retrait_valide == 1;
											}
											
											if($def_huit != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),8));
											
											$retrait_valide == 1;
											}
											
											if($def_neuf != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),9));
											
											$retrait_valide == 1;
											}
											
											if($def_dix != 0 AND $retrait_valide = 0)
											{
											$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
											$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),10));
											
											$retrait_valide == 1;
											}
											// RETRAIT DES TROUPES AU DEFENSEUR:
											require_once "perte_attaquant_defenseur_gagnant.php";
											require_once "insert_combat_victoire_defenseur_bdd.php";
											require_once "message_defenseur_gagnant.php";
											
											$_SESSION['error'] = '<p class="green"> Consulter votre messagerie pour obtenir le rapport de combat.</p>';
									}
						
								}	
						}
						//-----------------------------------------------------------------------------------------------------------//
						//-----------------------------------------------------------------------------------------------------------//
						//-----------------------------------------------------------------------------------------------------------//
						//-----------------------------------------------------------------------------------------------------------//
						//-------------------------------------------PASSAGE EN COMBAT DROIDE------------------------------------//
						//-------------------------------------------------------------------------------------------------------------//
						//-----------------------------------------------------------------------------------------------------------//
						//-----------------------------------------------------------------------------------------------------------//
						//-----------------------------------------------------------------------------------------------------------//
						
						else
						{
							//echo " Combat avec les valeurs de droide si un des deux membres et de cette race.</br>";
							// CALCUL DE L'ATTAQUE TOTALE DE L ATTAQUANT RESTANT APRES DIFFERENCE ENTRE ATTAQUE ET DEFENSE DU DEFENSEUR.
							$resultat_tot_attaquant_M = $total_puissance_combat_attanquant_mecanique-$total_defense_combat_defenseur_mecanique;

							// PAREIL MAIS POUR LA DEFENSE
							$resultat_tot_defense_M = $total_puissance_combat_defenseur_mecanique - $total_defense_combat_attaquant_mecanique; 
							

							if($resultat_tot_attaquant_M >= $resultat_tot_defense_M) // SI LE RESULTAT DE L ATTAQUANT EST UNE VALEUR POSITIVE
							{
									require_once "droide_attaquant_gagne.php";

							}
							else	// VICTOIRE DU DEFENSEUR //
							{
							
							require_once "droide_defenseur_gagne.php";
				

							}
						}
				}
				else
					$_SESSION['error'] = '<p class="red">Vous devez envoyé au minimum un soldat pour combattre.</p>';
		}
		else
			$_SESSION['error'] = '<p class="red">Vous devez et ne pouvez mettre qu\'un chifre ou un nombre.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';	
}
else
$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'vortex/page_vortex.php');
?>


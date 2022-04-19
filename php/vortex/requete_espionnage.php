<?php


	// LECTURE TROUPES ENNEMIS :1
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),1));
	$trp_un=$troupe->fetch();
	
		// LECTURE TROUPES ENNEMIS :2
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),2));
	$trp_deux=$troupe->fetch();
	
		// LECTURE TROUPES ENNEMIS :3
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),3));
	$trp_trois=$troupe->fetch();
	
		// LECTURE TROUPES ENNEMIS :4
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),4));
	$trp_quatre=$troupe->fetch();
	
		// LECTURE TROUPES ENNEMIS :5
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),5));
	$trp_cinq=$troupe->fetch();
	
		// LECTURE TROUPES ENNEMIS :6
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),6));
	$trp_six=$troupe->fetch();
	
		// LECTURE TROUPES ENNEMIS :7
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),7));
	$trp_sept=$troupe->fetch();
	
			// LECTURE TROUPES ENNEMIS :7
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),8));
	$trp_huit=$troupe->fetch();
	
			// LECTURE TROUPES ENNEMIS :7
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),9));
	$trp_neuf=$troupe->fetch();
	
			// LECTURE TROUPES ENNEMIS :7
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),10));
	$trp_dix=$troupe->fetch();
	
			// LECTURE TROUPES ENNEMIS :7
	$troupe=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$troupe->execute(array(htmlentities($id_porte_connecte['porte_connecte']),11));
	$trp_onze=$troupe->fetch();
	

	$total_trp = $trp_un['nombre_unite'] + $trp_deux['nombre_unite'] + $trp_trois['nombre_unite'] + $trp_quatre['nombre_unite'] + $trp_cinq['nombre_unite'] + $trp_six['nombre_unite'] + $trp_sept['nombre_unite'] + $trp_huit['nombre_unite'] + $trp_neuf['nombre_unite'] + $trp_dix['nombre_unite'] + $trp_onze['nombre_unite'];








?>
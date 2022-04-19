<?php
@ini_set('display_errors', 'on');


/// VIRUS === TECHNOLOGIE 54
if($_POST['envoi_virus'])
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
$ve->execute(array(htmlentities(htmlspecialchars($id_porte_connecte['porte_connecte']))));
$cible=$ve->fetch();

// POPULATION GLOBAL DE L'ADVERSAIRE
$pop=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?');
$pop->execute(array(htmlentities(htmlspecialchars($id_porte_connecte['porte_connecte']))));
$population_ennemi=$pop->fetch();

$mine1=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?');
$mine1->execute(array($id_porte_connecte['porte_connecte'],1));
$MINEG=$mine1->fetch();

$mine2=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?');
$mine2->execute(array($id_porte_connecte['porte_connecte'],2));
$MINET=$mine2->fetch();

$mine3=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?');
$mine3->execute(array($id_porte_connecte['porte_connecte'],3));
$MINEC=$mine3->fetch();

$mine4=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?');
$mine4->execute(array($id_porte_connecte['porte_connecte'],4));
$MINEORI=$mine4->fetch();

$mine5=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?');
$mine5->execute(array($id_porte_connecte['porte_connecte'],5));
$MINEORIN=$mine5->fetch();

/// VIRUS === TECHNOLOGIE 54
$tech54=$bdd->prepare('SELECT * FROM technologie_joueur WHERE id_membre = ?');
$tech54->execute(array($id_membre));
$Virus54=$tech54->fetch();
	
		//On verifie le nombre de virus
		//Requete pour verifier si on a le virus
		$req_virus=$bdd->prepare('SELECT * FROM objet_joueur WHERE id_membre = ? AND id_planete = ? AND id_objet = ?');
		$req_virus->execute(array($id_membre,$planete_utilise,7));
		$virus=$req_virus->fetch();
		
		if(htmlentities(htmlspecialchars($virus['nombre_objet'] >= 1)))
		{
			
			//On va update le nombre de virus du joueur
			$req_virus=$bdd->prepare('UPDATE objet_joueur SET nombre_objet= nombre_objet - ? WHERE id_membre = ? AND id_planete = ? AND id_objet = ?');
			$req_virus->execute(array(1,$id_membre,$planete_utilise,7));
			
			//Perte se fera en fonction du niveau du virus dans la technologie + un % aleatoire
			$aleatoire = $Virus54['niveau'];
			$population_morte = ($aleatoire/100) * htmlentities(htmlspecialchars($population_ennemi['population']));
			
			
			$ROG = ($aleatoire/100)*$MINEG['ouvrier'];
			$REG = ($aleatoire/100)*$MINEG['esclave'];
			
			$ROT = ($aleatoire/100)*$MINET['ouvrier'];
			$RET = ($aleatoire/100)*$MINET['esclave'];
			
			$ROC = ($aleatoire/100)*$MINEC['ouvrier'];
			$REC = ($aleatoire/100)*$MINEC['esclave'];
			
			$ROORI = ($aleatoire/100)*$MINEORI['ouvrier'];
			$REORI = ($aleatoire/100)*$MINEORI['esclave'];
			
			$ROORIN = ($aleatoire/100)*$MINEORIN['ouvrier'];
			$REORIN = ($aleatoire/100)*$MINEORIN['esclave'];
			
			

			//Retrait dans mine
			
			//Mine Or
			$MO=$bdd->prepare('UPDATE mines_joueur SET ouvrier = ouvrier-?, esclave = esclave-? WHERE id_planete = ? AND id_mine = ?');
			$MO->execute(array($ROG,$REG,$id_porte_connecte['porte_connecte'],1));

			
			//Mine titane
			$MT=$bdd->prepare('UPDATE mines_joueur SET ouvrier = ouvrier-?, esclave = esclave-? WHERE id_planete = ? AND id_mine = ?');
			$MT->execute(array($ROT,$RET,$id_porte_connecte['porte_connecte'],2));
			
						
			//Mine cristal
			$MC=$bdd->prepare('UPDATE mines_joueur SET ouvrier = ouvrier-?, esclave = esclave-? WHERE id_planete = ? AND id_mine = ?');
			$MC->execute(array($ROC,$REC,$id_porte_connecte['porte_connecte'],3));
			
			//Mine ORINIA
			$MOA=$bdd->prepare('UPDATE mines_joueur SET ouvrier = ouvrier-?, esclave = esclave-? WHERE id_planete = ? AND id_mine = ?');
			$MOA->execute(array($ROORI,$REORI,$id_porte_connecte['porte_connecte'],4));
			
						
			//Mine Orinium
			$MRO=$bdd->prepare('UPDATE mines_joueur SET ouvrier = ouvrier-?, esclave = esclave-? WHERE id_planete = ? AND id_mine = ?');
			$MRO->execute(array($ROORIN,$REORIN,$id_porte_connecte['porte_connecte'],5));
			
			
			//Retrait de la population ennemis
			$p=$bdd->prepare('UPDATE population SET population = population-? WHERE id_planete = ?');
			$p->execute(array(ceil($population_morte),htmlentities(htmlspecialchars($id_porte_connecte['porte_connecte']))));
			
						$total_perte = $ROG + $REG + $ROT + $RET + $ROC + $REC + $ROORI + $REORI + $ROORIN + $REORIN + ceil($population_morte);
			
			//MEssage au defenseur
			require_once "message_envoi_virus_defenseur.php";
			require_once "message_envoi_virus_attaquant.php";
			
			$_SESSION['error'] = '<p class="green"> Le virus &agrave; bien franchi le vortex et nous estimons les pertes ennemis &agrave; ' . ceil($total_perte ) . ' membres de leurs population en comptant les individus dans les mines . </p>';
			
		}
		else
		$_SESSION['error'] = '<p class="red">Erreur aucun virus.</p>';
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoi du formulaire.</p>';

	header('Location: '.pathView().'vortex/page_vortex.php');
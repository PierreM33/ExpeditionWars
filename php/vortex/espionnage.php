<?php 

	
if($_POST['espionnage'])
	{
		
		
require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);
	

	
	// OBTENIR LA LISTE DES UNITES ESPION DE LA PLANETE SELECTIONNE DU JOUEUR QUI ENVOIE
	$nb_esp=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$nb_esp->execute(array($planete_utilise,1));
	$e=$nb_esp->fetch();
	
	// OBTENIR LE NIVEAU DE L'ESPIONNAGE DU JOUEUR QUI ENVOIE
	$lvl_esp=$bdd->prepare('SELECT * FROM technologie_joueur WHERE id_membre = ? AND id_technologie = ?');
	$lvl_esp->execute(array($id_membre,1));
	$t=$lvl_esp->fetch();
	
	
	// RECUPERER L'ID DE LA PORTE CONNECTE
	$v=$bdd->prepare('SELECT * FROM portail WHERE id_membre = ?');
	$v->execute(array($id_membre));
	$id_porte_connecte=$v->fetch();

	// PERMET DE RECUPERER L'ID DE LA PORTE VISE
	$ve=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$ve->execute(array($id_porte_connecte['porte_connecte']));
	$cible=$ve->fetch();
	
	// ADVERSAIRE RECUPERATION DE SON ID JOUEUR
	$lvl_espi=$bdd->prepare('SELECT * FROM technologie_joueur WHERE id_membre = ? AND id_technologie = ?');
	$lvl_espi->execute(array(htmlentities($cible['id_membre']),1));
	$ta=$lvl_espi->fetch();
	
	// LECTURE DES RESSOURCES DE L'ENNEMI 
	$lecture=$bdd->prepare('SELECT * FROM ressource WHERE id_planete = ?');
	$lecture->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
	$l=$lecture->fetch();
	
	// LECTURE DU PSEUDO DU MEMBRE ENNEMI 
	$mb=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$mb->execute(array(htmlentities($cible['id_membre'])));
	$m=$mb->fetch();
	
	// LECTURE DU PSEUDO DU MEMBRE
	$mb=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$mb->execute(array($id_membre));
	$membre=$mb->fetch();
	
	// LECTURE DES BATIMENTS 
	$eta=$bdd->prepare('SELECT * FROM etablissement_joueur WHERE id_planete = ? AND id_etab = ?');
	$eta->execute(array($planete_utilise,4));
	$etab_A=$eta->fetch();
	
	//LECTURE DES BATIMENTS DU JOUEUR VISE
	$eta=$bdd->prepare('SELECT * FROM etablissement_joueur WHERE id_planete = ? AND id_etab=?');
	$eta->execute(array(htmlentities($id_porte_connecte['porte_connecte']),4));
	$etab_B=$eta->fetch();
	
	//CALCUL DE LA DIFFERENCE DE NIVEAU ENTRE LES JOUEURS
	//BATIMENTS
	//ID ETAB 4
		$niveau_batiment_ecart = $etab_A['niveau'] - $etab_B['niveau'];
		$nv_valeur=htmlentities($t['niveau'])- htmlentities($ta['niveau']);
	
		$ad_valeur = $niveau_batiment_ecart + $nv_valeur;
		
	require_once"requete_espionnage.php";

		$porte_connecte = htmlentities($id_porte_connecte['porte_connecte']);
		$id_membre_cible = htmlentities($cible['id_membre']);
		
		// vaisseau
		$flotte=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_planete = ? AND id_membre = ?');
		$flotte->execute(array(htmlentities($id_porte_connecte['porte_connecte']),htmlentities($cible['id_membre'])));
		$vaiss=$flotte->RowCount();
		
		
		
				// defense
		$d=$bdd->prepare('SELECT * FROM defense_joueur WHERE id_planete = ?');
		$d->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
		while($def=$d->fetch())
		{
		$defe+=$def['nombre_unite'];
		}
		//Permet la mise a jours des ressources de l'adversaire espionné
		require_once "maj_ress.php";
			
		if($e['nombre_unite'] >= 1)
			{
				// Retire 1 espion au joueur qui l'envoie.
				$up=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-? WHERE id_planete = ? AND id_caserne = ?');
				$up->execute(array(1,$planete_utilise,1));
				
				require_once "message_a_la_cible.php";

				
				if($ad_valeur >= 2 AND $ad_valeur <= 3) // Si le niveau d'espionnage du J-A est supérieur au J-B( ID 1 = technologie espionnage toujours)
				{
				require_once "espionnage_v2.php";
										
				}
				elseif($ad_valeur >= 4 AND $ad_valeur <= 5) // Si l'espionnage est supérieur à 4 niveau entre les deux joueurs.
				{
				require_once "espionnage_v4.php";
				}
				elseif($ad_valeur >= 6) // Si l'espionnage est supérieur à 6 niveau entre les deux joueurs.
				{
				require_once "espionnage_v6.php";	
				
				}
				else
				{
				require_once "erreur_espion.php";
				}	
				
		
			}
			else
			$_SESSION['error'] = '<p class="red">Vous n\'avez pas d\'espion à envoyer.</p>';
	}
	else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';	

header('Location: '.pathView().'vortex/envoyer_espion.php');


?>
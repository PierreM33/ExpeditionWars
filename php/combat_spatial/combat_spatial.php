<?php

@ini_set('display_errors', 'on');
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);
	
	//LECTURE URL
	$URL=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$URL->execute(array($id_membre));
	$Url=$URL->fetch();
	
	$url = $Url['url'];
//Rajouter le temps si cela ne marche passthru
//Liste des vaisseau en cours pour le combats
$table=$bdd->prepare('SELECT * FROM vaisseau_action WHERE nom_action = ?');
$table->execute(array(1));
while($liste_vaisseau=$table->fetch())
{

if(time() >= $liste_vaisseau['temps'])
{

	$id_membre_attaquant = htmlentities($liste_vaisseau['id_membre']);
	$id_planete_attaquant = htmlentities($liste_vaisseau['id_planete']);
	$id_planete_defenseur = htmlentities($liste_vaisseau['planete_vise']);
	$id_membre_defenseur = htmlentities($liste_vaisseau['id_membre_vise']);
	$id_action = $liste_vaisseau['id'];
	$stockage_valeur_deplacement = htmlentities($liste_vaisseau['stockage_valeur_deplacement']);

//ON RECUPERE LA STABILITE DE L'ATTAQUANT
$STA=$bdd->prepare('SELECT * FROM stable WHERE id_membre = ?');
$STA->execute(array($id_membre_attaquant));
$STABI=$STA->fetch();

$Stabilite = $STABI['stabilite'];

	//PERMET DE VERIFIER SI C'EST LA PLANETE MERE
	$Pm=$bdd->prepare('SELECT * FROM planete WHERE id = ?');
	$Pm->execute(array($id_planete_defenseur));
	$PlaneteM=$Pm->fetch();
	
	$PlaneteMere = $PlaneteM['planete_mere'];
	$PlaneteOccupe = $PlaneteM['planete_occupe'];

	// L'ATTAQUANT
	$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$req_m->execute(array($id_membre_attaquant));
	$m=$req_m->fetch();

	//DEFENSEUR
	$req_m=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$req_m->execute(array($id_membre_defenseur));
	$mbr=$req_m->fetch();

	$pseudo_attaquant = htmlentities($m['pseudo']);
	$pseudo_defenseur = htmlentities($mbr['pseudo']);

	require_once 'composition_attaquant.php';
	require_once 'composition_defenseur.php';
	require_once 'composition_defense_defenseur.php';

	/*
	htmlentities($ennemi['id'])
	Numero de la planete pas celui de l'id du joueur)
	*/

	////////////// RECUPERATION DU NOMBRE DE TOUR ATTAQUANT /////////////
	$nt=$bdd->prepare('SELECT * FROM nombre_tour WHERE id_membre = ? ');
	$nt->execute(array($id_membre_attaquant));
	$tu=$nt->fetch();
			
	////////////// RECUPERATION DU NOMBRE DE TOUR PAR JOUEUR /////////////
	$ntd=$bdd->prepare('SELECT * FROM nombre_tour WHERE id_membre = ? ');
	$ntd->execute(array($id_membre_defenseur));
	$td=$ntd->fetch();
			
	////////////// CALCUL LE NOMBRE DE VAISSEAU ENNEMIS RESTANT SUR LA PLANETE DEFENSEUR/////////////
	$calcul=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_planete = ? AND id_action = ?');
	$calcul->execute(array($id_planete_defenseur,0));
	$nombre_unite=$calcul->rowCount();
		
	////////////// CALCUL LE NOMBRE DE VAISSEAU RESTANT DE L'ATTAQUANT /////////////
	$cal=$bdd->prepare('SELECT a.id, a.id_membre, b.* FROM vaisseau_action AS a 
						LEFT JOIN vaisseau_joueur AS b ON (b.id_action = a.id)
						WHERE a.id_membre=? AND b.id_planete=? AND b.id_action = ?');
	$cal->execute(array($id_membre_attaquant,$id_planete_attaquant,$liste_vaisseau['id']));
	$nombre_unite_attaquant=$cal->rowCount();
			
	// SI UN JOUR UN BUG C'est ICI avec le stockage du numéro de combat, car je ne le stock pas dans la BDD actuellement.
	$numero_combat_spatial = uniqid();  
			
	//PLACE ICI CAR SAVE DU NUMERO DE COMBAT
	require_once 'composition_fixe_depart.php';
				
	$tour = 1;
	$addition = ($tu['nombre_tour'] + $td['nombre_tour']);
				
	$tour_final = round($addition / 2);
						
	////////////// RECUPERATION DE LA SORTIE DES CHASSEURS ATTAQUANT /////////////
	$sortie_a=$bdd->prepare('SELECT * FROM strategie WHERE id_membre = ? ');
	$sortie_a->execute(array($id_membre_attaquant));
	$ch_att=$sortie_a->fetch();
			
	////////////// RECUPERATION DE LA SORTIE DES CHASSEURS DEFENSEUR /////////////
	$sortie_d=$bdd->prepare('SELECT * FROM strategie WHERE id_membre = ? ');
	$sortie_d->execute(array($id_membre_defenseur));
	$ch_def=$sortie_d->fetch();

	$sortie_chasseur_attaquant = $ch_att['sortie_chasseur']; 
	$sortie_chasseur_defenseur = $ch_def['sortie_chasseur'];
	
	
	///STRATEGIE DU VOL DE COLONIE ///
	$STR=$bdd->prepare('SELECT * FROM strategie WHERE id_membre = ? ');
	$STR->execute(array($id_membre_attaquant));
	$Strategie=$STR->fetch();
	
	$ColonisationOui = $Strategie['coloniser_actif'];

		
	while($tour<=$tour_final)
	  {
		//$_GET['tour'] = $tour;

		//CALCUL DU COMBAT
		include 'calcul_cbt.php';
						
		//SAUVEGARDE LE COMBAT

		include 'save_cb_bdd_defenseur.php';
		include 'save_cb_bdd_defense_defenseur.php';
		include 'save_cb_bdd_attaquant.php';					
						
		$_GET['numero'] = $numero_combat_spatial;
						
						
		//Tour max disponible
		$tmax=$bdd->prepare('SELECT * FROM sauvegarde_composition_par_tour ORDER BY tour DESC');
		$tmax->execute(array());
		$t_mx=$tmax->fetch();

		//compte le nombre de vaisseau en attaque
		$req=$bdd->prepare('SELECT * FROM sauvegarde_composition_par_tour WHERE categorie = ? AND numero_combat = ? AND tour = ?');
		$req->execute(array("attaquant",$numero_combat_spatial,$t_mx['tour']));
		$nbr_att_max=$req->rowCount();

		//compte le nombre de vaisseaux en defense
		$req=$bdd->prepare('SELECT * FROM sauvegarde_composition_par_tour WHERE categorie = ? AND numero_combat = ? AND tour = ?');
		$req->execute(array("defenseur",$numero_combat_spatial,$t_mx['tour']));
		$nbr_def_max=$req->rowCount();
						
		//compte le nombre de défense au sol
		$req=$bdd->prepare('SELECT * FROM sauvegarde_composition_par_tour WHERE categorie = ? AND numero_combat = ? AND tour = ?');
		$req->execute(array("defense_planete",$numero_combat_spatial,$t_mx['tour']));
		$nbr_def_au_sol_max=$req->rowCount();
						
		//compte le nombre de vaisseau en attaque a chaque tour
		$req=$bdd->prepare('SELECT * FROM sauvegarde_composition_par_tour WHERE categorie = ? AND numero_combat = ? AND tour = ?');
		$req->execute(array("attaquant",$numero_combat_spatial,$tour));
		$nbr_att=$req->rowCount();

		//compte le nombre de vaisseaux en defense a chaque tour
		$req=$bdd->prepare('SELECT * FROM sauvegarde_composition_par_tour WHERE categorie = ? AND numero_combat = ? AND tour = ?');
		$req->execute(array("defenseur",$numero_combat_spatial,$tour));
		$nbr_def=$req->rowCount();
						
		//compte le nombre de defense au sol en defense a chaque tour
		$req=$bdd->prepare('SELECT * FROM sauvegarde_composition_par_tour WHERE categorie = ? AND numero_combat = ? AND tour = ?');
		$req->execute(array("defense_planete",$numero_combat_spatial,$tour));
		$nbr_def_au_sol=$req->rowCount();
						
		//SCRIPT RETIRER LES CHASSEURS NE VOULAIENT PAS S'INTEGRER AU COMBAT
		//AJOUTE ICI LA PARTIE OU LES CHASSEURS VONT SORTIR VOIR LES PAGES CONCERNE
		// if($tour >= $sortie_chasseur_defenseur)
		// {
		// require_once "sortie_chasseur_planete.php";
		// }

		if($tour >= $sortie_chasseur_attaquant)
		{
		require_once "sortie_chasseur.php";
		}
					

		//Definir la variable $fin
		$fin = 0;
					
		//Si le nombre d'une des deux équipe a zéro troupe alors fin du combat
		if($nbr_def == 0 AND $nbr_def_au_sol == 0 ) // Nombre d'unité du defenseur
		{
			if ($nbr_def_max == 0)
			{
				include 'envoi_message.php';
				include 'vol_ressources.php';
				include 'victoire_attaquant.php';
				//SI COLONISATION = 1
				//DEFENSE AU SOL ET VAISSEAU = 0
				//QUE LA PLANETE SOIT OCCUPE ET QUE CE SOIT PAS LA PLANETE MERE
				if($ColonisationOui == 1 AND $nbr_def_au_sol == 0 AND $nbr_def == 0 AND $PlaneteMere == 0 AND $PlaneteOccupe == 1 AND $Stabilite == 100)
				{
				include 'vol_colonie.php';
				}
				include 'deplacement_vaisseau.php';
			//	echo '<script>document.location.href="' .pathView(). 'flotte/vaisseaux_en_deplacement.php"</script>';
				
				$tour = $tour_final;					
				$fin = 1;
								
				//Si le combat est fini alors on deplace les vaisseaux.
				if($fin == 1)
				{
					include 'deplacement_vaisseau.php';
				}
			}
		}
		
		if($nbr_att == 0) // Nombre_unite attaquant
		{							
			if ($nbr_att_max == 0)
			{
				include 'envoi_message.php';
				include 'victoire_defenseur.php';
			//	echo '<script>document.location.href="' .pathView(). 'flotte/vaisseaux_en_deplacement.php"</script>';
												
				$tour = $tour_final;
				$fin = 1;
				
				//Si le combat est fini alors on deplace les vaisseaux.
				if($fin == 1)
				{
					include 'deplacement_vaisseau.php';
				}
			}
		}
		if($tour == $tour_final)
		{
			if( $fin == 0)
			{
				include 'envoi_message.php';
				include 'aucune_victoire.php';
				include 'deplacement_vaisseau.php';
				//echo '<script>document.location.href="' .pathView(). 'flotte/vaisseaux_en_deplacement.php"</script>';
																
				$fin = 2;
									
				//Si le combat est fini alors on deplace les vaisseaux.
				if($fin == 2)
				{
					include 'deplacement_vaisseau.php';
				}
			}
							
		}
		$tour++;
	}		  
}	


	
	
/////FERMETURE ACCOLADE PARTIE TEMPS
}
// echo '<script>document.location.href="' .pathView(). 'flotte/vaisseaux_en_deplacement.php"</script>';
 header('Location: ' . $url . ' ');  
?>


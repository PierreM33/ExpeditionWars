<?php
//ATTAQUANT DROIDE QUI GAGNE
							

				$pv_restant_defenseur_DM=$total_pv_defenseur-$resultat_tot_attaquant_M; // CALCUL PV RESTANT DU DEFENSEUR
				$reste_defenseur=$pv_restant_defenseur_DM/100; // POUR RETROUVER LE NOMBRE DE TROUPES DU DEFENSEUR ON DIVISE PAR SES PV

				$resultat_perte_defenseur_DM = $nombre_total_unite_defenseur - $reste_defenseur;
									
				if($resultat_perte_defenseur_DM > $nombre_total_unite_defenseur) // SI la perte est plus importante que le nombre totale de troupe envoyé.
					{
					$resultat_perte_defenseur_DM = $nombre_total_unite_defenseur;
					}
				$repartition_de_perte_du_defenseur = $resultat_perte_defenseur_DM / $separation_defenseur;


				$global_perte_attaquant_M=$total_puissance_combat_defenseur_mecanique/1.5; // PERTE QUI ENGLOBE TOUTE LES UNITEES
				$perte_attaquant=$global_perte_attaquant_M/100; // POUR RETROUVER LE NOMBRE DE TROUPES PERDU PAR L ATTAQUANT ON DIVISE PAR SES PV
				

				//LIMITE LE NOMBRE DE MORT AUX NOMBRE MAX DE NOS TROUPES
				if($perte_attaquant > $nombre_total_unite_attaquant)
					{
						$perte_attaquant = $nombre_total_unite_attaquant;
					}
				
				$perte_distinct=$perte_attaquant/$separation_attaquant; // ON DIVISE ICI LE RESULTAT PAR LE NOMBRE DE POST ENVOYER POUR REPARTIR LES PERTES
				
				
				//-----------------------------------------------------------------------------///
				//--------------------VICTOIRE DE L'ATTAQUANT GAIN ----------------------------///
				//-----------------------------------------------------------------------------///


				//RESSOURCES DU DEFENSEUR CALCUL DE PERTE
				$perte_population=(10*$pop['population'])/1000;
				$perte_gold=(10*$ress['gold'])/1000;
				$perte_titane=(10*$ress['titane'])/1000;
				$perte_cristal=(10*$ress['cristal'])/1000;
				$perte_orinia=(10*$ress['orinia'])/1000;
				$perte_orinium=(10*$ress['orinium'])/1000;
				
		

				// PERTE DES RESSOURCES DU JOUEUR ATTAQUE
				$perte=$bdd->prepare('UPDATE ressource SET gold=gold-?, titane=titane-?, cristal=cristal-?, orinia=orinia-?, orinium=orinium-?  WHERE id_planete = ? AND id_membre = ?');
				$perte->execute(array(ceil($perte_gold),ceil($perte_titane),ceil($perte_cristal),ceil($perte_orinia),ceil($perte_orinium),htmlentities($id_porte_connecte['porte_connecte']),htmlentities($cible['id_membre'])));
				//PERTE DE LA POPULATION
				$vol_popu=$bdd->prepare('UPDATE population SET population=population-? WHERE id_planete = ?');
				$vol_popu->execute(array(ceil($perte_population),htmlentities($id_porte_connecte['porte_connecte'])));

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
					//RETRAIT A L'ATTAQUANT DES TROUPES
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
						require_once "droide_perte_defenseur_attaquant_gagnant.php";
						require_once "insert_combat_victoire_attaquant_droide_bdd.php";
						require_once "message_droide_attaquant_gagnant.php";
						$_SESSION['error'] = '<p class="green"> Consulter votre messagerie pour obtenir le rapport de combat.</p>';
						
					
				}
				else// RETIRER SUR UNE SEULE UNITE
				{
					
					//SI LES PERTES DE l'ATTAQUANT SONT INFERIEUR A 1 on met 1 pour le ne pas mettre zéro
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

						require_once "droide_perte_defenseur_attaquant_gagnant.php"; // Perte du defenseur pour les combat droide si l'attaquant gagne
						require_once "insert_combat_victoire_attaquant_droide_bdd.php"; // insert le combat dans la bdd pour le sauvegarder
						require_once "message_droide_attaquant_gagnant.php"; // Envoie le message
						$_SESSION['error'] = '<p class="green"> Consulter votre messagerie pour obtenir le rapport de combat.</p>';
					
					}

			
			

?>
<?php
// DEFENSEUR DROIDE QUI GAGNE

@ini_set('display_errors', 'on');

			$pv_restant_attaquant_AM=$total_pv_attaquant-$resultat_tot_defense_M; // CALCUL PV RESTANT ATTAQUANT
			$reste_attaquant=$pv_restant_attaquant_AM/100; // POUR RETROUVER LE NOMBRE DE TROUPES DE ATTAQUANT ON DIVISE PAR SES PV GLOBAL

			//Remarque : Variable non définie : resultat_perte_attaquant_AM dans /home/expedition-wars/www/php/combat/droide_perte_attaquant_defenseur_gagnant.php à la ligne 8

			$resultat_perte_attaquant_M = $nombre_total_unite_attaquant - $reste_attaquant;
													
			if($resultat_perte_attaquant_M > $nombre_total_unite_attaquant) // SI la perte est plus importante que le nombre totale de troupe envoyé.
				{
				$resultat_perte_attaquant_M = $nombre_total_unite_attaquant;
				}

			$repartition_de_perte_de_attaquant = $resultat_perte_attaquant_M / $separation_attaquant;
			
			
			$global_perte_defenseur=$total_puissance_combat_attanquant_mecanique/1.5; // PERTE QUI ENGLOBE TOUTE LES UNITEES
			$perte_defenseur=$global_perte_defenseur/100; // POUR RETROUVER LE NOMBRE DE TROUPES PERDU PAR DEFENSEUR ON DIVISE PAR SES PV
			$perte_distinct=$perte_defenseur/$separation_defenseur;// a modifier le zero // ON DIVISE ICI LE RESULTAT PAR LE NOMBRE DE POST ENVOYER POUR REPARTIR LES PERTES


			

			if($perte_defenseur > 1)// SI LA PERTE EST INFERIEUR AU NOMBRE DE POST RETIRER SEULEMENT SUR LE PREMIER POST
					{
								
//TROIS							
						if($def_trois != 0 )
							{
								
								$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],3));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($perte_distinct > $nombre_troupe_en_def)
								{
								$perte_distinct = $nombre_troupe_en_def;
								}
									
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),3));
							
							}
							
							//QUATRE
							if($def_quatre != 0 )
							{
								
								$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],4));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($perte_distinct > $nombre_troupe_en_def)
								{
								$perte_distinct = $nombre_troupe_en_def;
								}
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),4));
							
							}
							
							//CINQ
							if($def_cinq != 0 )
							{
								
							$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],5));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),5));
							
							}
							
							//SIX
							if($def_six != 0 )
							{
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],6));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),6));
							
							}
							
							//SEPT
							if($def_sept != 0 )
							{
								
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],7));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),7));
							
							}
							
							//HUIT
							if($def_huit != 0 )
							{
								
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],8));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),8));
							
							}
							
							
							//NEUF
							if($def_neuf != 0 )
							{
								
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],9));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),9));
							
							}
							
							//DIX
							if($def_dix != 0)
							{
								
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],10));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),10));
							
							}
							// RETRAIT DES TROUPES AU DEFENSEUR:
							require_once "droide_perte_attaquant_defenseur_gagnant.php";
							require_once "insert_combat_victoire_defenseur_droide_bdd.php";
							require_once "message_droide_defenseur_gagnant.php";
							$_SESSION['error'] = '<p class="green"> Consulter votre messagerie pour obtenir le rapport de combat.</p>';
							
							
					}
					else // RETRAIT 1 CATEGORIE
					{
						
					$retrait_valide = 0;// permet de verifier si on passe au post suivant
					
					//TROIS
						if($def_trois != 0 )
							{
									$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],3));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),3));
							
							$retrait_valide == 1;
							}
							
							//QUATRE
							if($def_quatre != 0 AND $retrait_valide = 0)
							{
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],4));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),4));
							
							$retrait_valide == 1;
							}
							
							//CINQ
							if($def_cinq != 0 AND $retrait_valide = 0)
							{
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],5));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),5));
							
							$retrait_valide == 1;
							}
							
							//SIX
							if($def_six != 0 AND $retrait_valide = 0)
							{
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],6));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),6));
							
							$retrait_valide == 1;
							}
							
							//SEPT
							if($def_sept != 0 AND $retrait_valide = 0)
							{
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],7));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
						
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),7));
							
							$retrait_valide == 1;
							}
							
							//HUIT
							if($def_huit != 0 AND $retrait_valide = 0)
							{
								
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],8));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),8));
							
							$retrait_valide == 1;
							}
							
							
							//NEUF
							if($def_neuf != 0 AND $retrait_valide = 0)
							{
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],9));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),9));
							
							$retrait_valide == 1;
							}
							
							//DIX
							if($def_dix != 0 AND $retrait_valide = 0)
							{
															$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
							$comptage->execute(array($id_porte_connecte['porte_connecte'],10));
							$COMPTA=$comptage->fetch();

							$nombre_troupe_en_def = $COMPTA['nombre_unite'];

							if($perte_distinct > $nombre_troupe_en_def)
							{
							$perte_distinct = $nombre_troupe_en_def;
							}
							$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
							$suppr->execute(array(ceil($perte_distinct),htmlentities($id_porte_connecte['porte_connecte']),10));
							
							$retrait_valide == 1;
							}
							// RETRAIT DES TROUPES AU DEFENSEUR:
							require_once "droide_perte_attaquant_defenseur_gagnant.php";
							require_once "insert_combat_victoire_defenseur_droide_bdd.php";
							require_once "message_droide_defenseur_gagnant.php";
							
							$_SESSION['error'] = '<p class="green"> Consulter votre messagerie pour obtenir le rapport de combat.</p>';
	


					}
				


?>
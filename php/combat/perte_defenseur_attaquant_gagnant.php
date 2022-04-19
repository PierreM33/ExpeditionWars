<?php
//-----------------------------------------------------------------------------------///
//---------------------------------------------------------------------------------///
////------------ATTAQUANT GAGNANT ET PERTE DU DEFENSEUR ------------------------------//
//-----------------------------------------------------------------------------------///
//---------------------------------------------------------------------------------///

			if(ceil($resultat_perte_defenseur) > 1)// SI LA PERTE EST INFERIEUR AU NOMBRE DE POST RETIRER SEULEMENT SUR LE PREMIER POST
						{
													
							if($def_trois != 0 )
								{
									
								$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],3));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),3));
								
								}
								
								if($def_quatre != 0 )
								{
								
								$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],4));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),4));
								
								}
								
								if($def_cinq != 0 )
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],5));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),5));
								
								}
								
								if($def_six != 0 )
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],6));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),6));
								
								}
								
								if($def_sept != 0 )
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],7));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),7));
								
								}
								
								if($def_huit != 0 )
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],8));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),8));
								
								}
								
								if($def_neuf != 0 )
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],9));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),9));
								
								}
								
								if($def_dix != 0)
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],10));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),10));
								
								}
								
						}
						else // RETRAIT 1 CATEGORIE
						{
							// echo "Inferieur a 1 : Retrait d'une unitée.";
							
							//TROIS
						$retrait_valide = 0;// permet de verifier si on passe au post suivant
							if($def_trois != 0 )
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],3));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),3));
								
								$retrait_valide == 1;
								}
								
								//QUATRE
								if($def_quatre != 0 AND $retrait_valide = 0)
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],4));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),4));
								
								$retrait_valide == 1;
								}
								
								//CINQ
								if($def_cinq != 0 AND $retrait_valide = 0)
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],5));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),5));
								
								$retrait_valide == 1;
								}
								
								//SIX
								if($def_six != 0 AND $retrait_valide = 0)
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],6));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),6));
								
								$retrait_valide == 1;
								}
								
								//SEPT
								if($def_sept != 0 AND $retrait_valide = 0)
								{
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],7));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),7));
								
								$retrait_valide == 1;
								}
								
								//HUIT
								if($def_huit != 0 AND $retrait_valide = 0)
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],8));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),8));
								
								$retrait_valide == 1;
								}
								
								
								//NEUF
								if($def_neuf != 0 AND $retrait_valide = 0)
								{
									
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],9));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),9));
								
								$retrait_valide == 1;
								}
								
								//DIX
								if($def_dix != 0 AND $retrait_valide = 0)
								{
																	$comptage=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
								$comptage->execute(array($id_porte_connecte['porte_connecte'],10));
								$COMPTA=$comptage->fetch();

								$nombre_troupe_en_def = $COMPTA['nombre_unite'];

								if($repartition_de_perte_du_defenseur > $nombre_troupe_en_def)
								{
								$repartition_de_perte_du_defenseur = $nombre_troupe_en_def;
								}

								
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_du_defenseur),htmlentities($id_porte_connecte['porte_connecte']),10));
								
								$retrait_valide == 1;
								}
						}

						?>
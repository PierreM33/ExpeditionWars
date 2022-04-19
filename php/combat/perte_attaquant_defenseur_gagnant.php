<?php
//-----------------------------------------------------------------------------------///
//---------------------------------------------------------------------------------///
////------------DEFENSEUR GAGNANT ET PERTE DE L'ATTAQUANT ------------------------------//
//-----------------------------------------------------------------------------------///
//---------------------------------------------------------------------------------///

			if(ceil($resultat_perte_attaquant) > 1)// SI LA PERTE EST INFERIEUR AU NOMBRE DE POST RETIRER SEULEMENT SUR LE PREMIER POST
						{
							// METTRE PLUSIEURS UPDATE DE RETRAIT DE TROUPES
							
								if($trois != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_trois'])));
								
								}
								if($quatre != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_quatre'])));
								}
								if($cinq != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_cinq'])));
								}
								if($six != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_six'])));
								
								}
								if($sept != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_sept'])));
								
								}
								if($huit != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_huit'])));
								
								}
								if($neuf != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_neuf'])));
								
								}
								if($dix != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_dix'])));
								
								}

							
						}
						else// RETIRER SUR UNE SEULE UNITE
						{
							//PERTE ATTAQUANT /--/ NE METTRE QU'UN SEUL CHAMPS EN DELETE CAR PERTE D'UNE SEULE UNITE.
							// ON VERIFIE LES POST QUI SONT ENVOYE, L'UNITE PERDU SERA CELLE DU PREMIER CHAMPS
							
							$retrait_valide = 0;// permet de verifier si on passe au post suivant

								if($trois != 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_trois'])));
								
								$retrait_valide = 1;
								}
								if($quatre != 0 AND $retrait_valide = 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_quatre'])));
								
								$retrait_valide == 1;
								}
								if($cinq != 0 AND $retrait_valide = 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_cinq'])));
								
								$retrait_valide == 1;
								}
								if($six != 0 AND $retrait_valide = 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_six'])));
								
								$retrait_valide == 1;
								}
								if($sept != 0 AND $retrait_valide = 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_sept'])));
								
								$retrait_valide == 1;
								}
								if($huit != 0 AND $retrait_valide = 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_huit'])));
								
								$retrait_valide == 1;
								}
								if($neuf != 0 AND $retrait_valide = 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_neuf'])));
								
								$retrait_valide == 1;
								}
								if($dix != 0 AND $retrait_valide = 0)
								{
								$suppr=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-?  WHERE id_planete = ? AND id_caserne = ?');
								$suppr->execute(array(ceil($repartition_de_perte_de_attaquant),$planete_utilise,strip_tags($_POST['id_cache_dix'])));
								
								$retrait_valide == 1;
								}
						}
						?>
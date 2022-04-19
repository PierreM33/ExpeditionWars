<?php
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);

//////////////-----------------------------------------/////////////////////

///////CALCUL DU COMBAT DES VAISSEAUX ATTAQUANT


//JE RAJOUTE UN IF CAR SI TOTAL_A est egal a zero la division ne peut pas s'effectuer
if($total_a == 0)
{
	$total_a = 1;
}//Je l'ai rajouté car il me disait un bug de division par zér, que je n'avais pas sur le serveur de stef par exemple.

// DIVISION DES DEGATS ET PERTES
$ATTAQUE_DIVISER = $ATTAQUE_DEFENSEUR / $total_a; // Total est le nombre de vaisseaux total de l'attaquant

						
if($ATTAQUE_DIVISER >= 0)
	{
		

		$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ?');
		$select->execute(array($id_membre_attaquant,$id_action));
		while($r=$select->fetch())
		{
			
			$r_n = htmlentities($r['nom_vaisseau']);
			$r_a = htmlentities($r['attaque']);
			$r_b = htmlentities($r['bouclier']);
			$r_c = htmlentities($r['defense']);
			$id_VR = htmlentities($r['id']);


			
			// Attaque sur le bouclier en premier
			$Nv_valeur_bouclier_attaquant = $r_b - $ATTAQUE_DIVISER; // On calcul la nouvelle valeur du bouclier


			//MISE A JOUR DES INFORMATIONS SUR LES VAISSEAUX DE L'ATTAQUANT
			//Si la nouvelle valeur est inferieur à zéro on enchaine sur la coque sinon on passera à l'update du bouclier
			if(ceil($Nv_valeur_bouclier_attaquant) <= 0)
				{
					$NV_ATTAQUE_DIVISER_attaquant = $r_b-$ATTAQUE_DIVISER; // on récupère la nouvelle valeur d'attaque avec les dernier pts de bouclier utilisé
					$destruction_coque = $r_c - abs($NV_ATTAQUE_DIVISER_attaquant); // Combien de pts de coque sont perdus
					
					//Mise a zéro du bouclier
					$update_bouclier=$bdd->prepare('UPDATE vaisseau_joueur SET bouclier = ? WHERE id_membre = ? AND id_action = ? AND id=?');
					$update_bouclier->execute(array(0,$id_membre_attaquant,$id_action,$id_VR));
				
						if($destruction_coque < 0) // Si la valeur de la coque est en dessous de zéro, donc détruite on Delete le vaisseau
							{
							
							$delete_vaisseau=$bdd->prepare('DELETE FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ? AND id=?');
							$delete_vaisseau->execute(array($id_membre_attaquant,$id_action,$id_VR));// id_V sert a indiquer quel vaisseau va se voir Update. Chaque vaisseau qui aura encore du bouclier aura sa valeur modifier dans la bdd
							
							
							
							}
							else // Sinon on update la nouvelle valeur de la coque
							{

								$update_bouclier=$bdd->prepare('UPDATE vaisseau_joueur SET defense = ? WHERE id_membre = ? AND id_action = ? AND id=?');
								$update_bouclier->execute(array(ceil($destruction_coque),$id_membre_attaquant,$id_action,$id_VR));// id_V sert a indiquer quel vaisseau va se voir Update. Chaque vaisseau qui aura encore du bouclier aura sa valeur modifier dans la bdd
								
								
							}
				}
				else // Si la valeur du bouclier n'est pas à zéro on enregistre les nouvelles valeurs dans la BDD
				{
					$update_bouclier=$bdd->prepare('UPDATE vaisseau_joueur SET bouclier = ? WHERE id_membre = ? AND id_action = ? AND id=?');
					$update_bouclier->execute(array(ceil($Nv_valeur_bouclier_attaquant),$id_membre_attaquant,$id_action,$id_VR));// id_V sert a indiquer quel vaisseau va se voir Update. Chaque vaisseau qui aura encore du bouclier aura sa valeur modifier dans la bdd
				
					
				}
		}
	
	}
	
//////////////-----------------------------------------/////////////////////

///////CALCUL DU COMBAT DES VAISSEAUX DU DEFENSEUR

///////////////---------------------------------------/////////////////////



//---- ICI LA STRATEGIE DU DEFENSEUR//
$strategie=$bdd->prepare('SELECT * FROM strategie WHERE id_membre = ?');
$strategie->execute(array($id_membre_attaquant));
$strat=$strategie->fetch();

//variable defini a zéro
$tot_defense_defenseur = 0;

//CALCUL LE NOMBRE DE DEFENSE QUE LE JOUEUR POSSÈDE
$d=$bdd->prepare('SELECT * FROM defense_joueur WHERE id_planete = ? AND unite_possede = ? ');
$d->execute(array($id_planete_defenseur,1));
while($d_p=$d->fetch())
{


$nombre_unite_defense_joueur = $d_p['nombre_unite'];
$tot_defense_defenseur+=$nombre_unite_defense_joueur;

}


if($tot_defense_defenseur == "" )
{
	$tot_defense_defenseur = 0;
}

$VALEUR_ATTAQUE_SUR_DEFENSE = 0;

//SI le defenseur n'a pas de défenses alors on passe à 0% l'attaque du defenseur.		
if( $tot_defense_defenseur == 0)
{

$VALEUR_ATTAQUE_SUR_DEFENSE = (0/100)*$ATTAQUE_ATTAQUANT; //---- Seulement X% iront toucher les défenses -/
$ATTAQUE_ATTAQUANT_AVEC_STRATEGIE = $ATTAQUE_ATTAQUANT - $VALEUR_ATTAQUE_SUR_DEFENSE;	
	
}
else
{
	
$VALEUR_ATTAQUE_SUR_DEFENSE = ($strat['pourcentage_attaque_au_defense']/100)*$ATTAQUE_ATTAQUANT; //---- Seulement X% iront toucher les défenses -/
$ATTAQUE_ATTAQUANT_AVEC_STRATEGIE = $VALEUR_ATTAQUE_SUR_DEFENSE;

}

//JE RAJOUTE UN IF CAR SI TOTAL_D est egal a zero la division ne peut pas s'effectuer
if($total_d == 0)
{
	$total_d = 1;
}//Je l'ai rajouté car il me disait un bug de division par zér, que je n'avais pas sur le serveur de stef par exemple.

$ATTAQUE_DIVISER_PAGE_DEF = $ATTAQUE_ATTAQUANT_AVEC_STRATEGIE / $total_d; // Total D est le nombre de vaisseaux total du defenseur


if($ATTAQUE_DIVISER_PAGE_DEF >= 0)
	{
		
							// var_dump($strat['pourcentage_attaque_au_defense']);
					// JE RAJOUTE UNE CONDITION QUI DIT QUE SI LA STRATEGIE EST SUR 100% ATTAQUE DES DEFENSES DE LA PLANETE ALORS ON FAIT AUCUN DEGATS SUR LES VAISSEAUX
					if($strat['pourcentage_attaque_au_defense'] == 100)
					{
						$ATTAQUE_DIVISER_PAGE_DEF =0;
					}
					// echo "</br>";
					// var_dump($ATTAQUE_DIVISER_PAGE_DEF);
					
				//ON SELECTIONNE LES VAISSEAUX DU DEFENSEUR SELON LA PLANETE OU IL SE TROUVE.
				$selec=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id_action = ? AND disponible = ? ');
				$selec->execute(array($id_membre_defenseur,$id_planete_defenseur,0,0));
				while($s=$selec->fetch())
				{
					
					$s_n = htmlentities($s['nom_vaisseau']);
					$s_a = htmlentities($s['attaque']);
					$s_b = htmlentities($s['bouclier']);
					$s_c = htmlentities($s['defense']);
					$id_V = htmlentities($s['id']);
					

					
					// Attaque sur le bouclier en premier
					$Nv_valeur_bouclier = $s_b - $ATTAQUE_DIVISER_PAGE_DEF; // On calcul la nouvelle valeur du bouclier
					
					//Si la nouvelle valeur est inferieur à zéro on enchaine sur la coque sinon on passera à l'update du bouclier
					if(ceil($Nv_valeur_bouclier) <= 0)
						{
							$NV_ATTAQUE_DIVISER_PAGE_DEF = $s_b-$ATTAQUE_DIVISER_PAGE_DEF; // on récupère la nouvelle valeur d'attaque avec les dernier pts de bouclier utilisé
							$destruction_coque = ceil($s_c) - abs($NV_ATTAQUE_DIVISER_PAGE_DEF); // Combien de pts de coque sont perdus
							
							//Mise a zéro du bouclier
							$update_bouclier=$bdd->prepare('UPDATE vaisseau_joueur SET bouclier = ? WHERE id_membre = ? AND id_planete = ? AND id=? AND id_action = ?');
							$update_bouclier->execute(array(0,$id_membre_defenseur,$id_planete_defenseur,$id_V,0));
						
								if($destruction_coque < 0) // Si la valeur de la coque est en dessous de zéro donc détruite on Delete le vaisseau
									{
									
									$delete_vaisseau=$bdd->prepare('DELETE FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id=? AND id_action = ?');
									$delete_vaisseau->execute(array($id_membre_defenseur,$id_planete_defenseur,$id_V,0));// id_V sert a indiquer quel vaisseau va se voir Update. Chaque vaisseau qui aura encore du bouclier aura sa valeur modifier dans la bdd
										
									}
									else // Sinon on update la nouvelle valeur de la coque
									{
										$update_bouclier=$bdd->prepare('UPDATE vaisseau_joueur SET defense = ? WHERE id_membre = ? AND id_planete = ? AND id=? AND id_action = ?');
										$update_bouclier->execute(array(ceil($destruction_coque),$id_membre_defenseur,$id_planete_defenseur,$id_V,0));// id_V sert a indiquer quel vaisseau va se voir Update. Chaque vaisseau qui aura encore du bouclier aura sa valeur modifier dans la bdd
										
									}
						}
						else // Si la valeur du bouclier n'est pas à zéro on enregistre les nouvelles valeurs dans la BDD
						{
							$update_bouclier=$bdd->prepare('UPDATE vaisseau_joueur SET bouclier = ? WHERE id_membre = ? AND id_planete = ? AND id=? AND id_action = ?');
							$update_bouclier->execute(array(ceil($Nv_valeur_bouclier),$id_membre_defenseur,$id_planete_defenseur,$id_V,0));// id_V sert a indiquer quel vaisseau va se voir Update. Chaque vaisseau qui aura encore du bouclier aura sa valeur modifier dans la bdd
							
							
						}
				}
				
				//-------DEGATS SUR LES DEFENSES ---------///	
					
					//Remise à zero du nombre de defenses pour qu'il ne le garde pas en mémoire
					$nombre_defense_du_defenseur = 0;
					//variable defini;
					$valeur_defense_toute_categorie_confondu = 0;
					
					$d=$bdd->prepare('SELECT def.id, def.nom_defense,def.attaque,def.defense,def.cadence_tir, defj.nombre_unite,defj.id_planete,defj.id_defense FROM defense AS def LEFT JOIN defense_joueur AS defj ON def.id=defj.id_defense WHERE defj.id_planete = ? AND defj.unite_possede=? ');
					$d->execute(array($id_planete_defenseur,1));
					while($def_planete=$d->fetch())
					{
					


					
					
							// Nombre de defenses
							$nombre_defense_du_defenseur+= htmlentities($def_planete['nombre_unite']);

							// Valeur de défense totale qui regroupe toute par catégorie.
							$valeur_defense_toute_categorie_confondu+= htmlentities($def_planete['defense']) * htmlentities($def_planete['nombre_unite']);
							$ch_attaque = htmlentities($def_planete['attaque']);
							$ch_defense = htmlentities($def_planete['defense']);
							
							
					}
								//supprimé suite a l'initialisation de la variable
								// if($valeur_defense_toute_categorie_confondu = "")
								// {
									// $valeur_defense_toute_categorie_confondu = 0;
								// }
				
						// Calcul les dégats fait par chaque defense. ( Ne pas oublier que la valeur d'attaque sur defense est un % defini en haut)
						//JE RAJOUTE UN IF CAR SI TOTAL_D est egal a zero la division ne peut pas s'effectuer
						if($nombre_defense_du_defenseur == 0)
						{
							$nombre_defense_du_defenseur = 1;
						}
						//Je l'ai rajouté car il me disait un bug de division par zér0, que je n'avais pas sur le serveur de stef par exemple.

						
						// On calcul les dégats fait aux defenses
						$degats_sur_les_defenses_sol = $ATTAQUE_ATTAQUANT_AVEC_STRATEGIE / $nombre_defense_du_defenseur;

							//Cette variable : $valeur_defense_toute_categorie_confondu LE TOTAL CUMULER DES 'DEFENSES'(Coque)
							//Cette variable : $degats_sur_les_defenses_sol LE TOTAL CUMULER DES DEGATS RECUS SUR LES DESFENSES AU SOL SUR LEURS 'DEFENSES'(Coque)
							
						// echo "<br>dgt so: " . $degats_sur_les_defenses_sol ;
						// echo "<br>v2: " . $valeur_defense_toute_categorie_confondu ;
							
								//On va calculer le resultat des valeurs d'attaques et de defenses, puis voir si le resultat est positif ou negatif.
								$TOTAL_DEFENSE_RESTANT_DES_DEFENSES = $valeur_defense_toute_categorie_confondu - $ATTAQUE_ATTAQUANT_AVEC_STRATEGIE;
								

															
								//Si le reste des points "defenses" des defenses est supérieur à 0 on va calculer le nombre de troupes à retirer
								if($TOTAL_DEFENSE_RESTANT_DES_DEFENSES > 0)
								{

							
									//While qui récupère les informations de chaque defenses.
									$pointDefenseTot2 = 0;
									$de=$bdd->prepare('SELECT def.id, def.nom_defense,def.attaque,def.defense, defj.nombre_unite,defj.id_planete,defj.id_defense FROM defense AS def LEFT JOIN defense_joueur AS defj ON def.id=defj.id_defense WHERE defj.id_planete = ? AND defj.unite_possede=? AND nombre_unite >= ? ');
									$de->execute(array($id_planete_defenseur,1,1));//J'ai rajouté dans la requete le fait d'avoir 1 unite ou plus minimum
									while($la_Def=$de->fetch())
									{
										// Liste caractéristique des défenses			
										$defense_des_defenses2 = htmlentities($la_Def['defense']);
										$nombre_unite_def2 = htmlentities($la_Def['nombre_unite']);


										//Defense total par categorie de defense multiplié par le nombre d'unité que le joueur possède
										$defense_total_par_categorie2 = $defense_des_defenses2*$nombre_unite_def2;

										//Additionne toutes les defenses des différentes défenses.
										$pointDefenseTot2+= $defense_total_par_categorie2;

										$resultat_destruction = $pointDefenseTot2 - $degats_sur_les_defenses_sol;	


										//On compte le nombre de categorie de defense engagé (categorie = nombre de champs de defense dans le jeu)
										$compte=$de->rowCount();


										//je vais diviser l'attaque total par le nombre de catégorie
										$VALEUR_ATTAQUE_PAR_CATEGORIE = $ATTAQUE_ATTAQUANT_AVEC_STRATEGIE / $compte;

										
										// echo "<br> valeur attaque categorie " . $VALEUR_ATTAQUE_PAR_CATEGORIE;
										
										if($VALEUR_ATTAQUE_PAR_CATEGORIE == "NULL")
										{

										$VALEUR_ATTAQUE_PAR_CATEGORIE = 0;

										}
										

										//si zero defense il passe a zéro
										if($la_Def['defense'] == "NULL")
										{
										
										$le_Def['defense'] = 0;
										
										}
										
										//Je divise ensuite la valeur d'attaque par categorie obtenu par la valeur du champ defense de la defense.
										$NOMBRE_PERTE_DEFENSE_PAR_CATEGORIE = $VALEUR_ATTAQUE_PAR_CATEGORIE / $la_Def['defense'];
										
									// echo "<br> NOMBRE_PERTE_DEFENSE_PAR_CATEGORIE : " . floor($NOMBRE_PERTE_DEFENSE_PAR_CATEGORIE);

										//Le chiffre me donne un resultat qui arrondi à l'inférieur va définir le nombre de perte par categorie.

										// On détruit les défenses selon les catégories
										$update_nb_unite_defense=$bdd->prepare('UPDATE defense_joueur SET nombre_unite = nombre_unite-? WHERE id_planete = ? AND id_defense = ?');
										$update_nb_unite_defense->execute(array(floor($NOMBRE_PERTE_DEFENSE_PAR_CATEGORIE),$id_planete_defenseur,$la_Def['id']));	
								
									}
									
									

									
								}
								elseif($TOTAL_DEFENSE_RESTANT_DES_DEFENSES < 0)	//Si le reste des points de defenses des "defenses" est inférieur à zéro alors on retire toute les défenses.
								{
									$pointDefenseTot2 = 0;
									$de=$bdd->prepare('SELECT def.id, def.nom_defense,def.attaque,def.defense, defj.nombre_unite,defj.id_planete,defj.id_defense FROM defense AS def LEFT JOIN defense_joueur AS defj ON def.id=defj.id_defense WHERE defj.id_planete = ? AND defj.unite_possede=? AND nombre_unite >= ? ');
									$de->execute(array($id_planete_defenseur,1,1));//J'ai rajouté dans la requete le fait d'avoir 1 unite ou plus minimum
									while($la_Def=$de->fetch())
									{
									
									
									$maj_degat=$bdd->prepare('UPDATE defense_joueur SET nombre_unite = ? WHERE id_planete = ? AND id_defense = ?');
									$maj_degat->execute(array(0,$id_planete_defenseur,$la_Def['id']));
									
									//Variable utilisé dans save cb bdd defense defenseur
									//$mise_a_jour_degats=$bdd->prepare('INSERT INTO sauvegarde_composition_par_tour(nom_vaisseau,attaque,bouclier,defense,date,tour,categorie,nombre_defense,degat_fait_au_defense,degat_fait_au_vaisseau,degat_subi_par_vaisseau,degat_subi_par_defense,id_membre,id_ennemi,id_planete,id_vaisseau,id_defense,numero_combat,sauvegarde) VALUES(?,?,?,?,NOW(), ?,?,?,?,?, ?,?,?,?,?, ?,?,?,? )');
									//$mise_a_jour_degats->execute(array($la_Def['nom_defense'],$ch_attaque,0,$ch_defense,$tour,0,$la_Def['nombre_unite'],0,0,$VALEUR_ATTAQUE_PAR_CATEGORIE,0,$id_membre_attaquant,$id_membre_defenseur,$id_planete_defenseur,0,$la_Def['id'],$numero_combat,1));
									}

								}

						
	}
	
							
////////////////////////////////////CALCUL DU COMBAT DES DEFENSES//////////////
////////////////////////////////////CALCUL DU COMBAT DES DEFENSES//////////////
////////////////////////////////////CALCUL DU COMBAT DES DEFENSES//////////////

//initialisation de la variable attaque et defense -- Permet d'eviter problème de calcul. Depart = 0$PointAttaqueTot=0;$PointDefenseTot=0;$cadence_tir_Tot=0;

//Je réinitialise la variable de stockage des additions d'attaque des défenses, pour ne pas qu'ils se cumulent à l'ancienne
$PointAttaqueTot = 0;
$pointDefenseTot = 0;
		
		$d=$bdd->prepare('SELECT def.id, def.nom_defense,def.attaque,def.defense, defj.nombre_unite,defj.id_planete,defj.id_defense FROM defense AS def LEFT JOIN defense_joueur AS defj ON def.id=defj.id_defense WHERE defj.id_planete = ? AND defj.unite_possede=? AND nombre_unite >= ? ');
		$d->execute(array($id_planete_defenseur,1,1));//J'ai rajouté dans la requete le fait d'avoir 1 unite ou plus minimum
		while($defense_planete=$d->fetch())
		{	
			
		
			// Liste caractéristique des défenses			$nom_defense = htmlentities($defense_planete['nom_defense']);
			$nom_unite_def1 = htmlentities($defense_planete['nom_defense']);		
			$attaque_des_defenses = htmlentities($defense_planete['attaque']);
			$defense_des_defenses = htmlentities($defense_planete['defense']);
			$nombre_unite_def1 = htmlentities($defense_planete['nombre_unite']);
			
			// Attaque et defense total par categorie de defense multiplié par le nombre d'unité que le joueur possède
			$attaque_total_par_categorie = $attaque_des_defenses*$nombre_unite_def1;
			$defense_total_par_categorie = $defense_des_defenses*$nombre_unite_def1;

			//Additionne toutes les attaques des différentes défenses.
			$PointAttaqueTot+= $attaque_total_par_categorie;
			$pointDefenseTot+= $defense_total_par_categorie;
			
			
		}	

			//Defense totale de l'attaquant

			//JE RAJOUTE UN IF CAR SI TOTAL_A est egal a zero la division ne peut pas s'effectuer
			if($total_a == 0)
			{
				$total_a = 1;
			}//Je l'ai rajouté car il me disait un bug de division par zér, que je n'avais pas sur le serveur de stef par exemple.
			
			//Nombre de cible ennemis
			$nombre_de_cible_ennemi = $total_a;

				// Touche le nombre de cible
				$Degats_par_vaisseau_fait_par_les_defense = $PointAttaqueTot / $nombre_de_cible_ennemi;
				
				///--- COUP PORTE A L'ATTAQUANT ----- ////
				///--- COUP PORTE A L'ATTAQUANT ----- ////
				///--- COUP PORTE A L'ATTAQUANT ----- ////
				
					$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ?  AND id_action = ? ');
					$select->execute(array($id_membre_attaquant,$id_action));
					while($r=$select->fetch())
					{	
						//id du vaisseau
						$id_vaisseau = htmlentities($r['id']);
						// echo $id_vaisseau;
						
						//degats hors bouclier
						$Reste_bouclier_ou_coque_apres_degats = $Degats_par_vaisseau_fait_par_les_defense - htmlentities($r['bouclier']) ;
						// echo $Reste_bouclier_ou_coque_apres_degats;
				
						//Si les degats sont supérieur ou égale au bouclier du vaisseau attaquant
						if($Reste_bouclier_ou_coque_apres_degats >= htmlentities($r['bouclier']))
							{
								//Si le bouclier est déjà egale à zero on update les bouclier à zéro
								$up_degats=$bdd->prepare('UPDATE vaisseau_joueur SET bouclier =? WHERE id=? AND id_membre = ? AND id_action = ?');
								$up_degats->execute(array(0,$id_vaisseau,$id_membre_attaquant,$id_action));
								
								//Si le bouclier est egale à zero on update les degats à la coque
								$up_degats_coque=$bdd->prepare('UPDATE vaisseau_joueur SET defense = defense-? WHERE id=? AND id_membre = ?  AND id_action = ?');
								$up_degats_coque->execute(array(abs(ceil($Reste_bouclier_ou_coque_apres_degats)),$id_vaisseau,$id_membre_attaquant,$id_action));
								
									//Si la coque est inferieur ou égale à zéro le vaisseau est détruit
									if($Reste_bouclier_ou_coque_apres_degats >= htmlentities($r['defense']))
									{
										
										//On detruit le vaisseau.
										$delete_vaisseau=$bdd->prepare('DELETE FROM vaisseau_joueur WHERE id_membre = ? AND id=? AND id_action = ?');
										$delete_vaisseau->execute(array($id_membre_attaquant,$id_vaisseau,$id_action));
										
					
									}
								
							}
							else
							{
								//Si les degats sont inférieur à zero on le remplace par zéro
								if($Degats_par_vaisseau_fait_par_les_defense <= 0)
								{
									$Degats_par_vaisseau_fait_par_les_defense = 0;
									
								
								//Update les degats aux boucliers
								$up_degats=$bdd->prepare('UPDATE vaisseau_joueur SET bouclier = bouclier-? WHERE id=? AND id_membre = ? AND id_action = ?');
								$up_degats->execute(array(abs(ceil($Degats_par_vaisseau_fait_par_les_defense)),$id_vaisseau,$id_membre_attaquant,$id_action));
								}
								else
								{
									
								//Update les degats aux boucliers
								$up_degats=$bdd->prepare('UPDATE vaisseau_joueur SET bouclier = bouclier-? WHERE id=? AND id_membre = ? AND id_action = ? ');
								$up_degats->execute(array(abs(ceil($Degats_par_vaisseau_fait_par_les_defense)),$id_vaisseau,$id_membre_attaquant,$id_action));
								
								}

								
							}
					}

			
?>
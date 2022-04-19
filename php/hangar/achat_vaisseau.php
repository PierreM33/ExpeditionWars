<?php 
	

if($_POST)
 {
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
		
	 if(!empty($_POST['id_cache'])) 
		{ 		
			if(is_numeric($_POST['nombre_demande'])) 
			{ 

		
				$id_cache = strip_tags($_POST['id_cache']);
				$nombre_demande=strip_tags($_POST['nombre_demande']);
				

				$req_ressource_disponible=$bdd->prepare("SELECT * FROM ressource WHERE id_planete = ? ");  /*récupère la liste des ressources du joueur */
				$req_ressource_disponible->execute(array($planete_utilise));
				$ressource_disponible=$req_ressource_disponible->fetch();

				$req_af_v=$bdd->prepare("SELECT * FROM chantier_spatial WHERE id = ? AND id_planete = ?"); /*Permet d'afficher infos des unitées de la table */
				$req_af_v->execute(array($id_cache,$planete_utilise));
				$af_v=$req_af_v->fetch();

				$pop_dispo=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?'); /*Permet d'afficher infos des troupes distribué */
				$pop_dispo->execute(array($planete_utilise));
				$af_pop_dispo=$pop_dispo->fetch();
				
				//TECHNOLOGIE ATTAQUE
				$technologie=$bdd->prepare('SELECT * FROM technologie_joueur WHERE id_membre = ? AND id_technologie=?'); /*Permet d'afficher infos des troupes distribué */
				$technologie->execute(array($id_membre,51));
				$niveau_tech_atta=$technologie->fetch();
				
				//TECHNOLOGIE def
				$technologie=$bdd->prepare('SELECT * FROM technologie_joueur WHERE id_membre = ? AND id_technologie=?'); /*Permet d'afficher infos des troupes distribué */
				$technologie->execute(array($id_membre,52));
				$niveau_tech_def=$technologie->fetch();

				//TECHNOLOGIE bouclier
				$technologie=$bdd->prepare('SELECT * FROM technologie_joueur WHERE id_membre = ? AND id_technologie=?'); /*Permet d'afficher infos des troupes distribué */
				$technologie->execute(array($id_membre,53));
				$niveau_tech_boucl=$technologie->fetch();


				
				$prix_gold=htmlentities($af_v['prix_gold']);
				$prix_titane=htmlentities($af_v['prix_titane']);
				$prix_cristal=htmlentities($af_v['prix_cristal']);
				$prix_orinia=htmlentities($af_v['prix_orinia']);
				$prix_orinium=htmlentities($af_v['prix_orinium']);
				$prix_organique=htmlentities($af_v['prix_organique']);
				
				$attaque_origine=htmlentities($af_v['attaque']);
				$defense_origine=htmlentities($af_v['defense']);
				$bouclier_origine=htmlentities($af_v['bouclier']);
				
											//ON RECUPERE LA FACTION DU JOUEUR
		$faction=$bdd->prepare('SELECT * FROM faction_joueur WHERE id_membre = ? ');
		$faction->execute(array($id_membre));
		$Fact=$faction->fetch();
		
		//ON RECUPERE ENSUITE LES LOIS ADOPTE DE CETTE FACTION POUR RECUPERER LA PRODUCTION SUPPLEMENTAIRE
		$faction_loi=$bdd->prepare('SELECT * FROM faction_loi WHERE faction = ? AND adopte = ? AND numero = ?');
		$faction_loi->execute(array(htmlentities($Fact['nom_faction']),1,3));
		$Fa_L=$faction_loi->fetch();
		

					//ON RAJOUTE LE POURCENTAGE DE PRODUCTION DE LA FACTION
			if(htmlentities($Fa_L['effet']) == "temps-5%")
			{
					$tempsX = htmlentities($af_v['temps'])*5/100;
					$tem = $af_v['temps'] - $tempsX;
			}
			else
			{
							$tem = htmlentities($af_v['temps']);

			}
			
				$temps1=$tem * $nombre_demande; 
				$temps = time() + $temps1;

				//AUGMENTATION DE 1% par niveau de technologie
				$attaque = $attaque_origine + ($niveau_tech_atta['niveau']*$attaque_origine)/100;
				$defense = $defense_origine + ($niveau_tech_def['niveau']*$defense_origine)/100;
				$bouclier = $bouclier_origine + ($niveau_tech_boucl['niveau']*$bouclier_origine)/100;
				
				
				$nom_vaisseau=htmlentities($af_v['nom']);
				$surnom=htmlentities($af_v['surnom']);
				$vitesse=htmlentities($af_v['vitesse']);
				$type_vaisseau=htmlentities($af_v['type']);
				$poid=htmlentities($af_v['poid']);
				$fret=htmlentities($af_v['fret']);
				$chasseur=htmlentities($af_v['chasseur']);
				$place_chasseur=htmlentities($af_v['place_chasseur']);
				$ouvrier_demande=htmlentities($af_v['ouvrier']);
				$pilote_demande=htmlentities($af_v['pilote']);
				$gabarit=htmlentities($af_v['gabarit']);
				$vaisseau_possede = htmlentities($af_v['vaisseau_possede']);
				
				$nombre_unite=htmlentities($af_v['nombre_unite']);
				$pilote_preforme=htmlentities($af_pop_dispo['pilote']);
				$ouvrier_preforme=htmlentities($af_pop_dispo['ouvrier']);

				$pilote_demande_total=$pilote_demande*$nombre_demande;
				$ouvrier_demande_total=$ouvrier_demande*$nombre_demande;

				$goldstock = htmlentities($ressource_disponible['gold']);
				$titanestock = htmlentities($ressource_disponible['titane']);
				$cristalstock = htmlentities($ressource_disponible['cristal']);
				$oriniastock = htmlentities($ressource_disponible['orinia']);
				$oriniumstock = htmlentities($ressource_disponible['orinium']);
				$organiquestock = htmlentities($ressource_disponible['organique']);
				
		// Permet de vérifier qu'il n'entre pas un nombre négatif
		if ($nombre_demande > 0) 
		{							
		
			// Permet de vérifier qu'il possède assez de pilote	
			if ( $pilote_preforme >= $pilote_demande_total ) 								
			{			
				//Verifie le nombre d'ouvrier preforme
				if($ouvrier_preforme >= $ouvrier_demande_total)
					{
						//Calcul de la valeur total de l'achat
						$valeur_achat_or = $prix_gold*$nombre_demande;											
						$valeur_achat_titane = $prix_titane*$nombre_demande;
						$valeur_achat_cristal =$prix_cristal*$nombre_demande;
						$valeur_achat_orinia = $prix_orinia*$nombre_demande;
						$valeur_achat_orinium = $prix_orinium*$nombre_demande;
						$valeur_achat_organique=$prix_organique*$nombre_demande;
						
						// Permet de vérifier que ses stocks soit sup à la demande d'achat de ressources
						if (($goldstock >= $valeur_achat_or) AND ($titanestock >= $valeur_achat_titane) AND ($cristalstock >= $valeur_achat_cristal)
							AND ($oriniastock >= $valeur_achat_orinia) AND ($oriniumstock >= $valeur_achat_orinium) AND ($organiquestock >= $valeur_achat_organique)) 
						{	

							// Verifie si l'on possède bien le vaisseau dans le hangar
							if($vaisseau_possede > 0)
								{

										$id_spatial=$id_cache; //récupération de la valeur caché //
									
									//Tant que le nombre demandé est supérieur à zéro on achete

									$D=$bdd->prepare('INSERT INTO construction_hangar (id_membre,id_planete,nom_unite,nombre_formation,temps,id_hangar,attaque,defense,bouclier,vitesse,type,fret,poid,gabarit,chasseur,limite_chasseur) VALUES(?,?,?,?,? ,?,?,?,?,? ,?,?,?,?,?,?)');
									$D->execute(array($id_membre,$planete_utilise,$nom_vaisseau,$nombre_demande,$temps,$id_spatial,$attaque,$defense,$bouclier,$vitesse,$type_vaisseau,$fret,$poid,$gabarit,$chasseur,$place_chasseur));
									

												$req_deduction_pilote_preforme=$bdd->prepare("UPDATE population SET pilote = pilote-? WHERE id_planete = ?");
												$req_deduction_pilote_preforme->execute(array($pilote_demande_total,$planete_utilise));
												
												$req_deduction_ouvrier_preforme=$bdd->prepare("UPDATE population SET ouvrier = ouvrier-? WHERE id_planete = ?");
												$req_deduction_ouvrier_preforme->execute(array($ouvrier_demande_total,$planete_utilise));
												

												/* GOLD */
												$prix_achat_gold = $goldstock-$valeur_achat_or;
												$req_achat_gold = $bdd->prepare('UPDATE ressource SET gold = ? WHERE id_planete = ?');
												$req_achat_gold->execute(array($prix_achat_gold, $planete_utilise));
												
												
												$point_gold=$valeur_achat_or/1000;
												$req_up_point_gold=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
												$req_up_point_gold->execute(array($point_gold,$id_membre));
												
												/* TITANE */
												$prix_achat_titane = $titanestock-$valeur_achat_titane;
												$req_achat_titane = $bdd->prepare('UPDATE ressource SET titane = ? WHERE id_planete = ?');
												$req_achat_titane->execute(array($prix_achat_titane, $planete_utilise));
												
												$point_titane=$valeur_achat_titane/1000;
												$req_up_point_t=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
												$req_up_point_t->execute(array($point_titane,$id_membre));
												
												/* CRISTAL */
												$prix_achat_cristal = $cristalstock-$valeur_achat_cristal;						
												$req_achat_cristal = $bdd->prepare('UPDATE ressource SET cristal = ? WHERE id_planete = ?');
												$req_achat_cristal->execute(array($prix_achat_cristal, $planete_utilise));
												
												$point_cristal=$valeur_achat_cristal/1000;
												$req_up_point_c=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
												$req_up_point_c->execute(array($point_cristal,$id_membre));
												
												/* ORINIA */
												$prix_achat_orinia = $oriniastock-$valeur_achat_orinia;
												$req_achat_orinia = $bdd->prepare('UPDATE ressource SET orinia = ? WHERE id_planete = ?');
												$req_achat_orinia->execute(array($prix_achat_orinia, $planete_utilise));
												
												$point_orinia=$valeur_achat_orinia/1000;
												$req_up_point_orinia=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
												$req_up_point_orinia->execute(array($point_orinia,$id_membre));
												
												/* ORINIUM */
												$prix_achat_orinium = $oriniumstock-$valeur_achat_orinium;
												$req_achat_orinium  = $bdd->prepare('UPDATE ressource SET orinium = ? WHERE id_planete = ?');
												$req_achat_orinium->execute(array($prix_achat_orinium, $planete_utilise));
												
												$point_orinium=$valeur_achat_orinium/1000;
												$req_up_point_orinium=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
												$req_up_point_orinium->execute(array($point_orinium,$id_membre));
												
												/* ORGANIQUE */
												$prix_achat_organique = $organiquestock-$valeur_achat_organique;
												$req_achat_organique = $bdd->prepare('UPDATE ressource SET organique = ? WHERE id_planete = ?');
												$req_achat_organique->execute(array($prix_achat_organique, $planete_utilise));
												
												$point_organique=$valeur_achat_organique/1000;
												$req_up_point_organique=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
												$req_up_point_organique->execute(array($point_organique,$id_membre));
												
																				//AJOUT DES POINTS EVENEMENTS

											$point_total=$point_gold+$point_titane+$point_cristal+$point_orinia+$point_orinium+$point_organique;

											$aj_pts_ev=$bdd->prepare('UPDATE point_evenement SET nombre_point = nombre_point+?');
											$aj_pts_ev->execute(array($point_total));
											
											// QUETE NUMERO 6
											$rq=$bdd->prepare('SELECT * FROM quete WHERE id_membre = ? AND numero_quete = ?'); 
											$rq->execute(array($id_membre,6));
											$quete_fini=$rq->fetch();
											
											if($quete_fini['valide'] == 0)
											{
											$req=$bdd->prepare('UPDATE quete SET valide=? WHERE id_membre= ? AND numero_quete = ?');
											$req->execute(array(1,$id_membre,6));
											}

									
											$_SESSION['error'] = '<p class="green">Achat effectuée.</p>';
											
									}
									else
										$_SESSION['error'] = '<p class="red">Vous n\'avez pas débloqué ce vaisseau.</p>';
								}
								else
									$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de ressources en stock.</p>';
							}
							else
								$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez d\'ouvriers préformé.</p>';
						}
						else
						$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de pilotes préformé.</p>';	
		}
		else
			$_SESSION['error']='<p class="red">Impossible de mettre un nombre négatif.</p>';
		}
		else
			$_SESSION['error'] = '<p class="red">Vous devez et ne pouvez mettre qu\'un chifre ou un nombre.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';		
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'hangar/hangar_valhar.php'); 
	?>	
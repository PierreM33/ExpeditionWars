<?php 

if($_POST)
{
	require_once '../../include/connexion_bdd.php';		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 		
		if(!empty($_POST['id_cache'])) 
		{ 
			$id_technologie = strip_tags($_POST['id_cache']);
			
			$req_ress=$bdd->prepare("SELECT * FROM ressource WHERE id_planete = ? ");  
			$req_ress->execute(array($planete_utilise));
			$ressource=$req_ress->fetch();

			$pop=$bdd->prepare('SELECT * FROM population WHERE id_planete = ? '); 
			$pop->execute(array($planete_utilise));
			$population=$pop->fetch();
			

			$tech=$bdd->prepare("SELECT * FROM technologie WHERE id = ? "); 
			$tech->execute(array($id_technologie));
			$techno=$tech->fetch();
			
			// REDEFINIR VARIABLE //
			$nom=htmlentities($techno['nom']);
			$race=htmlentities($techno['race']);
			
			
			$tech=$bdd->prepare("SELECT * FROM technologie_joueur WHERE id_membre = ? AND id_technologie = ? ");  
			$tech->execute(array($id_membre,$id_technologie));
			$technologie=$tech->fetch();
			
			// REDEFINIR VARIABLE //
			$niveau_technologie=htmlentities($technologie['niveau']);
			$temps=htmlentities($technologie['temps']);
			$delai=(time()+$temps);
			$prix_gold=htmlentities($technologie['prix_gold']);
			$prix_titane=htmlentities($technologie['prix_titane']);
			$prix_cristal=htmlentities($technologie['prix_cristal']);
			$prix_orinia=htmlentities($technologie['prix_orinia']);
			$prix_orinium=htmlentities($technologie['prix_orinium']);
			$prix_organique=htmlentities($technologie['prix_organique']);
			$nombre_chercheur=htmlentities($technologie['nombre_chercheur']);
			$technologie_possede = htmlentities($technologie['technologie_possede']);
			
								
			$goldstock=htmlentities($ressource['gold']);
			$titanestock=htmlentities($ressource['titane']);
			$cristalstock=htmlentities($ressource['cristal']);
			$oriniastock=htmlentities($ressource['orinia']);
			$oriniumstock=htmlentities($ressource['orinium']);
			$organiquestock=htmlentities($ressource['organique']);

			$chercheur_preforme=htmlentities($population['chercheur']);

		$reqNb=$bdd->prepare("SELECT * FROM construction_techno WHERE joueur=? ");
		$reqNb->execute(array($id_membre));
		$construction = $reqNb->rowCount();

	if($construction == 0)
	{	
			if($technologie_possede > 0)
				{
					if ($chercheur_preforme >= $nombre_chercheur) 					// Permet de vérifier qu'il possède assez de chercheur. Sinon erreur.	
					{																					
						if (($goldstock >= $prix_gold) AND ($titanestock >= $prix_titane) AND ($cristalstock >= $prix_cristal) AND 
							($oriniastock >= $prix_orinia) AND ($oriniumstock >= $prix_orinium) AND ($organiquestock >= $prix_organique))
							{	
								$stock_chercheur_preforme=$chercheur_preforme-$nombre_chercheur;					
															
								// CALCUL NOUVEAU CHERCHEURS

								$req_deduction_chercheur_preforme=$bdd->prepare("UPDATE population SET chercheur = ? WHERE id_planete = ?");
								$req_deduction_chercheur_preforme->execute(array($stock_chercheur_preforme,$planete_utilise));


								// UPDATE DES RESSOURCES
								$req_achat_gold = $bdd->prepare('UPDATE ressource SET gold = gold-?, titane = titane-?, cristal = cristal-?, orinia = orinia-?, orinium = orinium-?, organique = organique-? WHERE id_planete = ? AND id_membre = ? ');
								$req_achat_gold->execute(array($prix_gold,$prix_titane, $prix_cristal, $prix_orinia, $prix_orinium, $prix_organique, $planete_utilise, $id_membre));
								
								// SAUVEGARDE DE L'ACHAT
								$save_achat = $bdd->prepare('INSERT INTO sauvegarde_achat_technologie_joueur(gold, titane, cristal, orinia, orinium, organique, chercheur, id_membre, id_planete, niveau,temps,id_technologie,date) VALUES (?,?,?,? ,?,?,? ,?,?,?, ?,?,NOW()) ');
								$save_achat->execute(array($prix_gold,$prix_titane, $prix_cristal, $prix_orinia, $prix_orinium, 0,$nombre_chercheur, $id_membre,$planete_utilise,$niveau_technologie,$delai,$id_technologie));

								// SYSTEME DE POINTS

								$point_gold=$prix_gold/1000;
								$point_titane=$prix_titane/1000;
								$point_cristal=$prix_cristal/1000;
								$point_orinia=$prix_orinia/1000;
								$point_orinium=$prix_orinium/1000;
								$point_organique=$prix_organique/1000;
								
								
								$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
								$req->execute(array($point_gold,$id_membre));
								
								$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
								$req->execute(array($point_titane,$id_membre));
								
								$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
								$req->execute(array($point_cristal,$id_membre));
							
								$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
								$req->execute(array($point_orinia,$id_membre));
								
								$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
								$req->execute(array($point_orinium,$id_membre));
								
								$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
								$req->execute(array($point_organique,$id_membre));
								
											//AJOUT DES POINTS EVENEMENTS
								
								$point_total=$point_gold+$point_titane+$point_cristal+$point_orinia+$point_orinium+$point_organique;
								
								$aj_pts_ev=$bdd->prepare('UPDATE point_evenement SET nombre_point = nombre_point+?');
								$aj_pts_ev->execute(array($point_total));

								// DEFINI UN BATIMENT EN CONSTRUCTION 
								$aug=$bdd->prepare('UPDATE technologie_joueur SET construction = 1 WHERE id_membre = ?');
								$aug->execute(array($id_membre));

								$req_up_construc=$bdd->prepare('INSERT INTO construction_techno (joueur, id_planete,technologie, time, post,gold,titane,cristal,orinia,orinium,chercheur,temps) VALUES (?,?,?,?, ?,?,?,?,?,?,?,?)');
								$req_up_construc->execute(array( $id_membre,$planete_utilise, $id_technologie,$delai, $id_technologie, $prix_gold,$prix_titane, $prix_cristal, $prix_orinia, $prix_orinium,$nombre_chercheur,$delai ));

								$up_ach_tech=$bdd->prepare('UPDATE sauvegarde_achat_technologie SET nom_technologie = ?, id_cache = ? WHERE id_membre =?');
								$up_ach_tech->execute(array($nom,$id_technologie,$id_membre));

								
								$_SESSION['error']='<p class="green">Amélioration en cours.</p>';
								header('Location: '.pathView().'technologies/technologie_' . $race . '.php');
									
								}
								else
								$_SESSION['error']='<p class="red"> Vous n\'avez pas les ressources nécéssaire.</p>';
							
						}
						else
						$_SESSION['error']='<p class="red">Vous n\'avez pas assez de chercheurs.<p>';
					
				}
				else
				$_SESSION['error']='<p class="red">Vous n\'avez pas débloqué cette technologie.<p>';
		}
	else
		$_SESSION['error']='<p class="red">Une technologie est déjà en construction.</p>';
	
		}
		else
		$_SESSION['error']='<p class="red">Tous les champs ne sont pas remplis</p>';

	}
	else
	$_SESSION['error']='<p class="red">Erreur.</p>';

header('Location: '.pathView().'technologies/technologie_' . $race . '.php');
?>
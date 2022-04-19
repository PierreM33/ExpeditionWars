<?php 
	@ini_set('display_errors', 'on');
if($_POST)
{

require_once '../../include/connexion_bdd.php';
	$planete_utilise=htmlentities(htmlspecialchars($_SESSION['planete_utilise']));
	$id_membre=htmlentities(htmlspecialchars($_SESSION['id']));
	
	if(!empty($_POST['id_cache'])) 
		{	
	
			$id_defense=strip_tags($_POST['id_cache']);
			$nombre_defense_demande=strip_tags($_POST['nombre_demande']);
						

				if(is_numeric($_POST['nombre_demande']) ) 
				{ 
		
					//Récupère les ressources du joueur
					$req_ress=$bdd->prepare("SELECT * FROM ressource WHERE id_planete = ? ");  
					$req_ress->execute(array($planete_utilise));
					$ressource=$req_ress->fetch();

					$goldstock=htmlentities($ressource['gold']);
					$titanestock=htmlentities($ressource['titane']);
					$cristalstock=htmlentities($ressource['cristal']);
					$oriniastock=htmlentities($ressource['orinia']);
					$oriniumstock=htmlentities($ressource['orinium']);
					$organiquestock=htmlentities($ressource['organique']);

					//Recupère les infos des défenses celon l'id envoyé
					$d=$bdd->prepare("SELECT * FROM defense WHERE id = ? ");  
					$d->execute(array($id_defense));
					$def=$d->fetch();
					
					$de=$bdd->prepare("SELECT * FROM defense_joueur WHERE id_defense = ? AND id_planete = ?");  
					$de->execute(array($id_defense,$planete_utilise));
					$def_j=$de->fetch();
					
					$unite_possede=htmlentities($def_j['unite_possede']);
					
					$race=htmlentities($def['race']);
					$prix_gold=htmlentities($def['prix_gold']);
					$prix_titane=htmlentities($def['prix_titane']);
					$prix_cristal=htmlentities($def['prix_cristal']);
					$prix_orinia=htmlentities($def['prix_orinia']);
					$prix_orinium=htmlentities($def['prix_orinium']);
					$prix_organique=htmlentities($def['prix_organique']);
					
					$nom = htmlentities($def['nom_defense']);
					
					$tem = htmlentities($def['temps']);
					$temps1=$tem * $nombre_defense_demande; 
					$temps = time() + $temps1;
					
								// Je rajoute une protection contre un eventuel HACK d'un joueur qui voudrait acheter une citée (ID numero 10)
					if($id_defense != 10 )
					{
						
						if($unite_possede > 0)
						{
							if ($nombre_defense_demande >= 0) 
								{	

									$valeur_achat_gold=$prix_gold*$nombre_defense_demande;
									$valeur_achat_titane = $prix_titane*$nombre_defense_demande;
									$valeur_achat_cristal = $prix_cristal*$nombre_defense_demande;
									$valeur_achat_orinium = $prix_orinium*$nombre_defense_demande;
									$valeur_achat_orinia = $prix_orinia*$nombre_defense_demande;
									$valeur_achat_organique = $prix_organique*$nombre_defense_demande;

									if (($goldstock >= $valeur_achat_gold) AND ($titanestock >= $valeur_achat_titane) AND ($cristalstock >= $valeur_achat_cristal) AND 
										($oriniastock >= $valeur_achat_orinia) AND ($oriniumstock >= $valeur_achat_orinium) AND ($organiquestock >= $valeur_achat_organique))
											{	

											
												//On ajoute les defenses dans la table de defenses en attente du temps
											$D=$bdd->prepare('INSERT INTO construction_defense (id_membre,id_planete,nom_unite,nombre_formation,temps,id_defense) VALUES(?,?,?,?,?,?)');
											$D->execute(array($id_membre,$planete_utilise,$nom,$nombre_defense_demande,$temps,$id_defense));
											
												// UPDATE DES RESSOURCES
												$req_achat = $bdd->prepare('UPDATE ressource SET gold = gold-?, titane = titane-?, cristal = cristal-?, orinia = orinia-?, orinium = orinium-?, organique = organique-? WHERE id_planete = ? AND id_membre = ? ');
												$req_achat->execute(array($valeur_achat_gold,$valeur_achat_titane, $valeur_achat_cristal, $valeur_achat_orinia, $valeur_achat_orinium, $valeur_achat_organique, $planete_utilise, $id_membre));

										
												// SYSTEME DE POINTS

												$point_gold=$valeur_achat_gold/1000;
												$point_titane=$valeur_achat_titane/1000;
												$point_cristal=$valeur_achat_cristal/1000;
												$point_orinia=$valeur_achat_orinia/1000;
												$point_orinium=$valeur_achat_orinium/1000;
												$point_organique=$valeur_achat_organique/1000;
												
												
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

															

												$_SESSION['error'] = '<p class="green">Achat effectuée.</p>';
											}
											else
												$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de ressources en stock.</p>';
										}
										else
											$_SESSION['error']='<p class="red">Impossible de mettre un nombre négatif.</p>';
						}
						else
						$_SESSION['error'] = '<p class="red">Vous n\'avez pas débloqué l\'unité.</p>';
					}
					else
					$_SESSION['error'] = '<p class="red">Impossible de construire cette défense, elle n\'est pas constructible.</p>';
				}
				else
					$_SESSION['error'] = '<p class="red">Erreur.Utilisez un chiffre.</p>';

		}
		else
			$_SESSION['error'] = '<p class="red">Les champs sont vide.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'defense/defense_' . $race . '.php');
?>
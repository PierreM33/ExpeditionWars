<?php		
@ini_set('display_errors', 'on');
if($_POST)
{
				require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']); 
	
	
		// selection de sa planète
		$m = $bdd->prepare("SELECT * FROM planete WHERE id = ?");
		$m->execute(array($planete_utilise));
		$joueur_ouvrant_vortex=$m->fetch();
		
		//ressource du joueur qui ouvre le vortex
		$req_ress = $bdd->prepare("SELECT * FROM ressource WHERE id_planete = ? ");
		$req_ress->execute(array($planete_utilise));
		$user_ress=$req_ress->fetch();
		
		$energie=htmlentities($user_ress['energie']);

		// coordonnees du joueur visé
		$ga = $bdd->prepare("SELECT * FROM planete WHERE coordonnee_terrestre = ?");
		$ga->execute(array($_POST['coordonnee']));
		$Coord_Joueur_vise=$ga->fetch();
		
	if(!empty($_POST['coordonnee']))
			{
					if($_POST['coordonnee'] != htmlentities($joueur_ouvrant_vortex['coordonnee_terrestre']))//Empecher d'ouvrir un vortex vers sa planète.
					{				

								if($_POST['coordonnee'] == htmlentities($Coord_Joueur_vise['coordonnee_terrestre']))//Verifie que l'adresse soit correct.
									{
										
											

											
										//On récupère les infos de la table portail du joueur que l'ont vise pour verifier par la suite les heures d'ouverture
										// VERIFICATION SI LE PORTAIL EST ACTIF OU NON AVEC QUELQU'UN D'AUTRE
											$portail_actif=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
											$portail_actif->execute(array(htmlentities($Coord_Joueur_vise['id'])));
											$p_actif=$portail_actif->fetch();
										
										/*
										$temps_R = $p_actif['temps'] - time();

										//SI LE VORTEX EST pas oUvert cette ligne est pas prise en compte
										if($temps_R > 0) // Verifie si le chrono des deux portes connecté est dépassé, si oui il fermera leurs vortex
										{
											
											// RECUPERER LID DE LA PORTE CONNECTE
											$v=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
											$v->execute(array(htmlentities($Coord_Joueur_vise['id'])));
											$id_porte_connecte=$v->fetch();

											// PERMET DE RECUPERER L'ID DU MEMBRE
											$ve=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
											$ve->execute(array($id_porte_connecte['porte_connecte']));
											$cible=$ve->fetch();

											$actif=$bdd->prepare('UPDATE portail SET actif = ? , interagir = ?, porte_connecte = ?, id_membre = ? WHERE id_planete = ?');
											$actif->execute(array(0,0,0,0,htmlentities($Coord_Joueur_vise['id'])));


											//UPDATE DESACTIVATION DE LA PORTE DU JOUEUR
											$portail_actif=$bdd->prepare('UPDATE portail SET actif = ?, interagir = ?, porte_connecte = ?, id_membre = ? WHERE id_planete = ?');
											$portail_actif->execute(array(0,0,0,0,$id_porte_connecte['porte_connecte']));
											
											// VERIFICATION SI LE PORTAIL EST ACTIF OU NON AVEC QUELQU'UN D'AUTRE
											$portail_actif=$bdd->prepare('SELECT actif FROM portail WHERE id_planete = ?');
											$portail_actif->execute(array(htmlentities($Coord_Joueur_vise['id'])));
											$p_actif=$portail_actif->fetch();
										}*/
										
										//Sinon
															if( htmlentities($p_actif['actif']) == 0 )
																{												
																		
																			if($energie >= 100)
																				{
																					
																					$temps = time()+180;
																																							
																					//UPDATE DE L'ACTIVATION DE LA PORTE DU JOUEUR VISE
																					$portail_acti=$bdd->prepare('UPDATE portail SET  heure_ouverture = NOW() , actif = ? , interagir = ?, porte_connecte = ?, id_membre = ? , temps = ? WHERE id_planete = ?');
																					$portail_acti->execute(array(1,1,$planete_utilise,htmlentities($Coord_Joueur_vise['id_membre']),$temps,htmlentities($Coord_Joueur_vise['id'])));
																						
																					// RETRAIR DE 100 ENERGIE POUR L'OUVERTURE VORTEX
																					$conso=100;
																					$up_energie=$bdd->prepare('UPDATE ressource SET energie = energie-? WHERE id_planete = ?');
																					$up_energie->execute(array($conso,$planete_utilise));
																					
																					// UPDATE L'ACTIVATION DE MA PORTE
																					$actif=$bdd->prepare('UPDATE portail SET heure_ouverture = NOW() , actif = ?, porte_connecte = ?, id_membre = ?, temps = ? WHERE id_planete = ?');
																					$actif->execute(array(1,htmlentities($Coord_Joueur_vise['id']),$id_membre,$temps,$planete_utilise));

																					var_dump($Coord_Joueur_vise['id']);
																					$_SESSION['error'] = '<p class="green"> Ouverture du Vortex. </p>';
																					header('Location: '.pathView().'vortex/page_vortex.php');
																			}
																			else
																			$_SESSION['error'] = '<p class="red"> Vous manquez d\'énergie. </p>';

															}
															else
															$_SESSION['error'] = '<p class="red"> Le portail que vous essayez de joindre est déjà actif.Veuillez patienter ... </p>';
									}
									else
									$_SESSION['error'] = '<p class="red"> Impossible d\'établir un vortex.Erreur de coordonnees.</p>';
					}
					else
					$_SESSION['error'] = '<p class="red"> Impossible d\'ouvrir un vortex vers sa propre planète.</p>';
			}
			else
			$_SESSION['error'] = '<p class="red"> ENTREZ UN NUMERO DE COORDONNEES</p>';
}
else
$_SESSION['error'] = '<p class="red"> Erreur.</p>';
 header('Location: '.pathView().'vortex/page_portail_spatial.php');

?>
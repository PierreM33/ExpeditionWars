<?php												
if($_POST)
	{
		
		require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

// Recuperer les infos de sa planete
$m = $bdd->prepare('SELECT * FROM planete WHERE id = ?');
$m->execute(array($planete_utilise));
$Me=$m->fetch();	


		
		$coordonnee_planete_vise=strip_tags($_POST['coordonnee_planete_vise']);
		
		
		// récuperer les coordonnées de la planète adversaire pour verifier qu'elle existe
		$ga = $bdd->prepare("SELECT * FROM planete WHERE coordonnee_spatial = ?");
		$ga->execute(array($coordonnee_planete_vise));
		$Coord_Joueur_vise=$ga->fetch();

		$id_membre_adverse = htmlentities($Coord_Joueur_vise['id_membre']);
		
//On inclue le calcul de temps;
include "deplacement.php";

			
		//recupère le temps dans la protection joueur
		$ptr=$bdd->prepare('SELECT * FROM protection_joueur WHERE id_membre = ?');
		$ptr->execute(array(htmlentities($Coord_Joueur_vise['id_membre'])));
		$T=$ptr->fetch();

		$temps_p = htmlentities($T['protection_temps']);

		$restant = $temps_p - time();
		
		require_once "restriction_attaque.php";
					
				//On récupère les informations dans la diplomatie voir si se sont des alliées.
		$diplomatie = $bdd->prepare('SELECT * FROM diplomatie WHERE id_allie = ?');
		$diplomatie -> execute(array(htmlentities($Coord_Joueur_vise['id_membre'])));
		$dip = $diplomatie->fetch();
		
		//Colonie permet de verifier dans la table planete que la planete nous appartient
		$colonie = $Me['id_membre'];
		$planete_allie = htmlentities($dip['pacte']);



		
		//SI le joueur à moin sde 3 jours de jeu
		if( $restant <= 0)
		{			


	if($PTS_B <= $superieur AND $PTS_B >= $inferieur OR $etat == "En cours" OR $PTS_B >= 500000)
	{
		
		
		if(strip_tags($_POST['coordonnee_planete_vise']) != htmlentities($Me['coordonnee_spatial']))//Empecher d''envoyer des vaisseaux attaquer sa planete.
			{	
				if(strip_tags($_POST['coordonnee_planete_vise']) == htmlentities($Coord_Joueur_vise['coordonnee_spatial']))//Verifie que l'adresse soit correct.
					{
						if($Coord_Joueur_vise['planete_occupe'] == 1)
							{
							if(!empty($_POST['coordonnee_planete_vise']))
								{				
							
								//Empeche l'attaque de ses propres planètesou celle de ses alliés.
								if($planete_allie == 0 AND $colonie != $id_membre_adverse)
								{
											//On rajoute que la liste de vaisseaux ne peut pas être vide
											if(!empty($_POST['id_vaisseau']))
											{
												//On va verifier que le joueur soit pas trop faible
											
											//On va verifier que le joueur n'ai pas activé un bouclier
												
											//On va récuperer également la protection du joueur s'il a activé un bouclier
													$BJ=$bdd->prepare('SELECT * FROM bouclier_joueur WHERE id_membre = ?');
													$BJ->execute(array($id_membre_adverse));
													$BOU_J=$BJ->fetch();

													$temps_B = htmlentities($BOU_J['temps']);

													$restant_bouclier = $temps_B - time();



													if($restant_bouclier <= 0)
														{

													
												$temps_trajet = time() + $temps_general;
													
												// Selectionne les statistiques des vaisseaux à transferé dans l'autre table
												$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id=?');
												$select->execute(array($id_membre,$planete_utilise,$id_vaisseau));
												$s=$select->fetch();
									
												$id_membre_vise = $Coord_Joueur_vise['id_membre'];
													
												$att=$bdd->prepare('INSERT INTO vaisseau_action (id_membre_vise, planete_vise, id_membre, id_planete, nom_action, temps,type,stockage_valeur_deplacement) VALUES (?,?,?,?,?,?,?,?)');
												$att->execute(array($Coord_Joueur_vise['id_membre'], $Coord_Joueur_vise['id'], $id_membre, $planete_utilise, 1, $temps_trajet,2,$temps_general));
													
												// On récupère l'ID de l'action
												$action_id = $bdd->lastInsertId();
												
													foreach( $_POST['id_vaisseau'] as $id_vaisseau ) // uniquement les cases cochées
													{													
																		
														// On informe le joueur visé qu'il subit une menace
														//SI on se fait attaquer
														$menace=$bdd->prepare('UPDATE attaque_sdc SET attaque_oui = ? WHERE id_planete= ? AND id_membre = ?');
														$menace->execute(array(1,$Coord_Joueur_vise['id'],$Coord_Joueur_vise['id_membre']));
											
														//On Update la table vaisseau_joueur
														$upvais=$bdd->prepare('UPDATE vaisseau_joueur SET id_action = ?	WHERE id_membre = ? AND id = ?');
														$upvais->execute(array($action_id, $id_membre, $id_vaisseau));
																			$_SESSION['error'] = '<p class="green"> Votre flotte &acirc; &eacute;t&eacute; envoy&eacute;.</p>';
													}
											}
											else
											$_SESSION['error'] = '<p class="red"> Le joueur à activé un bouclier de 24H00, Impossible de l\'attaquer.</p>';
									}
									else
									$_SESSION['error'] = '<p class="red">Aucun vaisseau sélectionné.</p>';
								}
								else
								$_SESSION['error'] = '<p class="red">Il s\'agit d\'une de vos planètes. Impossible de l\'attaquer.</p>';
							}
							else
							$_SESSION['error'] = '<p class="red"> Les coordonnees ne peuvent pas &ecirc;tre vide.</p>';
						}
						else
						$_SESSION['error'] = '<p class="red"> La plan&egrave;te n\'est pas occup&eacute;, imposible de l\'attaquer.</p>';
					}
					else
					$_SESSION['error'] = '<p class="red"> Impossible d\'attaquer cette plan&egrave;te. Erreur de coordonnees.</p>';
			}
			else
			$_SESSION['error'] = '<p class="red"> Impossible d\'attaquer sa propre plan&egrave;te.</p>';
}
	else
	$_SESSION['error'] = '<p class="red">Le joueur visé est trop faible ou trop fort.</p>';		
}
	else
	$_SESSION['error'] = '<p class="red">Joueur sous protection des joueurs faible.</p>';	
}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./flotte/attaquer_planete_espace.php');
	?>
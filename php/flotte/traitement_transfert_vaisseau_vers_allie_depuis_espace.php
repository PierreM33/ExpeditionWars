<?php

if($_POST)
	{
		
			require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
// Script qui va etre utilisé pour se deplacer d'une case espace vers un allié


		
		$nouvelle_position=strip_tags($_POST['nouvelle_position']);
		
		// récuperer les coordonnées des planètes habité par les joueurs
		$ga = $bdd->prepare("SELECT * FROM planete WHERE coordonnee_spatial = ?");
		$ga->execute(array($nouvelle_position));
		$Coord_planete_habite=$ga->fetch();
		
		//On inclue le calcul de temps;
include "deplacementA.php";

		//On récupère les informations dans la diplomatie voir si se sont des alliées.
		$diplomatie = $bdd->prepare('SELECT * FROM diplomatie WHERE id_allie = ?');
		$diplomatie -> execute(array(htmlentities($Coord_planete_habite['id_membre'])));
		$dip = $diplomatie->fetch();
		
		//Colonie permet de verifier dans la table planete que la planete nous appartient
		$colonie = htmlentities($Coord_planete_habite['id_membre']);
		$planete_allie = htmlentities($dip['pacte']);

				if(strip_tags($_POST['nouvelle_position']) == htmlentities($Coord_planete_habite['coordonnee_spatial']))//Verifie que l'adresse soit correct.
					{
						if($Coord_planete_habite['planete_occupe'] == 1) // Si les coordonnée sont celle d'une planète.
							{
							if(!empty($nouvelle_position))
								{				
									//On va vérifier qu'il s'agisse d'une planète allié ou la notre
									if($planete_allie == 1 OR $colonie == $id_membre)
									{
										

										$temps_trajet = time() + $temps_general;

										// Selectionne les statistiques des vaisseaux à transferé dans l'autre table
										$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id=? ');
										$select->execute(array($id_membre,$planete_utilise,$id_vaisseau));
										$s=$select->fetch();


										// NOM ACTION
										// ATTAQUER = 1;
										// DEPLACEMENT VERS ALLIE = 2
										// DEPLACEMENT ESPACE = 3
										
										//ICI 2
										$att=$bdd->prepare('INSERT INTO vaisseau_action (id_membre_vise, planete_vise, id_membre, id_planete, nom_action, temps,stockage_valeur_deplacement,type) VALUES (?,?,?,?,?,?,?,?)');
										$att->execute(array($Coord_planete_habite['id_membre'], $Coord_planete_habite['id'], $id_membre, $planete_utilise, 2, $temps_trajet, $temps_general,2));

										// On récupère l'ID de l'action
										$id_action = $bdd->lastInsertId();

											foreach( $_POST['id_vaisseau'] as $id_vaisseau ) // uniquement les cases cochées
											{													

											
											//On Update la table vaisseau_joueur
											$upvais=$bdd->prepare('UPDATE vaisseau_joueur SET id_action = ?, case_espace = ?, case_planete = ?	WHERE id_membre = ? AND id = ?');
											$upvais->execute(array($id_action,1,0, $id_membre, $id_vaisseau));
											
											}

													
										$_SESSION['error'] = '<p class="green"> Votre flotte &acirc; &eacute;t&eacute; envoy&eacute;.</p>';
										
									}
									else
									$_SESSION['error'] = '<p class="red"> Selectionnez une planète allié ou une de vos planète.' . $planete_allie . '</p>';

							}
							else
							$_SESSION['error'] = '<p class="red"> Les coordonnees ne peuvent pas &ecirc;tre vide.</p>';
						}
						else
						$_SESSION['error'] = '<p class="red"> La plan&egrave;te n\'est pas occup&eacute;, imposible de s\'y rendre.</p>';
					}
					else
					$_SESSION['error'] = '<p class="red"> Impossible pour cette plan&egrave;te. Erreur de coordonnees.</p>';
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./flotte/baser_vaisseau_allie_espace.php');
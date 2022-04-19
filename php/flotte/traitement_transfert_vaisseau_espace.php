<?php

if($_POST)
	{
			require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

		$nouvelle_position=strip_tags($_POST['nouvelle_position']);
		
		// récuperer les coordonnées des planètes habité par les joueurs
		$ga = $bdd->prepare("SELECT * FROM planete WHERE coordonnee_spatial = ?");
		$ga->execute(array($nouvelle_position));
		$Coord_planete_habite=$ga->fetch();
		
		//SE script nous permet d'envoyer les vaisseaux présent dans l'espace vers une case espace
		//On inclue le calcul de temps;
		include "deplacementA.php";


				if(strip_tags($_POST['nouvelle_position']) == htmlentities($Coord_planete_habite['coordonnee_spatial']))//Verifie que l'adresse soit correct.
					{
						if($Coord_planete_habite['planete_occupe'] == 0) // Si les coordonnée sont celle d'une planète inhabité
							{
								if($Coord_planete_habite['espace'] == 1) // Si les coordonnée sont celle d'une case espace.
									{
										if(!empty($nouvelle_position))
											{				
													

													$temps_trajet = time() + $temps_general;
	
	
													// NOM ACTION
													// ATTAQUER = 1;
													// DEPLACEMENT VERS ALLIE = 2
													// DEPLACEMENT ESPACE = 3
													
													//ICI 3
													$att=$bdd->prepare('INSERT INTO vaisseau_action (id_membre_vise, planete_vise, id_membre, id_planete, nom_action, temps,stockage_valeur_deplacement,type) VALUES (?,?,?,?,?,?,?,?)');
													$att->execute(array($Coord_planete_habite['id_membre'], $Coord_planete_habite['id'], $id_membre, $planete_utilise, 3, $temps_trajet, $temps_general,3));

													// On récupère l'ID de l'action
													$action_id = $bdd->lastInsertId();

													foreach( $_POST['id_vaisseau'] as $id_vaisseau ) // uniquement les cases cochées
													{													
													//On Update la table vaisseau_joueur
													$upvais=$bdd->prepare('UPDATE vaisseau_joueur SET id_action = ?, case_espace = ?, case_planete = ?	WHERE id_membre = ? AND id = ?');
													$upvais->execute(array($action_id,1,0, $id_membre, $id_vaisseau));
													

													
													}
											
																$_SESSION['error'] = '<p class="green"> Votre flotte &acirc; &eacute;t&eacute; envoy&eacute;.</p>';
											
													}
													else
													$_SESSION['error'] = '<p class="red"> Les coordonnees ne peuvent pas &ecirc;tre vide.</p>';

									}
									else
									$_SESSION['error'] = '<p class="red"> Il ne s\'agit pas d\'une case espace.</p>';}

					}
					else
					$_SESSION['error'] = '<p class="red"> Impossible pour cette plan&egrave;te. Erreur de coordonnees.</p>';
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./flotte/baser_vaisseau_espace.php');
?>
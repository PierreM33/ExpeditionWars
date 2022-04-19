<?php
@ini_set('display_errors', 'on');
													
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
	$ga = $bdd->prepare('SELECT * FROM planete WHERE coordonnee_spatial = ?');
	$ga->execute(array($coordonnee_planete_vise));
	$Coord_Joueur_vise=$ga->fetch();

$id_membre_adverse = $Coord_Joueur_vise['id_membre'];

	//On inclue le calcul de temps;
include "deplacement.php";

	//recupère le temps dans la protection joueur
	$ptr=$bdd->prepare('SELECT * FROM protection_joueur WHERE id_membre = ?');
	$ptr->execute(array($id_membre_adverse));
	$T=$ptr->fetch();


	$temps_p = htmlentities($T['protection_temps']);


	$restant = $temps_p - time();


	require_once "restriction_attaque.php";
	

	// PARTIE GUERRE //
//On va vérifier si le joueur est en guerre avec son ennemi

//En cas de victoire sur un adversaire d'une guerre il faut ajouter les points de guerre
$recup=$bdd->prepare('SELECT * FROM alliance_membre WHERE id_membre = ?');
$recup->execute(array($id_membre));
$REC=$recup->fetch();

//RECUPERER LE NUMERO DE l'alliance vise
$recup=$bdd->prepare('SELECT * FROM alliance_membre WHERE id_membre = ?');
$recup->execute(array($id_membre_adverse));
$REC_B=$recup->fetch();


$ID_ALLIANCE_UN = htmlentities($REC['id_alliance']);
$ID_ALLIANCE_DEUX = htmlentities($REC_B['id_alliance']);

$All=$bdd->prepare('SELECT * FROM alliance_guerre WHERE id_alliance_un = ? AND id_alliance_deux = ?');
$All->execute(array($ID_ALLIANCE_UN,$ID_ALLIANCE_DEUX));
$G=$All->fetch();

$etat = htmlentities($G['etat']);

		//On récupère les informations dans la diplomatie voir si se sont des alliées.
		$diplomatie = $bdd->prepare('SELECT * FROM diplomatie WHERE id_allie = ? AND id_membre = ?');
		$diplomatie -> execute(array($id_membre_adverse,$id_membre));
		$dip = $diplomatie->fetch();
		
		//Colonie permet de verifier dans la table planete que la planete nous appartient
		$colonie = $Me['id_membre'];
		$planete_allie = $dip['pacte'];
		
		// var_dump($dip);
		// var_dump($planete_allie);
		// var_dump($id_membre_adverse);

					
	//SI le joueur à moins de 3 jours de jeu
	if( $restant <= 0)
	{			

		if( $PTS_B <= $superieur AND $PTS_B >= $inferieur OR $etat == "En cours" OR $PTS_B >= 500000)
		{

			if(strip_tags($_POST['coordonnee_planete_vise']) != $Me['coordonnee_spatial'])//Empecher d''envoyer des vaisseaux attaquer sa planete.
			{	
				if(strip_tags($_POST['coordonnee_planete_vise']) == $Coord_Joueur_vise['coordonnee_spatial'])//Verifie que l'adresse soit correct.
				{
					if($Coord_Joueur_vise['planete_occupe'] == 1)
					{
						if(!empty($_POST['coordonnee_planete_vise']))
						{				

							//Empeche l'attaque de ses propres planètesou celle de ses alliés.
							// if($planete_allie == 0 OR $planete_allie == "NULL" AND $colonie != $id_membre_adverse)		
							if($colonie != $id_membre_adverse)
							{
					
								//On rajoute que la liste de vaisseaux ne peut pas être vide
								if(!empty($_POST['id_vaisseau']))
								{
										
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
											
										$att=$bdd->prepare('INSERT INTO vaisseau_action (id_membre_vise, planete_vise, id_membre, id_planete, nom_action, temps, stockage_valeur_deplacement,type) VALUES (?,?,?,?,?,?,?,?)');
										$att->execute(array($Coord_Joueur_vise['id_membre'], $Coord_Joueur_vise['id'], $id_membre, $planete_utilise, 1, $temps_trajet, $temps_general,1));
											
										// On récupère l'ID de l'action
										$action_id = $bdd->lastInsertId();
										
										foreach( $_POST['id_vaisseau'] as $id_vaisseau ) // uniquement les cases cochées
										{													
															
											// On informe le joueur visé qu'il subit une menace
											//SI on se fait attaquer
											$menace=$bdd->prepare('UPDATE attaque_sdc SET attaque_oui = ? WHERE id_planete= ? AND id_membre = ?');
											$menace->execute(array(1,$Coord_Joueur_vise['id'],$Coord_Joueur_vise['id_membre']));
								

											//On Update la table vaisseau_joueur
											$upvais=$bdd->prepare('UPDATE vaisseau_joueur SET id_action = ?	WHERE id_membre = ? AND id_planete = ? AND id = ?');
											$upvais->execute(array($action_id, $id_membre, $planete_utilise, $id_vaisseau));
											
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
						$_SESSION['error'] = '<p class="red"> Les coordonnees ne peuvent pas être vide.</p>';
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
	$_SESSION['error'] = '<p class="red">Joueur sous protection des joueurs nouveau.</p>';	
}
else
$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./flotte/attaquer_planete_quai.php');
?>
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
		$ga = $bdd->prepare("SELECT * FROM planete WHERE coordonnee = ?");
		$ga->execute(array($_POST['coordonnee_planete_vise']));
		$Coord_Joueur_vise=$ga->fetch();
		
		if(strip_tags($_POST['coordonnee_planete_vise']) != htmlentities($Me['coordonnee']))//Empecher d''envoyer des vaisseaux attaquer sa planete.
			{	
				if(strip_tags($_POST['coordonnee_planete_vise']) == htmlentities($Coord_Joueur_vise['coordonnee']))//Verifie que l'adresse soit correct.
					{
							if(!empty($_POST['coordonnee_planete_vise']))
								{				
										foreach( $_POST['id_vaisseau'] as $id_vaisseau ) // uniquement les cases cochées
												{													// Récupère la ligne de la table planete avec les coordonnées enregistré
													$enn=$bdd->prepare('SELECT * FROM planete WHERE coordonnee = ?');
													$enn->execute(array($coordonnee_planete_vise));
													$ennemi=$enn->fetch();
													
													// Selectionne les statistiques des vaisseaux à transferé dans l'autre table
													$select=$bdd->prepare('SELECT * FROM vaisseau_mouvement WHERE id_membre = ? AND id_vaisseau=?');
													$select->execute(array($id_membre,$id_vaisseau));
													$s=$select->fetch();

													$nom_vaisseau=htmlentities($s['nom_vaisseau']);
													$attaque_v=htmlentities($s['attaque']);
													$bouclier_v=htmlentities($s['bouclier']);
													$defense_v=htmlentities($s['defense']);
													
													//PENSER A REJOUTER LES AUTRES STATISTIQUES UNE FOIS FINI
													$up_nv_bdd=$bdd->prepare('INSERT INTO vaisseau_selection(id_vaisseau,nom_vaisseau,attaque,bouclier,defense,vitesse,type,gabarit,poid,fret,chasseur,objet_un,objet_deux,id_planete_origine,id_membre,planete_vise) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
													$up_nv_bdd->execute(array($id_vaisseau,$nom_vaisseau,$attaque_v,$bouclier_v,$defense_v,htmlentities($s['vitesse']),htmlentities($s['type']),htmlentities($s['gabarit']),htmlentities($s['poid']),htmlentities($s['fret']),htmlentities($s['chasseur']),htmlentities($s['objet_un']),htmlentities($s['objet_deux']),htmlentities($s['id_planete']),$id_membre,htmlentities($ennemi['id']))); 
													
													// SI on ajoute les vaisseaux selectionné, on retire en revanche ceux de la planète
													$del=$bdd->prepare('DELETE FROM vaisseau_mouvement WHERE id_vaisseau = ?');
													$del->execute(array($id_vaisseau));	
													
													$_SESSION['error'] = '<p class="green"> Votre flotte à été envoyé.</p>';
												}
												
							}
							else
							$_SESSION['error'] = '<p class="red"> Les coordonnees ne peuvent pas être vide.</p>';
					}
					else
					$_SESSION['error'] = '<p class="red"> Impossible d\'attaquer cette planète. Erreur de coordonnees.</p>';
			}
			else
			$_SESSION['error'] = '<p class="red"> Impossible d\'attaquer sa propre planète.</p>';
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./flotte/positionner_flotte.php');
	?>
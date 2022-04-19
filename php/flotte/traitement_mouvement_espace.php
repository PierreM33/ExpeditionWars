<?php
@ini_set('display_errors', 'on');
require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

//Rajouter le temps si cela ne marche passthru
//Liste des vaisseau en cours pour le combats
$table=$bdd->prepare('SELECT * FROM vaisseau_action WHERE nom_action = ?');
$table->execute(array(3));
while($liste_vaisseau=$table->fetch())
{

	if(time() >= $liste_vaisseau['temps'])
	{

		$id_planete_vise = htmlentities($liste_vaisseau['planete_vise']);
		$id_membre_vise = htmlentities($liste_vaisseau['id_membre_vise']);
		$id_membre_attaquant = htmlentities($liste_vaisseau['id_membre']);
		$id_planete_attaquant = htmlentities($liste_vaisseau['id_planete']);
		$id_action = $liste_vaisseau['id'];


			// Recuperer les infos de sa planete
			$m = $bdd->prepare('SELECT * FROM planete WHERE id = ?');
			$m->execute(array($id_planete_vise));
			$nv_position=$m->fetch();	

			$systeme = htmlentities($nv_position['numero_systeme']);
			$x = htmlentities($nv_position['x']);
			$y = htmlentities($nv_position['y']);
			$coordonnee = $nv_position['coordonnee_spatial'];



			//on change sa planete / ses coordonnée / on annule son action 
			$update=$bdd->prepare('UPDATE vaisseau_joueur SET id_membre = ?, id_planete = ?, id_action = ?, systeme = ?, x=? , y=?, case_planete = ?, case_espace = ? WHERE id_membre = ? AND id_action = ?');
			$update->execute(array($id_membre_attaquant,$id_planete_vise,0,$systeme,$x,$y,0,1,$id_membre_attaquant,$id_action));
			
			//remplacement de id_membre_vise en fin de array par id membre;
	}


			// On supprime le vaisseau de vaisseau selection
			 $del=$bdd->prepare('DELETE FROM vaisseau_action WHERE id = ? AND nom_action = ?');
			 $del->execute(array($id_action,3));	

		include 'message_vaisseau_arrive_espace.php';
	

}

 header('Location: '.pathView().'./flotte/vaisseaux_en_deplacement.php');

?>
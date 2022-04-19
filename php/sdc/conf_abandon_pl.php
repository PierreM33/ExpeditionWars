<?php

if($_POST['accepter'])
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
	
			$num = htmlentities($_SESSION['planete_utilise']);

				
			//EFFACER LES PLANETES DU JOUEUR
			$i=$bdd->prepare('UPDATE planete SET nom_planete = ?, id_membre=?, planete_mere = ?, avatar_p=?, id_mine = ?, id_defense = ?, id_population = ?, id_caserne = ?, id_batiment = ?, planete_occupe = ?, pseudo_membre=? WHERE id = ?');
			$i->execute(array("Vide",0,0,"aucune",0,0,0,0,0,0,"vide",$num)); 
			
			//ATTAQUE SDc
			$del=$bdd->prepare('DELETE FROM attaque_sdc WHERE id_planete = ?');
			$del->execute(array($num));
			
			//CASERNE JOUEUR A VOIR CAR PAR PLANETE
			$del=$bdd->prepare('DELETE FROM caserne_joueur WHERE id_planete = ?');
			$del->execute(array($num));
			
			//CHANTIER SPATIAL A VOIR CAR PLANETE
			$del=$bdd->prepare('DELETE FROM chantier_spatial WHERE id_planete = ?');
			$del->execute(array($num));	
			
			//Detruire les Constructions en cour
			
			$del=$bdd->prepare('DELETE FROM construction_caserne WHERE id_planete = ?');
			$del->execute(array($num));	
			
			$del=$bdd->prepare('DELETE FROM construction_defense WHERE id_planete = ?');
			$del->execute(array($num));
			
			$del=$bdd->prepare('DELETE FROM construction_etab WHERE id_planete = ?');
			$del->execute(array($num));
			
			$del=$bdd->prepare('DELETE FROM construction_hangar WHERE id_planete = ?');
			$del->execute(array($num));
			
			$del=$bdd->prepare('DELETE FROM construction_techno WHERE id_planete = ?');
			$del->execute(array($num));
			
		
			//Equipe exploration
			$del=$bdd->prepare('DELETE FROM equipe_exploration_joueur WHERE id_planete = ?');
			$del->execute(array($num));	
			
			//DEFENSES JOUEUR
			$del=$bdd->prepare('DELETE FROM defense_joueur WHERE id_planete = ?');
			$del->execute(array($num));	
			
			//ETABLISSEMENT
			$del=$bdd->prepare('DELETE FROM etablissement_joueur WHERE id_planete = ?');
			$del->execute(array($num));	
			
			// MINES A VOIR
			$del=$bdd->prepare('DELETE FROM mines_joueur WHERE id_planete = ?');
			$del->execute(array($num));	
			
			//Exploration Joueurs
			$del=$bdd->prepare('DELETE FROM exploration_joueur WHERE id_planete = ?');
			$del->execute(array($num));
			
			//infrastructure
			$del=$bdd->prepare('DELETE FROM infrastructure WHERE id_planete = ?');
			$del->execute(array($num));
			
			//OBJET
			$del=$bdd->prepare('DELETE FROM objet_joueur WHERE id_planete = ?');
			$del->execute(array($num));	
			
			//POPULATION
			$del=$bdd->prepare('DELETE FROM population WHERE id_planete = ?');
			$del->execute(array($num));	
			
			//PORTAIL
			$del=$bdd->prepare('DELETE FROM portail WHERE id_planete = ?');
			$del->execute(array($num));	
			
			//RESSOURCES
			$del=$bdd->prepare('DELETE FROM ressource WHERE id_planete = ?');
			$del->execute(array($num));	
			
			
			//Territoire
			$del=$bdd->prepare('DELETE FROM territoire_planete WHERE id_planete = ?');
			$del->execute(array($num));
			
			//VAISSEAUX
			$del=$bdd->prepare('DELETE FROM vaisseau_chasseur_embarque WHERE id_planete = ?');
			$del->execute(array($num));

			
			$del=$bdd->prepare('DELETE FROM vaisseau_joueur WHERE id_planete = ?');
			$del->execute(array($num));
			
			// JE RECUPERE LA PLANETE MERE POUR RENVOYER LE JOUEUR DESSUS
			// J'UPDATE LE MEMBRE AVEC SA PLANETE MERE
			$tableplanete = $bdd->prepare("SELECT * FROM planete WHERE  planete_mere=? AND id_membre= ?");
			$tableplanete->execute(array(1,$id_membre));
			$plan = $tableplanete->fetch();
			
			$_SESSION['planete_utilise'] = $plan['id'];
			$planete_maj = htmlentities($_SESSION['planete_utilise']);
			
			
			$maj=$bdd->prepare('UPDATE membre SET planete_utilise = ? WHERE id = ?');
			$maj->execute(array($planete_maj,$id_membre));

			$_SESSION['error'] = '<p class="green">Colonie abandonné </p>';

}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'sdc/temporaire.php');

?>
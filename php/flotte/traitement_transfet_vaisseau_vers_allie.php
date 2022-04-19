<?php
// @ini_set('display_errors', 'on');
	require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

$table=$bdd->prepare('SELECT * FROM vaisseau_action WHERE nom_action = ?');
$table->execute(array(2));
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
			
			//----RESSOURCES 
									
						//Recupère les stock des différents vaisseaux
						$mm= $bdd->prepare('SELECT * FROM vaisseau_joueur  WHERE id_action = ?');
						$mm->execute(array($id_action));
						$ST=$mm->fetch();
						
						
						$gold = $ST['stock_gold'];
						$titane = $ST['stock_titane'];
						$cristal = $ST['stock_cristal'];
						$orinia = $ST['stock_orinia'];
						$orinium = $ST['stock_orinium'];
						$organique = $ST['stock_organique'];
					
						$total = $gold+$titane+$cristal+$orinia+$orinium+$organique;
						
						//Déchargement automatique des ressources.
						$p=$bdd->prepare('UPDATE vaisseau_joueur SET stock_gold = ? , stock_titane = ? , stock_cristal = ? , stock_orinia = ? , stock_orinium = ? , stock_organique = ? , fret = fret+? WHERE id_action = ?');
						$p->execute(array(0,0,0,0,0,0,$total,$id_action));
						
						//Ajoute aux ressources
						$r=$bdd->prepare('UPDATE ressource SET gold = gold + ?, titane = titane+?, cristal = cristal + ?, orinia = orinia+?, orinium = orinium+?, organique = organique + ? WHERE id_planete = ? AND id_membre = ? ');
						$r->execute(array($gold,$titane,$cristal,$orinia,$orinium,$organique,$id_planete_vise,$id_membre));

			//on change sa planete / ses coordonnée / on annule son action 
			$update=$bdd->prepare('UPDATE vaisseau_joueur SET id_membre = ?, id_planete = ?, id_action = ?, systeme = ?, x=? , y=?, case_planete = ?, case_espace = ? WHERE id_action = ?');
			$update->execute(array($id_membre_vise,$id_planete_vise,0,$systeme,$x,$y,1,0,$id_action));
			
			
		}


			// On supprime l'action
			 $del=$bdd->prepare('DELETE FROM vaisseau_action WHERE id = ? AND nom_action = ?');
			 $del->execute(array($id_action,2));	



						
						
			include 'message_transfert';
	//----------MESSAGES ----////
						$sele=$bdd->prepare('SELECT * FROM planete WHERE id =?');
						$sele->execute(array($id_planete_vise));
						$PlaneteUtilise=$sele->fetch();

						$nom = $PlaneteUtilise['nom_planete'];
						$systeme = $PlaneteUtilise['numero_systeme'];
						$coordonnee = $PlaneteUtilise['coordonnee_spatial'];


						$message=" Votre flotte revient de combat et délivre ses ressources sur votre planète <font color='red'><b>" . $nom . "</b></font> dans le syst&agrave;me num&eacute;ro  <font color='red'><b>" . $systeme . "</b></font> au coordonn&eacute;e suivante : <font color='red'><b>" . $coordonnee . "</b></font>.
						Ils rapportent au total : <font color='red'><b>" . $total . "</b></font> ressources.
						";

						// Insertion du message résultant de l'espionnage				
						$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
						$msg->execute(array($id_membre_attaquant,$id_membre_attaquant,$message,time(),0,"Retour de vaisseaux."));
						
						
						


}

 header('Location: '.pathView().'./flotte/vaisseaux_en_deplacement.php');

?>


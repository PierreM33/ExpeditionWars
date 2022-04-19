<?php 

@ini_set('display_errors', 'on');


if($_POST['annuler'])
{

require_once '../../include/connexion_bdd.php';

		$planete_utilise= $_SESSION['planete_utilise'];
		$id_membre= $_SESSION['id']; 
		
		
	$recup=$bdd->prepare('SELECT * FROM construction_etab WHERE joueur = ? AND id_planete = ?');
	$recup->execute(array($id_membre,$planete_utilise));
	$R=$recup->fetch();

	$gold = htmlentities($R['gold']);	
	$titane = htmlentities($R['titane']);
	$cristal = htmlentities($R['cristal']);
	$orinia = htmlentities($R['orinia']);
	$planete = htmlentities($R['id_planete']);
	
		// SYSTEME DE POINTS

	$point_gold=$gold/1000;
	$point_titane=$titane/1000;
	$point_cristal=$cristal/1000;
	$point_orinia=$orinia/1000;


	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_gold,$id_membre));

	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_titane,$id_membre));

	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_cristal,$id_membre));

	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_orinia,$id_membre));
	
	
			$suppr=$bdd->prepare('DELETE FROM construction_etab WHERE joueur = ? AND id_planete = ?');
			$suppr->execute(array($id_membre,$planete_utilise));		
			
			//On rembourse l'achat
			$remb=$bdd->prepare('UPDATE ressource SET gold = gold+? , titane=titane+?, cristal=cristal+?, orinia=orinia+? WHERE id_planete = ? AND id_membre=?');
			$remb->execute(array($gold,$titane,$cristal,$orinia,$planete,$id_membre));

			
			
				$_SESSION['error']='<p class="green">Construction annulé.</p>';
	}
	else
	$_SESSION['error']='<p class="red">Erreur.</p>';

header('Location: '.pathView().'etablissements/etab_laboratoire_recherche.php');

?>
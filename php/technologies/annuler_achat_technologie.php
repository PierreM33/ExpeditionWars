<?php 


if($_POST['annuler'])
{
	
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

	$recup=$bdd->prepare('SELECT * FROM construction_techno WHERE joueur = ?');
	$recup->execute(array($id_membre));
	$R=$recup->fetch();

	$gold = htmlentities($R['gold']);	
	$titane = htmlentities($R['titane']);
	$cristal = htmlentities($R['cristal']);
	$orinia = htmlentities($R['orinia']);
	$orinium = htmlentities($R['orinium']);
	$chercheur = htmlentities($R['chercheur']);
	$planete = htmlentities($R['id_planete']);
	
	// SYSTEME DE POINTS

	$point_gold=$gold/1000;
	$point_titane=$titane/1000;
	$point_cristal=$cristal/1000;
	$point_orinia=$orinia/1000;
	$point_orinium=$orinium/1000;


	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_gold,$id_membre));

	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_titane,$id_membre));

	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_cristal,$id_membre));

	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_orinia,$id_membre));

	$req=$bdd->prepare('UPDATE membre SET point= point-? WHERE id= ?');
	$req->execute(array($point_orinium,$id_membre));

								
	
			$suppr=$bdd->prepare('DELETE FROM construction_techno WHERE joueur = ?');
			$suppr->execute(array($id_membre));		
								
			$aug=$bdd->prepare('UPDATE technologie_joueur SET construction = 0 WHERE id_membre = ?');
			$aug->execute(array($id_membre));
			
			//On rembourse l'achat
			$remb=$bdd->prepare('UPDATE ressource SET gold = gold+? , titane=titane+?, cristal=cristal+?, orinia=orinia+?, orinium=orinium+? WHERE id_planete = ? AND id_membre=?');
			$remb->execute(array($gold,$titane,$cristal,$orinia,$orinium,$planete,$id_membre));
			
			$remb=$bdd->prepare('UPDATE population SET chercheur=chercheur+? WHERE id_planete = ?');
			$remb->execute(array($chercheur,$planete));
			
			
				$_SESSION['error']='<p class="green">Technologie annulé.</p>';
	}
	else
	$_SESSION['error']='<p class="red">Erreur.</p>';

header('Location: '.pathView().'technologies/technologie_general.php');

?>
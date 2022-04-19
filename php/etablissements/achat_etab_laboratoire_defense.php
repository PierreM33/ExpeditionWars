<?php

if($_POST)
{
require_once '../../include/connexion_bdd.php';
$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 


$post=strip_tags($_POST['id_cache']);


		$req_ressource_disponible=$bdd->prepare('SELECT * FROM ressource WHERE id_planete = ? AND id_membre = ?');  /*récupère la liste des ressources du joueur */
		$req_ressource_disponible->execute(array($planete_utilise,$id_membre));
		$ressource_disponible=$req_ressource_disponible->fetch();
		
		$req=$bdd->prepare('SELECT * FROM etablissement_joueur WHERE id_planete = ? AND joueur = ? AND id_etab = ?');  /*récupère la liste des ressources du joueur */
		$req->execute(array($planete_utilise,$id_membre,$post));
		$etab_j=$req->fetch();
		
        $prix_gold=htmlentities($etab_j['prix_gold']);
        $prix_titane=htmlentities($etab_j['prix_titane']);
        $prix_cristal=htmlentities($etab_j['prix_cristal']);
        $prix_orinia=htmlentities($etab_j['prix_orinia']);
		$temps=htmlentities($etab_j['temps']);
		$delai =(time()+$temps);
				$niveau=htmlentities($etab_j['niveau']);
		$id_etab=htmlentities($etab_j['id_etab']);
		
					
		$goldstock = htmlentities($ressource_disponible['gold']);
		$titanestock = htmlentities($ressource_disponible['titane']);
		$cristalstock = htmlentities($ressource_disponible['cristal']);
		$oriniastock = htmlentities($ressource_disponible['orinia']);

		$reqNb=$bdd->prepare("SELECT * FROM construction_etab WHERE joueur=? AND id_planete = ?");
		$reqNb->execute(array($id_membre,$planete_utilise));
		$construction = $reqNb->rowCount();


	if( $construction == 0)
		{
			if (($goldstock >= $prix_gold) AND ($titanestock >= $prix_titane) AND ($cristalstock >= $prix_cristal) AND 
			($oriniastock >= $prix_orinia))
				{	
											
						$req_achat= $bdd->prepare('UPDATE ressource SET gold = gold-?, titane = titane-?, cristal = cristal-?, orinia = orinia-? WHERE id_planete = ? AND id_membre = ? ');
						$req_achat->execute(array($prix_gold,$prix_titane, $prix_cristal, $prix_orinia, $planete_utilise,$id_membre));
							
													// SAUVEGARDE DE L'ACHAT
						$save_achat = $bdd->prepare('INSERT INTO sauvegarde_achat_etablissement (gold, titane, cristal, orinia, orinium, organique, id_membre, id_planete, niveau,temps,id_etab,date) VALUES (?,?,? ,?,?,? ,?,?,?, ?,?,NOW()) ');
						$save_achat->execute(array($prix_gold,$prix_titane, $prix_cristal, $prix_orinia, 0, 0, $id_membre,$planete_utilise,$niveau,$delai,$id_etab));
						
						
										// SYSTEME DE POINTS

						$point_gold=$prix_gold/1000;
						$point_titane=$prix_titane/1000;
						$point_cristal=$prix_cristal/1000;
						$point_orinia=$prix_orinia/1000;
						
						
						$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
						$req->execute(array($point_gold,$id_membre));
						
						$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
						$req->execute(array($point_titane,$id_membre));
						
						$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
						$req->execute(array($point_cristal,$id_membre));
					
						$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
						$req->execute(array($point_orinia,$id_membre));
						
						//AJOUT DES POINTS EVENEMENTS
			
						$point_total=$point_gold+$point_titane+$point_cristal+$point_orinia;
						
						$aj_pts_ev=$bdd->prepare('UPDATE point_evenement SET nombre_point = nombre_point+?');
						$aj_pts_ev->execute(array($point_total));
						
						/* DEFINI UN BATIMENT EN CONSTRUCTION */

						$req_multip=$bdd->prepare('UPDATE etablissement_joueur SET construction = 1 WHERE id_planete = ? AND id_etab= ?');
						$req_multip->execute(array($planete_utilise, $post));

						$req_up_construc=$bdd->prepare('INSERT INTO construction_etab (joueur, etablissement, post, temps, id_planete,gold,titane,cristal,orinia) VALUES (?,?,?,?,?,?,?,?,?)');
						$req_up_construc->execute(array($id_membre,$post,$post,$delai , $planete_utilise,$prix_gold,$prix_titane,$prix_cristal,$prix_orinia));

						$_SESSION['id_etab']=strip_tags($_POST['id_cache']);
						
						$_SESSION['error']='<p class="green">Amélioration en cours.</p>';
				}
				else		
					$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de ressources en stock.</p>';

		}
		else
			$_SESSION['error'] = '<p class="red">Construction déjà en cours.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';
header('Location: '.pathView().'etablissements/etab_laboratoire_defense.php');
?>

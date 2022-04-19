<?php 
	
if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
		
	if(!empty($_POST['id_cache'])) 
	{ 		
		if(is_numeric($_POST['nb_objet'])) 
		{ 
	
		$id_cache = strip_tags($_POST['id_cache']);
		
		$req_ress_dispo=$bdd->prepare("SELECT * FROM ressource WHERE id_planete = ? ");  /*récupère la liste des ressources du joueur */
		$req_ress_dispo->execute(array($planete_utilise));
		$ressource_disponible=$req_ress_dispo->fetch();
		
		//OBJET ont récupère les infos
		$r=$bdd->prepare('SELECT * FROM objet WHERE id = ?'); 
		$r->execute(array($id_cache));
		$prix_objet=$r->fetch();
		
		//OBJET ont récupère les infos
		$a=$bdd->prepare('SELECT * FROM objet_joueur WHERE id_objet = ? AND id_planete = ?'); 
		$a->execute(array($id_cache,$planete_utilise));
		$OBJ=$a->fetch();
		
		$objet_possede = htmlentities($OBJ['objet_possede']); 

		$prix_gold=htmlentities($prix_objet['prix_gold']);
		$prix_orinium=htmlentities($prix_objet['prix_orinium']);
		$nombre_demande=strip_tags($_POST['nb_objet']); // recupere le nombre d'objet envoyé dans le post
		
		
		$goldstock = htmlentities($ressource_disponible['gold']);
		$oriniumstock = htmlentities($ressource_disponible['orinium']);
		
		$nom = htmlentities($prix_objet['nom_objet']);

		$tem = htmlentities($prix_objet['temps']);
		$temps1=$tem * $nombre_demande; 
		$temps = time() + $temps1;
		
		
		if ($nombre_demande >= 0) 
			{													// Permet de vérifier qu'il n'entre pas un nombre négatif
				if ($objet_possede > 0)
					{
						$valeur_achat_or = $prix_gold*$nombre_demande;												// Permet de calculer le nombre d'or pour l'achat total
						$valeur_achat_orinium = $prix_orinium*$nombre_demande;
						
						if (($goldstock >= $valeur_achat_or) AND ($oriniumstock >= $valeur_achat_orinium)) // Permet de vérifier que ses stocks soit sup à la demande d'achat d'or
						{	
						
						//On ajoute les objets dans la liste
						$D=$bdd->prepare('INSERT INTO construction_objet (id_membre,id_planete,nom_unite,nombre_formation,temps,id_objet,gold,orinium) VALUES(?,?,?,?,?,?,?,?)');
						$D->execute(array($id_membre,$planete_utilise,$nom,$nombre_demande,$temps,$id_cache,$prix_gold,$prix_orinium));
						
							//RESSOURCES
							$req_achat=$bdd->prepare('UPDATE ressource SET gold = gold-?, orinium = orinium-? WHERE id_planete = ?');
							$req_achat->execute(array($valeur_achat_or,$valeur_achat_orinium,$planete_utilise));
							
							$point_gold=$valeur_achat_or/1000;
							$req_up_point_gold=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
							$req_up_point_gold->execute(array($point_gold,$id_membre));
							
							$point_orinium=$valeur_achat_orinium/1000;
							$req_up_point_orinium=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
							$req_up_point_orinium->execute(array($point_orinium,$id_membre));
							
							//AJOUT DES POINTS EVENEMENTS

							$point_total=$point_gold+$point_orinium;

							$aj_pts_ev=$bdd->prepare('UPDATE point_evenement SET nombre_point = nombre_point+?');
							$aj_pts_ev->execute(array($point_total));

							
							$_SESSION['error'] = '<p class="green">Achat effectuée.</p>';
						
						}
						else
							$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de ressources en stock.</p>';
				}
				else
				$_SESSION['error'] = '<p class="red"> Vous n\'avez pas débloqué cet objet.</p>';
			}
			else
				$_SESSION['error']='<p class="red">Impossible de mettre un nombre négatif.</p>';
		}
		else
			$_SESSION['error'] = '<p class="red">Vous devez et ne pouvez mettre qu\'un chifre ou un nombre.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';		
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'objet/objet_constructible.php');

?>
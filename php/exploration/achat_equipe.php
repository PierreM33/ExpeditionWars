<?php 


if($_POST)
{
require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']); 

	
	if(!empty($_POST['id_cache'])) 
	{ 
		$id_equipe=strip_tags($_POST['id_cache']);

			$req_ress=$bdd->prepare("SELECT * FROM ressource WHERE id_planete = ? ");
			$req_ress->execute(array($planete_utilise));
			$ressource=$req_ress->fetch();

			$pop=$bdd->prepare('SELECT * FROM population WHERE id_planete = ? '); 
			$pop->execute(array($planete_utilise));
			$population=$pop->fetch();
			
			$eq=$bdd->prepare('SELECT * FROM equipe_exploration WHERE id = ? '); 
			$eq->execute(array($id_equipe));
			$equipe=$eq->fetch();
			
			$eqj=$bdd->prepare('SELECT * FROM equipe_exploration_joueur WHERE id_equipe = ? AND id_planete = ?'); 
			$eqj->execute(array($id_equipe,$planete_utilise));
			$equipej=$eqj->fetch();
			
			//ON RECUPERE LA FACTION DU JOUEUR
			$faction=$bdd->prepare('SELECT * FROM faction_joueur WHERE id_membre = ? ');
			$faction->execute(array($id_membre));
			$Fact=$faction->fetch();

			//ON RECUPERE ENSUITE LES LOIS ADOPTE DE CETTE FACTION POUR RECUPERER LA PRODUCTION SUPPLEMENTAIRE
			$faction_loi=$bdd->prepare('SELECT * FROM faction_loi WHERE faction = ? AND adopte = ? AND numero = ?');
			$faction_loi->execute(array(htmlentities($Fact['nom_faction']),1,5));
			$Fa_L=$faction_loi->fetch();

			
			
			// REDEFINIR VARIABLE //
			$unite_possede=htmlentities($equipej['unite_possede']);

			$delai=(time()+$temps);
			$prix_gold=htmlentities($equipe['prix_gold']);
			$prix_titane=htmlentities($equipe['prix_titane']);
			$prix_cristal=htmlentities($equipe['prix_cristal']);
			$nombre_soldat=htmlentities($equipe['soldat']);
			$nombre_chercheur=htmlentities($equipe['chercheur']);
								
			$goldstock=htmlentities($ressource['gold']);
			$titanestock=htmlentities($ressource['titane']);
			$cristalstock=htmlentities($ressource['cristal']);
			$oriniastock=htmlentities($ressource['orinia']);
			$oriniumstock=htmlentities($ressource['orinium']);
			$organiquestock=htmlentities($ressource['organique']);

			$soldat_preforme=htmlentities($population['soldat']);
			$chercheur_preforme=htmlentities($population['chercheur']);
			
			$nom = htmlentities($equipe['nom']);

			$nombre_demande = 1;
			
						//ON RAJOUTE LE POURCENTAGE DE PRODUCTION DE LA FACTION
			if(htmlentities($Fa_L['effet']) == "temps-50%")
			{
			$tem = htmlentities($equipe['temps'])*50/100;

			}
			else
			{
						$tem=htmlentities($equipe['temps']);

			}

			$temps1=$tem * $nombre_demande; 
			$temps = time() + $temps1;
			
			if($unite_possede > 0)
			{
				if ($chercheur_preforme >= $nombre_chercheur AND $soldat_preforme >= $nombre_soldat) 					// Permet de vérifier qu'il possède assez de chercheur. Sinon erreur.	
					{																					
						if (($goldstock >= $prix_gold) AND ($titanestock >= $prix_titane) AND ($cristalstock >= $prix_cristal))
						{	
							$stock_chercheur_preforme=$chercheur_preforme-$nombre_chercheur;					// CALCUL NOUVEAU CHERCHEURS
							$stock_soldat_preforme=$soldat_preforme-$nombre_soldat;
							
							$req_deduction_chercheur_preforme=$bdd->prepare("UPDATE population SET chercheur = ?, soldat = ? WHERE id_planete = ?");
							$req_deduction_chercheur_preforme->execute(array($stock_chercheur_preforme,$stock_soldat_preforme,$planete_utilise));


							// UPDATE DES RESSOURCES
							$req_achat=$bdd->prepare('UPDATE ressource SET gold = gold-?, titane = titane-?, cristal = cristal-? WHERE id_planete = ? AND id_membre = ? ');
							$req_achat->execute(array($prix_gold,$prix_titane, $prix_cristal, $planete_utilise, $id_membre));

							// SYSTEME DE POINTS

							$point_gold=$prix_gold/1000;
							$point_titane=$prix_titane/1000;
							$point_cristal=$prix_cristal/1000;
							
							
							$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
							$req->execute(array($point_gold,$id_membre));
							
							$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
							$req->execute(array($point_titane,$id_membre));
							
							$req=$bdd->prepare('UPDATE membre SET point= point+? WHERE id= ?');
							$req->execute(array($point_cristal,$id_membre));
							
							//AJOUT DES POINTS EVENEMENTS

							$point_total=$point_gold+$point_titane;

							$aj_pts_ev=$bdd->prepare('UPDATE point_evenement SET nombre_point = nombre_point+?');
							$aj_pts_ev->execute(array($point_total));


							//On ajoute les defenses dans la table de defenses en attente du temps
							$D=$bdd->prepare('INSERT INTO construction_equipe (id_membre,id_planete,nom_unite,nombre_formation,temps,id_equipe) VALUES(?,?,?,?,?,?)');
							$D->execute(array($id_membre,$planete_utilise,$nom,$nombre_demande,$temps,$id_equipe));

							$_SESSION['error'] = '<p class="green">Achat effectuée.</p>';

							}
							else
								$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de ressources en stock.</p>';
						}
						else
							$_SESSION['error']='<p class="red">Vous n\'avez pas assez de chercheurs ou de soldats.</p>';
					}
					else
						$_SESSION['error'] = '<p class="red"> Vous n\'avez pas débloqué cette unité </p>';
			}
			else
				$_SESSION['error'] = '<p class="red">Tous les champs ne sont pas remplis.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

	
header('Location: '.pathView().'exploration/equipe_exploration.php');			

?>
<?php 

	
// POUR LA PARTIE GENERAL OU COMMUNE (meme chose) ON VA RETIRER DES CIVILS ET NON DES SOLDATS	
if($_POST)
{
		require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);
	
	if(!empty($_POST['id_cache']))
	{ 		
		if(is_numeric($_POST['nb_troupe'])) 
		{ 
	
			$id_cache = strip_tags($_POST['id_cache']);
	
		$req_ress_dispo=$bdd->prepare("SELECT * FROM ressource WHERE id_planete = ? ");  
		$req_ress_dispo->execute(array($planete_utilise));
		$ressource_disponible=$req_ress_dispo->fetch();

		$req_aff_pop=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?'); 
		$req_aff_pop->execute(array($planete_utilise));
		$a_p_d=$req_aff_pop->fetch();
		
		$prix=$bdd->prepare('SELECT * FROM caserne WHERE id = ?');
		$prix->execute(array($id_cache));
		$prix_achat=$prix->fetch();
		
		$c=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_caserne = ? AND id_planete = ?');
		$c->execute(array($id_cache,$planete_utilise));
		$cas_j=$c->fetch();
		
		$nom = htmlentities($prix_achat['nom_unite']);
		$prix_gold=htmlentities($prix_achat['prix_gold']);
		$prix_titane=htmlentities($prix_achat['prix_titane']);
		$prix_orinia=htmlentities($prix_achat['prix_orinia']);
		$nombre_demande=htmlentities($_POST['nb_troupe']);

		//ON RECUPERE LA FACTION DU JOUEUR
		$faction=$bdd->prepare('SELECT * FROM faction_joueur WHERE id_membre = ? ');
		$faction->execute(array($id_membre));
		$Fact=$faction->fetch();
		
		//ON RECUPERE ENSUITE LES LOIS ADOPTE DE CETTE FACTION POUR RECUPERER LA PRODUCTION SUPPLEMENTAIRE
		$faction_loi=$bdd->prepare('SELECT * FROM faction_loi WHERE faction = ? AND adopte = ? AND numero = ?');
		$faction_loi->execute(array(htmlentities($Fact['nom_faction']),1,3));
		$Fa_L=$faction_loi->fetch();
		

					//ON RAJOUTE LE POURCENTAGE DE PRODUCTION DE LA FACTION
			if(htmlentities($Fa_L['effet']) == "temps-15%")
			{
					$tempsX = htmlentities($prix_achat['temps'])*15/100;
					$tem = $prix_achat['temps'] - $tempsX;
			}
			else
			{
							$tem = htmlentities($prix_achat['temps']);

			}
			
		
		$civil_preforme = htmlentities($a_p_d['civil']);
		$goldstock = htmlentities($ressource_disponible['gold']);
		$titanestock = htmlentities($ressource_disponible['titane']);
		$oriniastock = htmlentities($ressource_disponible['orinia']);
		$unite_possede = htmlentities($cas_j['unite_possede']);

		$temps1=$tem * $nombre_demande; 
		$temps = time() + $temps1;
		
		//On va voir si une liste est en attente

		
		
if($unite_possede > 0)
	{
			if ($nombre_demande >= 0) {													// Permet de vérifier qu'il n'entre pas un nombre négatif

				if ($civil_preforme >= $nombre_demande) {																// Permet de vérifier qu'il possède assez de soldat		
							$valeur_achat_or = $prix_gold*$nombre_demande;												// Permet de calculer le nombre d'or pour l'achat total
							$valeur_achat_titane = $prix_titane*$nombre_demande;
							$valeur_achat_orinia = $prix_orinia*$nombre_demande;
							
							if (($goldstock >= $valeur_achat_or) AND ($titanestock >= $valeur_achat_titane) AND ($oriniastock >= $valeur_achat_orinia)) // Permet de vérifier que ses stocks soit sup à la demande d'achat d'or
							{	
							
								$D=$bdd->prepare('INSERT INTO construction_caserne (id_membre,id_planete,nom_unite,nombre_formation,temps,id_caserne) VALUES(?,?,?,?,?,?)');
								$D->execute(array($id_membre,$planete_utilise,$nom,$nombre_demande,$temps,$id_cache));
								
								
								$stock_civil_preforme = $civil_preforme-$nombre_demande;					
								
								// CALCUL DISPONIBILITE SOLDATS
								$req_deduction_soldat_preforme=$bdd->prepare("UPDATE population SET civil = $stock_civil_preforme WHERE id_planete = ?");
								$req_deduction_soldat_preforme->execute(array($planete_utilise));
								

								//RESSOURCES
								$req_achat=$bdd->prepare('UPDATE ressource SET gold = gold-?, titane = titane-?, orinia = orinia-? WHERE id_planete = ?');
								$req_achat->execute(array($valeur_achat_or,$valeur_achat_titane,$valeur_achat_orinia,$planete_utilise));
								
								
								$point_gold=$valeur_achat_or/1000;
								$req_up_point_gold=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
								$req_up_point_gold->execute(array($point_gold,$id_membre));
								
								$point_titane=$valeur_achat_titane/1000;
								$req_up_point_t=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
								$req_up_point_t->execute(array($point_titane,$id_membre));
								
								$point_orinia=$valeur_achat_orinia/1000;
								$req_up_point_orinia=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
								$req_up_point_orinia->execute(array($point_orinia,$id_membre));
								
															//AJOUT DES POINTS EVENEMENTS

								$point_total=$point_gold+$point_titane+$point_orinia;

								$aj_pts_ev=$bdd->prepare('UPDATE point_evenement SET nombre_point = nombre_point+?');
								$aj_pts_ev->execute(array($point_total));
								
								
								$_SESSION['error'] = '<p class="green">Achat effectuée.</p>';
								
								}
								else
									$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de ressources en stock.</p>';
						}
						else
							$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de civils préformé.</p>';
				}
				else
					$_SESSION['error']='<p class="red">Impossible de mettre un nombre négatif.</p>';
			}
			else
			$_SESSION['error'] = '<p class="red">Vous n\'avez pas débloqué l\'unité.</p>';
		}
		else
			$_SESSION['error'] = '<p class="red">Vous devez et ne pouvez mettre qu\'un chifre ou un nombre.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';		
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'caserne/caserne_general.php');

?>
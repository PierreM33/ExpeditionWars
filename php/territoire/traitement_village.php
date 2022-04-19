<?php

if($_POST['accepter'])
{

		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
		$id_membre=htmlentities($_SESSION['id']); 

		$req=$bdd->prepare('SELECT * FROM ressource WHERE id_planete = ? AND id_membre = ?');  // récupère la liste des ressources du joueur 
		$req->execute(array($planete_utilise,$id_membre));
		$ressource_disponible=$req->fetch();
		
		// RECUPERE infrastructure
		$in=$bdd->prepare('SELECT * FROM infrastructure WHERE id_planete = ? AND id_membre=?'); // RECUPERE LES INFOS DE STOCK
		$in->execute(array($planete_utilise,$id_membre));
		$infrastructure=$in->fetch();
		

		$goldstock=htmlentities(htmlspecialchars($ressource_disponible['gold']));
		$titanestock=htmlentities(htmlspecialchars($ressource_disponible['titane']));
		$cristalstock=htmlentities(htmlspecialchars($ressource_disponible['cristal']));
		$oriniastock=htmlentities(htmlspecialchars($ressource_disponible['orinia']));
		$oriniumstock=htmlentities(htmlspecialchars($ressource_disponible['orinium']));
		
		
		
		//On vérifie les stocks de ressources et ensuite on les retitent
			if (($goldstock >= $infrastructure['gold']) AND ($titanestock >= $infrastructure['titane']) AND ($oriniastock >= $infrastructure['orinia']) AND ($cristalstock >= $infrastructure['cristal']) AND ($oriniumstock >= $infrastructure['orinium']))
			{

					// Soustrait les ressources
					$Upbdd=$bdd->prepare('UPDATE ressource SET gold = gold-?, titane = titane-?, cristal=cristal-?, orinia=orinia-?, orinium=orinium-? WHERE id_planete = ? AND id_membre = ? ');
					$Upbdd->execute(array($infrastructure['gold'],$infrastructure['titane'],$infrastructure['cristal'],$infrastructure['orinia'],$infrastructure['orinium'],$planete_utilise,$id_membre));
					
					
					// Améliore de 1000 le nombre de population
					// Augmentation du prix du prochain niveau
					// Augmentation niveau
					$reqt= $bdd->prepare('UPDATE infrastructure SET niveau = niveau+?, limite = limite+?, gold = gold*?, titane = titane*?, cristal=cristal*?, orinia=orinia*?, orinium=orinium*? WHERE id_planete = ? AND id_membre = ? ');
					$reqt->execute(array(1,1000,1.2,1.2,1.2,1.2,1.2,$planete_utilise,$id_membre));
										// Si le village est de niveau 3 il passe en Ville etc..
					if(htmlentities(htmlspecialchars($infrastructure['niveau'])) == 3)
					{
						$ville = "Ville";
					$reqt= $bdd->prepare('UPDATE infrastructure SET nom=? WHERE id_planete = ? AND id_membre = ? ');
					$reqt->execute(array(utf8_encode($ville),$planete_utilise,$id_membre));	
					}
					elseif(htmlentities(htmlspecialchars($infrastructure['niveau'])) == 5)
					{
						$cite = "Cité";
					$reqt= $bdd->prepare('UPDATE infrastructure SET nom=? WHERE id_planete = ? AND id_membre = ? ');
					$reqt->execute(array(utf8_encode($cite),$planete_utilise,$id_membre));	
					}
					elseif(htmlentities(htmlspecialchars($infrastructure['niveau'])) == 8)
					{
						$met = "Métropole";
					$reqt= $bdd->prepare('UPDATE infrastructure SET nom=? WHERE id_planete = ? AND id_membre = ? ');
					$reqt->execute(array(utf8_encode($met),$planete_utilise,$id_membre));	
					}
					elseif(htmlentities(htmlspecialchars($infrastructure['niveau'])) >= 12)
					{
					$Mega_met = "Méga Métropole";
					$reqt= $bdd->prepare('UPDATE infrastructure SET nom=? WHERE id_planete = ? AND id_membre = ? ');
					$reqt->execute(array(utf8_encode($Mega_met),$planete_utilise,$id_membre));	
					}
					
					// AJOUT DES POINTS
					$point_gold=htmlentities(htmlspecialchars($infrastructure['gold']))/1000;
					$req_up_point_gold=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
					$req_up_point_gold->execute(array($point_gold,$id_membre));

					$point_titane=htmlentities(htmlspecialchars($infrastructure['titane']))/1000;
					$req_up_point_t=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
					$req_up_point_t->execute(array($point_titane,$id_membre));
					
					$point_cristal=htmlentities(htmlspecialchars($infrastructure['cristal']))/1000;
					$req_up_point_c=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
					$req_up_point_c->execute(array($point_cristal,$id_membre));
					
					$point_orinia=htmlentities(htmlspecialchars($infrastructure['orinia']))/1000;
					$req_up_point_orinia=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
					$req_up_point_orinia->execute(array($point_orinia,$id_membre));
					
					$point_orinium=htmlentities(htmlspecialchars($infrastructure['orinium']))/1000;
					$req_up_point_o=$bdd->prepare('UPDATE membre SET point = point+? WHERE id = ?');
					$req_up_point_o->execute(array($point_orinium,$id_membre));
					
									
					// QUETE NUMERO 3
					$rq=$bdd->prepare('SELECT * FROM quete WHERE id_membre = ? AND numero_quete = ? '); 
					$rq->execute(array($id_membre,3));
					$quete_fini=$rq->fetch();

					if($quete_fini['valide'] == 0)
					{
					$req=$bdd->prepare('UPDATE quete SET valide=? WHERE id_membre= ? AND numero_quete = ?');
					$req->execute(array(1,$id_membre,3));
					}
					

					$_SESSION['error'] = '<p class="green">Votre population maximum &agrave; &eacute;t&eacute; agrandi.</p>';
			}
			else
			$_SESSION['error'] = '<p class="red">Vous ne poss&eacute;dez pas assez de ressources.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';
	
header('Location: '.pathView().'sdc/salle_de_controle.php');

?>
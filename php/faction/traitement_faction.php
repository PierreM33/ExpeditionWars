<?php


if($_POST)
	{
	require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
				
		//Recupération du pseudo grace a l'id du membre
		$mbr=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
		$mbr->execute(array($id_membre));
		$mb=$mbr->fetch();
		
		// QUETE NUMERO 5
			$rq=$bdd->prepare('SELECT * FROM quete WHERE id_membre = ? AND numero_quete = ? '); 
			$rq->execute(array($id_membre,5));
			$quete_fini=$rq->fetch();
			
			if($quete_fini['quete_fini'] == 0)
			{
		$req=$bdd->prepare('UPDATE quete SET valide=? WHERE id_membre= ? AND numero_quete = ?');
		$req->execute(array(1,$id_membre,5));
			}
	
		if($_POST['independant'])
		{
				
				//On update les membre de la faction
				$r=$bdd->prepare('INSERT INTO faction_joueur (nom_faction,image,pseudo_membre,titre,id_membre,rang,nom_rang,faction_possede,nombre_de_voix,elu,vote_effectue,vote_du_joueur,date_arrive) VALUES(?,?,?, ?,?,?, ?,?,?, ?,?,?, NOW())');
				$r->execute(array(strip_tags($_POST['independant']),"banniere_independant.png",$mb['pseudo'],$mb['titre'],$id_membre,1,"Simple Membre",1,0,0,"Non","Aucun"));
				
				
				$chat=$bdd->prepare('INSERT INTO chat_joueur_faction(id_membre,pseudo,message) VALUES(?,?,?)');
				$chat->execute(array($id_membre,$mb['pseudo'],0));
				
				
				header('Location: '.pathView().'./faction/faction.php');
			
				}
				elseif($_POST['mercenaire'])
				{

				
						//On update les membre de la faction
				$r=$bdd->prepare('INSERT INTO faction_joueur (nom_faction,image,pseudo_membre,titre,id_membre,rang,nom_rang,faction_possede,nombre_de_voix,elu,vote_effectue,vote_du_joueur,date_arrive) VALUES(?,?,?, ?,?,?, ?,?,?, ?,?,?, NOW())');
				$r->execute(array(strip_tags($_POST['mercenaire']),"banniere_mercenaire.png",$mb['pseudo'],$mb['titre'],$id_membre,1,"Simple Membre",1,0,0,"Non","Aucun"));
				
				$chat=$bdd->prepare('INSERT INTO chat_joueur_faction(id_membre,pseudo,message) VALUES(?,?,?)');
				$chat->execute(array($id_membre,$mb['pseudo'],0));
				
				header('Location: '.pathView().'./faction/faction.php');
			
				}
				elseif($_POST['coalition'])
				{
				
						//On update les membre de la faction
				$r=$bdd->prepare('INSERT INTO faction_joueur (nom_faction,image,pseudo_membre,titre,id_membre,rang,nom_rang,faction_possede,nombre_de_voix,elu,vote_effectue,vote_du_joueur,date_arrive) VALUES(?,?,?, ?,?,?, ?,?,?, ?,?,?, NOW())');
				$r->execute(array(strip_tags($_POST['coalition']),"banniere_coalition.png",$mb['pseudo'],$mb['titre'],$id_membre,1,"Simple Membre",1,0,0,"Non","Aucun"));
				
								$chat=$bdd->prepare('INSERT INTO chat_joueur_faction(id_membre,pseudo,message) VALUES(?,?,?)');
				$chat->execute(array($id_membre,$mb['pseudo'],0));
				
				header('Location: '.pathView().'./faction/faction.php');
			
				}
				elseif($_POST['rebelle'])
				{
				
				$r=$bdd->prepare('INSERT INTO faction_joueur (nom_faction,image,pseudo_membre,titre,id_membre,rang,nom_rang,faction_possede,nombre_de_voix,elu,vote_effectue,vote_du_joueur,date_arrive) VALUES(?,?,?, ?,?,?, ?,?,?, ?,?,?, NOW())');
				$r->execute(array(strip_tags($_POST['rebelle']),"banniere_rebelle.png",$mb['pseudo'],$mb['titre'],$id_membre,1,"Simple Membre",1,0,0,"Non","Aucun"));
				
								$chat=$bdd->prepare('INSERT INTO chat_joueur_faction(id_membre,pseudo,message) VALUES(?,?,?)');
				$chat->execute(array($id_membre,$mb['pseudo'],0));
				
				header('Location: '.pathView().'./faction/faction.php');
			
				}
				elseif($_POST['legion'])
				{
				
				$r=$bdd->prepare('INSERT INTO faction_joueur (nom_faction,image,pseudo_membre,titre,id_membre,rang,nom_rang,faction_possede,nombre_de_voix,elu,vote_effectue,vote_du_joueur,date_arrive) VALUES(?,?,?, ?,?,?, ?,?,?, ?,?,?, NOW())');
				$r->execute(array(strip_tags($_POST['legion']),"banniere_legion.png",$mb['pseudo'],$mb['titre'],$id_membre,1,"Simple Membre",1,0,0,"Non","Aucun"));
				
								$chat=$bdd->prepare('INSERT INTO chat_joueur_faction(id_membre,pseudo,message) VALUES(?,?,?)');
				$chat->execute(array($id_membre,$mb['pseudo'],0));
				
				header('Location: '.pathView().'./faction/faction.php');
			
				}
	

	
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./faction/liste_faction.php');
	?>
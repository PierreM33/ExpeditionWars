<?php



if($_POST)
	{			
 require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

 //on protège le variable
 				$id_vaisseau = strip_tags($_POST['numero_chasseur']);
								$id_vaisseau_hote = strip_tags($_POST['numero_vaisseau_hote']);
				

				//On sécurise le fait que ce soit bien un nombre entrer
 if(is_numeric($id_vaisseau) AND is_numeric($id_vaisseau_hote))
 {
	 

		//RECUPERE VAISSEAU JOUEUR CHASSEUR
		$cha=$bdd->prepare("SELECT * FROM vaisseau_chasseur_embarque WHERE id_planete = ? AND gabarit = ? AND id_vaisseau= ?");
		$cha->execute(array($planete_utilise,1,$id_vaisseau));
		$c=$cha->fetch();


				$id_planete_origine = htmlentities($c['id_planete']);
				$nom_vaisseau =  htmlentities($c['nom_vaisseau']);
				$surnom = htmlentities($c['surnom']);
				$attaque = htmlentities($c['attaque']);
				$defense = htmlentities($c['defense']);
				$bouclier = htmlentities($c['bouclier']);
				$vitesse = htmlentities($c['vitesse']);
				$type = htmlentities($c['type']);
				$gabarit = htmlentities($c['gabarit']);
				$fret = htmlentities($c['fret']);
				$poid = htmlentities($c['poid']);


				//on va récuperer les informations des vaisseaux_joueur pour débarquer les vaisseaux sur la bonne planète en fonction de l'hote
				$req=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id = ?');
				$req->execute(array($id_membre,$planete_utilise,$id_vaisseau_hote));
				$REC=$req->fetch();
				
				$position_x = $REC['x'];
				$position_y = $REC['y'];
				$systeme = $REC['systeme'];
				
				
				//On ajoute le vaisseau dans la liste du joueur
				$rec=$bdd->prepare('INSERT INTO vaisseau_joueur(nom_vaisseau, surnom, attaque, defense, bouclier, vitesse, type, gabarit, poid, fret, chasseur, limite_chasseur, objet_un, objet_deux, nombre_objet_un, nombre_objet_deux, id_membre, id_planete, id_hangar, stock_gold, stock_titane, stock_cristal, stock_orinia, stock_orinium, stock_organique,systeme,x,y,id_action,id_vaisseau_hote) VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,? ,?,?,?,?,?)');
				$rec->execute(array($nom_vaisseau, $surnom, $attaque, $defense, $bouclier, $vitesse, $type, $gabarit, $poid, $fret,0,0,"Aucun","Aucun",0,0,$id_membre, $planete_utilise,1,0,0,0,0,0,0,$systeme,$position_x,$position_y,0,0));
				
				//Retire le vaisseau de la liste de selection
				$delete_vaisseau=$bdd->prepare('DELETE FROM vaisseau_chasseur_embarque WHERE id_membre = ? AND id_planete = ? AND id_vaisseau = ?');
				$delete_vaisseau->execute(array($id_membre,$planete_utilise,$id_vaisseau));
				
				//Retire dans le vaisseau -1 dans les places disponible
				$aga=$bdd->prepare('UPDATE vaisseau_joueur SET chasseur = chasseur - ? WHERE id_membre = ? AND id_planete = ? AND id = ?');
				$aga->execute(array(1,$id_membre,$planete_utilise,$id_vaisseau_hote));
				
				$_SESSION['error'] = '<p class="green"> Vaisseau d&eacute;barqu&eacute; sur la plan&egrave;te.</p>';
			
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';
		
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./flotte/embarquement.php');
	?>
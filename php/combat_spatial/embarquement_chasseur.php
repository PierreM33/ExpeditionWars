<?php


//RECUPERE VAISSEAU JOUEUR CHASSEUR

$select=$bdd->prepare('SELECT * FROM vaisseau_selection WHERE id_membre = ? AND planete_vise = ? ');
		$select->execute(array($id_membre,$ennemi_id));
		while($r=$select->fetch())
		{
				$id_vaisseau_hote = $r['id_vaisseau'];
				
			$cha=$bdd->prepare("SELECT * FROM vaisseau_selection WHERE id_planete = ? AND gabarit = ? AND id_vaisseau_hote= ?");
			$cha->execute(array($planete_utilise,1,$r['id_vaisseau']));
			while($c=$cha->fetch())
			{


				$numero_planete_vise = $ennemi_id;
				$id_vaisseau = htmlentities($c['id_vaisseau']);
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
				
				

				//A VOIR ID VAISSEAU HOTE SINON APRES COMBAT LES VAISSEAUX NE RETOURNE PAS D'EUX MEME DANS LES VAISSEAUX.
				
				//On ajoute le vaisseau dans la liste des vaisseaux qui combattent
				$rec=$bdd->prepare('INSERT INTO vaisseau_chasseur_embarque(id_vaisseau, id_membre, id_planete_origine, id_vaisseau_hote, nom_vaisseau, surnom, attaque, defense, bouclier, vitesse, type, gabarit, poid) VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?)');
				$rec->execute(array($id_vaisseau, $id_membre, $id_planete_origine, $id_vaisseau_hote, $nom_vaisseau, $surnom, $attaque, $defense, $bouclier, $vitesse, $type, $gabarit, $poid));
				
				//Retire le vaisseau de la liste de selection
				$delete_vaisseau=$bdd->prepare('DELETE FROM vaisseau_chasseur_embarque WHERE id_membre = ? AND id_planete = ? AND id_vaisseau = ?');
				$delete_vaisseau->execute(array($id_membre,$planete_utilise,$id_vaisseau));
				
			
				
			}
		}
?>
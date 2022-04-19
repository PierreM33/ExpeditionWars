<?php


//RECUPERE VAISSEAU JOUEUR CHASSEUR

		$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ?');
		$select->execute(array($id_membre_attaquant,$id_action));
		while($r=$select->fetch())
		{
		
			//ID DU VAISSEAU HOTE
			$id_vaisseau_hote = $r['id'];
			
			//ON VA UPDATE LES CHASSEURS POUR QU'ILS PARTICIPENT AU COMBAT
			$ChasseurCombat=$bdd->prepare('UPDATE vaisseau_joueur SET id_action = ?  WHERE id_vaisseau_hote = ? AND id_action = ?');
			$ChasseurCombat->execute(array($id_action,$id_vaisseau_hote,0));
				

		}
		
		
		
						/*
			$cha=$bdd->prepare("SELECT * FROM vaisseau_chasseur_embarque WHERE id_planete = ? AND gabarit = ? AND id_vaisseau_hote= ?");
			$cha->execute(array($id_planete_attaquant,1,$id_vaisseau_hote));
			while($c=$cha->fetch())
			{


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
				
								//on va récuperer les informations des vaisseaux_joueur pour débarquer les vaisseaux sur la bonne planète en fonction de l'hote
				$req=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id = ?');
				$req->execute(array($id_membre_attaquant,$id_planete_attaquant,$id_vaisseau_hote));
				$REC=$req->fetch();
				
				$position_x = $REC['x'];
				$position_y = $REC['y'];
				$systeme = $REC['systeme'];
				
				
				//On ajoute le vaisseau dans la liste du joueur
				$rec=$bdd->prepare('INSERT INTO vaisseau_joueur(nom_vaisseau, surnom, attaque, defense, bouclier, vitesse, type, gabarit, poid, fret, chasseur, limite_chasseur, objet_un, objet_deux, nombre_objet_un, nombre_objet_deux, id_membre, id_planete, id_hangar, stock_gold, stock_titane, stock_cristal, stock_orinia, stock_orinium, stock_organique,systeme,x,y,id_action,id_vaisseau_hote) VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,? ,?,?,?,?,?)');
				$rec->execute(array($nom_vaisseau, $surnom, $attaque, $defense, $bouclier, $vitesse, $type, $gabarit, $poid, $fret,0,0,"Aucun","Aucun",0,0,$id_membre_attaquant, $id_planete_attaquant,1,0,0,0,0,0,0,$systeme,$position_x,$position_y,$id_action,0));

				//Retire le vaisseau de la liste de selection
				$delete_vaisseau=$bdd->prepare('DELETE FROM vaisseau_chasseur_embarque WHERE id_membre = ? AND id_planete = ? AND id_vaisseau = ?');
				$delete_vaisseau->execute(array($id_membre_attaquant,$id_planete_attaquant,$id_vaisseau));
				
				//Retire dans le vaisseau -1 dans les places disponible
				$aga=$bdd->prepare('UPDATE vaisseau_joueur SET chasseur = chasseur - ? WHERE id_membre = ? AND id_planete = ? AND id = ?');
				$aga->execute(array(1,$id_membre,$planete_utilise,$id_vaisseau_hote));
				

				
			
				
			}*/
?>
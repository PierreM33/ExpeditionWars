<?php

//RECUPERE VAISSEAU JOUEUR CHASSEUR
$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? ');
		$select->execute(array($id_membre_defenseur,$id_planete_defenseur));
		while($r=$select->fetch())
		{
				$id_vaisseau_hote = $r['id'];

			$cha=$bdd->prepare("SELECT * FROM vaisseau_chasseur_embarque WHERE id_planete = ? AND gabarit = ? AND id_vaisseau_hote= ?");
			$cha->execute(array($id_planete_defenseur,1,$id_vaisseau_hote));
			while($c=$cha->fetch())
			{

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
				

				
				//On ajoute le vaisseau dans la liste des vaisseaux qui combattent
				//On ajoute le vaisseau dans la liste du joueur
				$rec=$bdd->prepare('INSERT INTO vaisseau_joueur(nom_vaisseau, surnom, attaque, defense, bouclier, vitesse, type, gabarit, poid, fret, chasseur, limite_chasseur, objet_un, objet_deux, nombre_objet_un, nombre_objet_deux, id_membre, id_planete, id_hangar, stock_gold, stock_titane, stock_cristal, stock_orinia, stock_orinium, stock_organique,systeme,x,y,id_action,id_vaisseau_hote) VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,? ,?,?,?,?,?)');
				$rec->execute(array($nom_vaisseau, $surnom, $attaque, $defense, $bouclier, $vitesse, $type, $gabarit, $poid, $fret,0,0,"Aucun","Aucun",0,0,$id_membre_defenseur, $id_planete_defenseur,1,0,0,0,0,0,0,$systeme,$position_x,$position_y,0,0));

				//Retire le vaisseau de la liste de selection
				$delete_vaisseau=$bdd->prepare('DELETE FROM vaisseau_chasseur_embarque WHERE id_membre = ? AND id_planete = ? AND id_vaisseau = ?');
				$delete_vaisseau->execute(array($id_membre_defenseur,$id_planete_defenseur,$id_vaisseau));
				
			
				
			}
		}
?>
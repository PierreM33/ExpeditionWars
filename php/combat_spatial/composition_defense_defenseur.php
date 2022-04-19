<?php
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);



		$d=$bdd->prepare('SELECT def.id, def.nom_defense,def.attaque,def.defense,def.cadence_tir, defj.nombre_unite,defj.id_planete,defj.id_defense FROM defense AS def LEFT JOIN defense_joueur AS defj ON def.id=defj.id_defense WHERE defj.id_planete = ? AND defj.unite_possede=? ');
		$d->execute(array($id_planete_defenseur,1));
		while($defense_planete=$d->fetch())
		{
			

			
			$PointAttaqueTot = 0;
			$pointDefenseTot = 0;
			$cadence_tir_Tot = 0;
			
			$total_defense_defenseur = 0;
			
			// Liste caractéristique des défenses
			$nom_defense = htmlentities($defense_planete['nom_defense']);
			$nombre_unite = htmlentities($defense_planete['nombre_unite']);
			$attaque = htmlentities($defense_planete['attaque']);
			$defense = htmlentities($defense_planete['defense']);
			$cadence_tir = htmlentities($defense_planete['cadence_tir']);

			
			//Permet de mettre a zéro le chiffre de la défense.
			if($nombre_unite == "NULL")
			{
				
				$nombre_unite = 0;
				
			}
			
			
			// ATTAQUE ET DEFENSE TOTAL PAR CATEGORIE DE DEFENSE MULTIPLIÉ PAR LE NOMBRE D'UNITÉ QUE LE JOUEUR POSSÈDE
			$attaque_total_par_categorie=$attaque*$nombre_unite;
			$defense_total_par_categorie=$defense*$nombre_unite;
			
			
			//PAREIL POUR LE NOMBRE DE CIBLE MAX
			$cadence_tir_total_par_categorie = $cadence_tir*$nombre_unite;
			
			
			//TOTAL DE POINTS D'ATTAQUE ET DEFENSE DE TOUTES LES DEFENSES DU JOUEURS
			$PointAttaqueTot+=$attaque_total_par_categorie;
			$pointDefenseTot+=$defense_total_par_categorie;
			$cadence_tir_Tot+=$cadence_tir_total_par_categorie;

			
			$total_defense_defenseur+=$nombre_unite;
		
		}

		//INSERTION DANS LA BDD A CHAQUE TOUR DES DEFENSES DE LA PLANETE
$categorie='defense_planete';



?>

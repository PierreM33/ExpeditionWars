<?php
		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 1 : MINE OR
		$mine->execute(array($porte_connecte,1));
		$mine_o=$mine->fetch();
	
		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 2 : MINE TITANE
		$mine->execute(array($porte_connecte,2));
		$mine_t=$mine->fetch();

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 3 : MINE ORINIA
		$mine->execute(array($porte_connecte,3));
		$mine_c=$mine->fetch();

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 4 : MINE CRISTAL
		$mine->execute(array($porte_connecte,4));
		$mine_orinia=$mine->fetch();

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 5 : MINE ORINIUM
		$mine->execute(array($porte_connecte,5));
		$mine_orinium=$mine->fetch();

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 6 : MINE MATIERE ORGANIQUE
		$mine->execute(array($porte_connecte,6));
		$mine_org=$mine->fetch();
		
		// RECUPERE STOCK DE Ressources
		$ress=$bdd->prepare('SELECT * FROM ressource WHERE id_planete = ? AND id_membre = ?'); // RECUPERE LES INFOS DE STOCK
		$ress->execute(array($porte_connecte,$id_membre_cible));
		$r=$ress->fetch();
		
		// RECUPERE Population
		$pop=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?'); // RECUPERE LES INFOS DE STOCK
		$pop->execute(array($porte_connecte));
		$popu=$pop->fetch();

		
		//récupère la valeur de production de la race de base en BDD
		$rb=$bdd->prepare('SELECT * FROM production WHERE id = ? ');
		$rb->execute(array(1));
		$race_base=$rb->fetch();
		
		$valhar = "valhar";
		$orak = "orak";
		$humain = "humain";
		$droide = "droide";
		
				//Calcul de toute la population par planète
		$lst_pop = htmlentities(htmlspecialchars($popu['ouvrier'])) + htmlentities(htmlspecialchars($popu['esclave'])) + htmlentities(htmlspecialchars($popu['civil'])) + htmlentities(htmlspecialchars($popu['soldat'])) + htmlentities(htmlspecialchars($popu['chercheur'])) + htmlentities(htmlspecialchars($popu['pilote'])) + htmlentities(htmlspecialchars($popu['population']));
		$ouvrier_dans_mine = htmlentities(htmlspecialchars($mine_o['ouvrier'])) + htmlentities(htmlspecialchars($mine_t['ouvrier'])) + htmlentities(htmlspecialchars($mine_c['ouvrier'])) + htmlentities(htmlspecialchars($mine_orinia['ouvrier'])) + htmlentities(htmlspecialchars($mine_orinium['ouvrier'])) + htmlentities(htmlspecialchars($mine_org['ouvrier']));
		$esclave_dans_mine = htmlentities(htmlspecialchars($mine_o['esclave'])) + htmlentities(htmlspecialchars( $mine_t['esclave'])) + htmlentities(htmlspecialchars($mine_c['esclave'])) + htmlentities(htmlspecialchars($mine_orinia['esclave'])) + htmlentities(htmlspecialchars($mine_orinium['esclave'])) + htmlentities(htmlspecialchars($mine_org['esclave']));
		
		$pop_planete = $lst_pop + $ouvrier_dans_mine + $esclave_dans_mine ;
		

		//Si la population a atteind la limie alors on bloque la production.
		if($pop_planete >= htmlentities(htmlspecialchars($infrastructure['limite'])) )
		{
			$production_population = 0;
		}
		else
		{
			if(htmlentities(htmlspecialchars($ra['race'])) == $orak)
			{
			$production_population = htmlentities(htmlspecialchars($race_base['orak']));
			}
			elseif(htmlentities(htmlspecialchars($ra['race'])) == $valhar)
			{
			$production_population = htmlentities(htmlspecialchars($race_base['valhar']));
			}
			elseif(htmlentities(htmlspecialchars($ra['race'])) == $humain)
			{
			$production_population = htmlentities(htmlspecialchars($race_base['humain']));
			}
			elseif(htmlentities(htmlspecialchars($ra['race'])) == $droide)
			{
			$production_population = htmlentities(htmlspecialchars($race_base['droide']));
			}
		}
		
	$heureactuelle 								= time();
	$derniereActualisation 						= strtotime($r['temps']); // Récupération du temps depuis la dernière actualisation dans la BDD
	$derniereActualisationPopulation 			= strtotime($popu['temps']); // Récupération du temps depuis la dernière actualisation dans la BDD
	

	$production_base_or 				= 20; // Or produites par heure.
	$production_base_titane 			= 20; // Titane produites par heure.
	$production_base_cristal 			= 20; // Cristal produites par heure.
	$production_base_orinia 			= 20; // Orinia produites par heure.
	$production_base_orinium 			= 20; // Orinium produites par heure.
	$production_base_matiere_organique 	= 0; // Matière Organique produites par heure.
	
	// Si l'énergie est en dessous de 1.000 il produit 100 sinon 0
	if(htmlentities(htmlspecialchars($r['energie'])) < 1000)
	{	
	$production_energie					= 100; // Produit 100 energie par heure.
	}
	else
	{
	$production_energie					= 0; // Produit 0 energie par heure.	
	}
	
	
	$nombre_ouvrier_or					= htmlentities(htmlspecialchars($mine_o['ouvrier'])); // Récupération du nombre d'ouvrier de la mine d'or dans la BDD
	$nombre_ouvrier_titane				= htmlentities(htmlspecialchars($mine_t['ouvrier'])); // Récupération du nombre d'ouvrier de la mine de titane dans la BDD
	$nombre_ouvrier_cristal				= htmlentities(htmlspecialchars($mine_c['ouvrier'])); // Récupération du nombre d'ouvrier de la mine de cristal dans la BDD
	$nombre_ouvrier_orinia				= htmlentities(htmlspecialchars($mine_orinia['ouvrier'])); // Récupération du nombre d'ouvrier de la mine d'orinia dans la BDD
	$nombre_ouvrier_orinium				= htmlentities(htmlspecialchars($mine_orinium['ouvrier'])); // Récupération du nombre d'ouvrier de la mine d'orinium dans la BDD
	$nombre_ouvrier_matiere_organique	= htmlentities(htmlspecialchars($mine_org['ouvrier'])); // Récupération du nombre d'ouvrier de la mine de matière organique dans la BDD
	
	$production_ouvrier			= 1; // Ressources produites par heure grâce à un ouvrier.
	
	$nombre_esclave_or					= htmlentities(htmlspecialchars($mine_o['esclave'])); // Récupération du nombre d'esclave de la mine d'or dans la BDD
	$nombre_esclave_titane				= htmlentities(htmlspecialchars($mine_t['esclave'])); // Récupération du nombre d'esclave de la mine de titane dans la BDD
	$nombre_esclave_cristal				= htmlentities(htmlspecialchars($mine_c['esclave'])); // Récupération du nombre d'esclave de la mine de cristal dans la BDD
	$nombre_esclave_orinia				= htmlentities(htmlspecialchars($mine_orinia['esclave'])); // Récupération du nombre d'esclave de la mine d'orinia dans la BDD
	$nombre_esclave_orinium				= htmlentities(htmlspecialchars($mine_orinium['esclave'])); // Récupération du nombre d'esclave de la mine d'orinium dans la BDD
	$nombre_esclave_matiere_organique	= htmlentities(htmlspecialchars($mine_org['esclave'])); // Récupération du nombre d'esclave de la mine de matière organique dans la BDD
	
	$production_esclave			= 2; // Ressources produites par heure grâce à un esclave.
	

// On mets les ressources du joueur à jour :

							  
	$OrDuJoueur 				= ($heureactuelle - $derniereActualisation) * ($production_base_or + ($nombre_ouvrier_or * $production_ouvrier) + ($nombre_esclave_or * $production_esclave)) / 3600;
	$TitaneDuJoueur 			= ($heureactuelle - $derniereActualisation) * ($production_base_titane + ($nombre_ouvrier_titane * $production_ouvrier) + ($nombre_esclave_titane * $production_esclave)) / 3600;
	$CristalDuJoueur 			= ($heureactuelle - $derniereActualisation) * ($production_base_cristal + ($nombre_ouvrier_cristal * $production_ouvrier) + ($nombre_esclave_cristal * $production_esclave)) / 3600;
	$OriniaDuJoueur 			= ($heureactuelle - $derniereActualisation) * ($production_base_orinia + ($nombre_ouvrier_orinia * $production_ouvrier) + ($nombre_esclave_orinia * $production_esclave)) / 3600;
	$OriniumDuJoueur 			= ($heureactuelle - $derniereActualisation) * ($production_base_orinium + ($nombre_ouvrier_orinium * $production_ouvrier) + ($nombre_esclave_orinium * $production_esclave)) / 3600;
	$Matiere_organiqueDuJoueur 	= ($heureactuelle - $derniereActualisation) * ($production_base_matiere_organique + ($nombre_ouvrier_matiere_organique * $production_ouvrier) + ($nombre_esclave_matiere_organique * $production_esclave)) / 3600;
	$NvPopDuJoueur 				= ($heureactuelle - $derniereActualisationPopulation) * ($production_population) / 3600;
	$EnergieDuJoueur 			= ($heureactuelle - $derniereActualisation) * ($production_energie) / 3600;
	
	
	// UP dans la BDD des nouvelles ressources
	$mineo=$bdd->prepare('UPDATE ressource SET gold = gold+?, titane=titane+?, cristal=cristal+?, orinia=orinia+?, orinium=orinium+?, organique=organique+?, energie=energie+? WHERE id_planete = ? AND id_membre = ?');
	$mineo->execute(array($OrDuJoueur,$TitaneDuJoueur,$CristalDuJoueur,$OriniaDuJoueur,$OriniumDuJoueur,$Matiere_organiqueDuJoueur,$EnergieDuJoueur,$porte_connecte,$id_membre_cible));
	
	
	if(htmlentities(htmlspecialchars($r['energie'])) >= 1000)
	{
	$mineo=$bdd->prepare('UPDATE ressource SET energie=? WHERE id_planete = ? AND id_membre = ?');
	$mineo->execute(array(1000,$porte_connecte,$id_membre_cible));	
	}
	
	//UPDATE energie
	$mineo=$bdd->prepare('UPDATE ressource SET energie=energie+? WHERE id_planete = ? AND id_membre = ?');
	$mineo->execute(array($EnergieDuJoueur,$porte_connecte,$id_membre_cible));	

		
	//UP du temps dans la BDD
	$up=$bdd->prepare('UPDATE ressource SET temps = NOW() WHERE id_membre = ? AND id_planete = ?');
	$up->execute(array($id_membre_cible,$porte_connecte));
	
		//UP du temps dans la BDD
	$upop=$bdd->prepare('UPDATE population SET temps = NOW(), population = population+? WHERE id_planete = ?');
	$upop->execute(array($NvPopDuJoueur,$porte_connecte));
	
	


?>
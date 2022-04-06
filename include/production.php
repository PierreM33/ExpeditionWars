<?php

require_once "connexion_bdd.php";

	$planete_utilise=htmlentities(htmlspecialchars($_SESSION['planete_utilise']));
	$id_membre=htmlentities(htmlspecialchars($_SESSION['id']));
	
	//BONuS DE PROD HEROS
	
	$HerosProd=$bdd->prepare('SELECT * FROM heros WHERE id_membre = ?');
	$HerosProd->execute(array($id_membre));
	$HEROSPRODUCTION=$HerosProd->fetch();
	
	$Production_Heros = $HEROSPRODUCTION['bonus'] / 100;
	

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 1 : MINE OR
		$mine->execute(array($planete_utilise,1));
		$mine_o=$mine->fetch();
	
		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 2 : MINE TITANE
		$mine->execute(array($planete_utilise,2));
		$mine_t=$mine->fetch();

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 3 : MINE ORINIA
		$mine->execute(array($planete_utilise,3));
		$mine_c=$mine->fetch();

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 4 : MINE CRISTAL
		$mine->execute(array($planete_utilise,4));
		$mine_orinia=$mine->fetch();

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 5 : MINE ORINIUM
		$mine->execute(array($planete_utilise,5));
		$mine_orinium=$mine->fetch();

		$mine=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete = ? AND id_mine = ?'); // RECUPERE LES INFOS POUR LA MINE 6 : MINE MATIERE ORGANIQUE
		$mine->execute(array($planete_utilise,6));
		$mine_org=$mine->fetch();
		
		// RECUPERE STOCK DE Ressources
		$ress=$bdd->prepare('SELECT * FROM ressource WHERE id_planete = ? AND id_membre = ?'); // RECUPERE LES INFOS DE STOCK
		$ress->execute(array($planete_utilise,$id_membre));
		$r=$ress->fetch();
		
		// RECUPERE Population
		$pop=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?'); // RECUPERE LES INFOS DE STOCK
		$pop->execute(array($planete_utilise));
		$popu=$pop->fetch();
		
		// RECUPERE INFRa
		$in=$bdd->prepare('SELECT * FROM infrastructure WHERE id_planete = ? AND id_membre=?'); // RECUPERE LES INFOS DE STOCK
		$in->execute(array($planete_utilise,$id_membre));
		$infrastructure=$in->fetch();
		
		$mbr=$bdd->prepare('SELECT * FROM membre WHERE id = ? ');
		$mbr->execute(array($id_membre));
		$ra=$mbr->fetch();
		
		
		//ON RECUPERE LA FACTION DU JOUEUR
		$faction=$bdd->prepare('SELECT * FROM faction_joueur WHERE id_membre = ? ');
		$faction->execute(array($id_membre));
		$Fact=$faction->fetch();
		
		//ON RECUPERE ENSUITE LES LOIS ADOPTE DE CETTE FACTION POUR RECUPERER LA PRODUCTION SUPPLEMENTAIRE
		$faction_loi=$bdd->prepare('SELECT * FROM faction_loi WHERE faction = ? AND adopte = ? AND numero = ?');
		$faction_loi->execute(array(htmlentities($Fact['nom_faction']),1,1));
		$Fa_L=$faction_loi->fetch();
		

			//ON RAJOUTE LE POURCENTAGE DE PRODUCTION DE LA FACTION
			if(htmlentities($Fa_L['effet']) == "prod2%")
			{
				$production_2_pourcent = 2/100;

			}
			else
			{
				$production_2_pourcent = 0;

			}
			
		
		
		
		//récupère la valeur de production de la race de base en BDD
		$rb=$bdd->prepare('SELECT * FROM production WHERE id = ? ');
		$rb->execute(array(1));
		$race_base=$rb->fetch();
		
		$valhar = "valhar";
		$orak = "orak";
		$humain = "humain";
		$droide = "droide";
		
				//on récupère le moral du joueur
		$m=$bdd->prepare('SELECT * FROM moral WHERE id_membre = ? AND pseudo_membre = ?');
		$m->execute(array($id_membre,htmlentities(htmlspecialchars($_SESSION['pseudo']))));
		$m=$m->fetch();
		
		
		$moral = htmlentities(htmlspecialchars($m['moral']));
		
		//le moral ne peut pas descendre en dessous de 50%.S'il descend à -50% on le remet a -50.
		if($moral < (-50))
		{
			$nv_moral= (-50);
			
			$up_moral=$bdd->prepare('UPDATE moral SET moral=? WHERE id_membre = ?');
			$up_moral->execute(array($nv_moral,$id_membre));
		}
		
		//On récupère le montant max de population par planete
		$prod_pl=$bdd->prepare('SELECT * FROM  infrastructure WHERE id_planete = ? AND id_membre=?');
		$prod_pl->execute(array($planete_utilise,$id_membre));
		$Pr_L=$prod_pl->fetch();
		
		$prod_max = htmlentities($Pr_L['limite']);
		$Pop_G = htmlentities(htmlspecialchars($popu['population']));

		
				//Calcul de toute la population par planète
		$lst_pop = htmlentities(htmlspecialchars($popu['ouvrier'])) + htmlentities(htmlspecialchars($popu['esclave'])) + htmlentities(htmlspecialchars($popu['civil'])) + htmlentities(htmlspecialchars($popu['soldat'])) + htmlentities(htmlspecialchars($popu['chercheur'])) + htmlentities(htmlspecialchars($popu['pilote'])) + htmlentities(htmlspecialchars($popu['population'])); 
		$ouvrier_dans_mine = htmlentities(htmlspecialchars($mine_o['ouvrier'])) + htmlentities(htmlspecialchars($mine_t['ouvrier'])) + htmlentities(htmlspecialchars($mine_c['ouvrier'])) + htmlentities(htmlspecialchars($mine_orinia['ouvrier'])) + htmlentities(htmlspecialchars($mine_orinium['ouvrier'])) + htmlentities(htmlspecialchars($mine_org['ouvrier']));
		$esclave_dans_mine = htmlentities(htmlspecialchars($mine_o['esclave'])) + htmlentities(htmlspecialchars( $mine_t['esclave'])) + htmlentities(htmlspecialchars($mine_c['esclave'])) + htmlentities(htmlspecialchars($mine_orinia['esclave'])) + htmlentities(htmlspecialchars($mine_orinium['esclave'])) + htmlentities(htmlspecialchars($mine_org['esclave']));
		$Page_pop = htmlentities(htmlspecialchars($popu['ouvrier'])) + htmlentities(htmlspecialchars($popu['esclave'])) + htmlentities(htmlspecialchars($popu['civil'])) + htmlentities(htmlspecialchars($popu['soldat'])) + htmlentities(htmlspecialchars($popu['chercheur'])) + htmlentities(htmlspecialchars($popu['pilote']));
		
		
		$pop_planete = $lst_pop + $ouvrier_dans_mine + $esclave_dans_mine ;
		
		// FIN DE PROD BAS DE PAGE

		//Si la population a atteind la limie alors on bloque la production.
		if($pop_planete >= htmlentities(htmlspecialchars($infrastructure['limite'])) )
		{
			$production_population = 0;
		}
		else
		{
			if(htmlentities(htmlspecialchars($ra['race'])) == $orak)
			{
			$production_population = htmlentities(htmlspecialchars($race_base['orak'])) + (htmlentities(htmlspecialchars($race_base['orak'])) * $moral / 100);
			}
			elseif(htmlentities(htmlspecialchars($ra['race'])) == $valhar)
			{
			$production_population = htmlentities(htmlspecialchars($race_base['valhar']))  + (htmlentities(htmlspecialchars($race_base['valhar'])) * $moral / 100);
			}
			elseif(htmlentities(htmlspecialchars($ra['race'])) == $humain)
			{
			$production_population = htmlentities(htmlspecialchars($race_base['humain'])) + (htmlentities(htmlspecialchars($race_base['humain'])) * $moral / 100);
			}
			elseif(htmlentities(htmlspecialchars($ra['race'])) == $droide)
			{
			$production_population = htmlentities(htmlspecialchars($race_base['droide'])) + (htmlentities(htmlspecialchars($race_base['droide'])) * $moral / 100);
			}
		}

		
	$heureactuelle 								= time();
	$derniereActualisation 						= strtotime($r['temps']); // Récupération du temps depuis la dernière actualisation dans la BDD
	$derniereActualisationPopulation 			= strtotime($popu['temps']); // Récupération du temps depuis la dernière actualisation dans la BDD
	
	/*--------------------------------------------
	$reserve_or						= $r['gold']; // Récupération de l'or possédé par le joueur dans la BDD
	$reserve_titane					= $r['titane']; // Récupération du titane possédé par le joueur dans la BDD
	$reserve_cristal				= $r['cristal']; // Récupération du cristal possédé par le joueur dans la BDD
	$reserve_orinia					= $r['orinia']; // Récupération de l'orinia possédé par le joueur dans la BDD
	$reserve_orinium				= $r['orinium']; // Récupération de l'orinium possédé par le joueur dans la BDD
	$reserve_matiere_organique		= $r['organique']; // Récupération de la matière organique possédé par le joueur dans la BDD
	-----------------------*/
	
	
	

	$production_base_or 				= 20; // Or produites par heure.
	$production_base_titane 			= 20; // Titane produites par heure.
	$production_base_cristal 			= 20; // Cristal produites par heure.
	$production_base_orinia 			= 20; // Orinia produites par heure.
	$production_base_orinium 			= 20; // Orinium produites par heure.
	$production_base_matiere_organique 	= 0; // Matière Organique produites par heure.
	
	
	//Bonus de race par rapport à l'evenement qui produira de la matiere organique
	$sl=$bdd->prepare('SELECT * FROM evenement WHERE id_membre = ?');
	$sl->execute(array($id_membre));
	$SL=$sl->fetch();
	
	$bonus_race = htmlentities($SL['bonus']);

	$race_even = htmlentities(htmlspecialchars($SL['race']));
	$NVR = "rahago";
		
	if($race_even == $NVR)
	{
		$production_base_matiere_organique = 1000 * $bonus_race;
	}
	
	
	
	// Si l'énergie est en dessous de 1.000 il produit 100 sinon 0
	if(htmlentities(htmlspecialchars($r['energie'])) < 1000)
	{	
	$production_energie					= 150; // Produit 100 energie par heure.
	}
	else
	{
	$production_energie					= 0; // Produit 0 energie par heure.	
	}
	
	//recuperation du bonus
	$bon=$bdd->prepare('SELECT * FROM ressource WHERE id_planete = ?');
	$bon->execute(array($planete_utilise));
	$bonu=$bon->fetch();
	
	$bonuss = $bonu['bonus'];

	
	if($bonuss == 0)
	{
		$bonus = 1;
		
	}
	else
	{
		
		$bonus = 2;
	}
	
	
	$nombre_ouvrier_or					= htmlentities(htmlspecialchars($mine_o['ouvrier'])) * $bonus; // Récupération du nombre d'ouvrier de la mine d'or dans la BDD
	$nombre_ouvrier_titane				= htmlentities(htmlspecialchars($mine_t['ouvrier'])) * $bonus; // Récupération du nombre d'ouvrier de la mine de titane dans la BDD
	$nombre_ouvrier_cristal				= htmlentities(htmlspecialchars($mine_c['ouvrier'])) * $bonus; // Récupération du nombre d'ouvrier de la mine de cristal dans la BDD
	$nombre_ouvrier_orinia				= htmlentities(htmlspecialchars($mine_orinia['ouvrier'])) * $bonus; // Récupération du nombre d'ouvrier de la mine d'orinia dans la BDD
	$nombre_ouvrier_orinium				= htmlentities(htmlspecialchars($mine_orinium['ouvrier'])) * $bonus ; // Récupération du nombre d'ouvrier de la mine d'orinium dans la BDD
	$nombre_ouvrier_matiere_organique	= htmlentities(htmlspecialchars($mine_org['ouvrier'])) * $bonus; // Récupération du nombre d'ouvrier de la mine de matière organique dans la BDD
	
	$production_ouvrier			= 1; // Ressources produites par heure grâce à un ouvrier.
	
	$nombre_esclave_or					= htmlentities(htmlspecialchars($mine_o['esclave'])); // Récupération du nombre d'esclave de la mine d'or dans la BDD
	$nombre_esclave_titane				= htmlentities(htmlspecialchars($mine_t['esclave'])); // Récupération du nombre d'esclave de la mine de titane dans la BDD
	$nombre_esclave_cristal				= htmlentities(htmlspecialchars($mine_c['esclave'])); // Récupération du nombre d'esclave de la mine de cristal dans la BDD
	$nombre_esclave_orinia				= htmlentities(htmlspecialchars($mine_orinia['esclave'])); // Récupération du nombre d'esclave de la mine d'orinia dans la BDD
	$nombre_esclave_orinium				= htmlentities(htmlspecialchars($mine_orinium['esclave'])); // Récupération du nombre d'esclave de la mine d'orinium dans la BDD
	$nombre_esclave_matiere_organique	= htmlentities(htmlspecialchars($mine_org['esclave'])); // Récupération du nombre d'esclave de la mine de matière organique dans la BDD
	
	$production_esclave			= 2; // Ressources produites par heure grâce à un esclave.
	


		
	//RACCOURCI DE VARIABLE
	$RAC_or = ( $Production_Heros  * ($production_base_or + ($nombre_ouvrier_or * $production_ouvrier) + ($nombre_esclave_or * $production_esclave)));
	$RAC_titane = ( $Production_Heros  * ($production_base_titane + ($nombre_ouvrier_titane * $production_ouvrier) + ($nombre_esclave_titane * $production_esclave)));
	$RAC_cristal = ( $Production_Heros  * ($production_base_cristal + ($nombre_ouvrier_cristal * $production_ouvrier) + ($nombre_esclave_cristal * $production_esclave)));
	$RAC_orinia = ( $Production_Heros  * ($production_base_orinia + ($nombre_ouvrier_orinia * $production_ouvrier) + ($nombre_esclave_orinia * $production_esclave)));
	$RAC_orinium = ( $Production_Heros * ($production_base_orinium + ($nombre_ouvrier_orinium * $production_ouvrier) + ($nombre_esclave_orinium * $production_esclave)));
	$RAC_organique = ( $production_2_pourcent *  ($production_base_matiere_organique + ($nombre_ouvrier_matiere_organique * $production_ouvrier) + ($nombre_esclave_matiere_organique * $production_esclave)));


	
	
	// On mets les ressources du joueur à jour :  
	$OrDuJoueur 				= ($heureactuelle - $derniereActualisation) * ( $RAC_or + ($production_base_or + ($nombre_ouvrier_or * $production_ouvrier) + ($nombre_esclave_or * $production_esclave))) / 3600;
	$TitaneDuJoueur 			= ($heureactuelle - $derniereActualisation) * ( $RAC_titane + ($production_base_titane + ($nombre_ouvrier_titane * $production_ouvrier) + ($nombre_esclave_titane * $production_esclave))) / 3600;
	$CristalDuJoueur 			= ($heureactuelle - $derniereActualisation) * ( $RAC_cristal + ($production_base_cristal + ($nombre_ouvrier_cristal * $production_ouvrier) + ($nombre_esclave_cristal * $production_esclave))) / 3600;
	$OriniaDuJoueur 			= ($heureactuelle - $derniereActualisation) * ( $RAC_orinia + ($production_base_orinia + ($nombre_ouvrier_orinia * $production_ouvrier) + ($nombre_esclave_orinia * $production_esclave))) / 3600;
	$OriniumDuJoueur 			= ($heureactuelle - $derniereActualisation) * ( $RAC_orinium + ($production_base_orinium + ($nombre_ouvrier_orinium * $production_ouvrier) + ($nombre_esclave_orinium * $production_esclave))) / 3600;
	$Matiere_organiqueDuJoueur 	= ($heureactuelle - $derniereActualisation) * ( $RAC_organique + ($production_base_matiere_organique + ($nombre_ouvrier_matiere_organique * $production_ouvrier) + ($nombre_esclave_matiere_organique * $production_esclave))) / 3600;
	$NvPopDuJoueur 				= ($heureactuelle - $derniereActualisationPopulation) * ($production_population) / 3600;
	$EnergieDuJoueur 			= ($heureactuelle - $derniereActualisation) * ($production_energie) / 3600;
	
	
	
	// UP dans la BDD des nouvelles ressources
	$mineo=$bdd->prepare('UPDATE ressource SET gold = gold+?, titane=titane+?, cristal=cristal+?, orinia=orinia+?, orinium=orinium+?, organique=organique+?, energie=energie+? WHERE id_planete = ? AND id_membre = ?');
	$mineo->execute(array($OrDuJoueur,$TitaneDuJoueur,$CristalDuJoueur,$OriniaDuJoueur,$OriniumDuJoueur,$Matiere_organiqueDuJoueur,$EnergieDuJoueur,$planete_utilise,$id_membre));
	
	
	
	//Si l'energie est superieur ou égale a 1000 on remet a 1000
	if(htmlentities(htmlspecialchars($r['energie'])) >= 1000)
	{
	$mineo=$bdd->prepare('UPDATE ressource SET energie=? WHERE id_planete = ? AND id_membre = ?');
	$mineo->execute(array(1000,$planete_utilise,$id_membre));	
	}
	
	
	//UPDATE energie
	$mineo=$bdd->prepare('UPDATE ressource SET energie=energie+? WHERE id_planete = ? AND id_membre = ?');
	$mineo->execute(array($EnergieDuJoueur,$planete_utilise,$id_membre));	

		
	//UP du temps dans la BDD
	$up=$bdd->prepare('UPDATE ressource SET temps = NOW() WHERE id_membre = ? AND id_planete = ?');
	$up->execute(array($id_membre,$planete_utilise));
	
	//UP du temps dans la BDD
	$upop=$bdd->prepare('UPDATE population SET temps = NOW(), population = population+? WHERE id_planete = ?');
	$upop->execute(array($NvPopDuJoueur,$planete_utilise));
	
	//Si la population de la planete >= à la limite max de la planete
	if($pop_planete >= $prod_max)
	{
		//Population H D = Champs population MOINS les Champs de la page population
		$Population_H_D = $pop_planete - $prod_max;
		
		//Alors on soustrait
		$upop=$bdd->prepare('UPDATE population SET temps = NOW(), population = population-? WHERE id_planete = ?');
		$upop->execute(array($Population_H_D,$planete_utilise));
		
	}

?>
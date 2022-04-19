<?php		
// Ici on va vérifier si la valeur envoyé est bien un nombre, qu'il soit positif.
// On va récuperer les stocks du vaisseaux sur la planète.
//Verifier qu'on retirer pas plus qu'il y en a sur le vaisseau
if($_POST)
	{
		require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

//Ressources disponible sur la planète en question
$m = $bdd->prepare('SELECT * FROM ressource WHERE id_planete = ?');
$m->execute(array($planete_utilise));
$ress_pl=$m->fetch();

//Récupère le vaisseau
$lst_v=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id = ?');
$lst_v->execute(array($id_membre,$planete_utilise,strip_tags($_POST['id_vaisseau'])));
$place_dispo=$lst_v->fetch();

		$nb_ressource = strip_tags($_POST['nb_ressource']);
		$nom_ressource  = strip_tags($_POST['ressource']);
		$fret = htmlentities( htmlspecialchars($place_dispo['fret']));
		$stock_gold = htmlentities( htmlspecialchars($place_dispo['stock_gold']));
		$stock_titane = htmlentities( htmlspecialchars($place_dispo['stock_titane']));
		$stock_cristal = htmlentities( htmlspecialchars($place_dispo['stock_cristal']));
		$stock_orinia = htmlentities( htmlspecialchars($place_dispo['stock_orinia']));
		$stock_orinium = htmlentities( htmlspecialchars($place_dispo['stock_orinium']));
		
		if(is_numeric($nb_ressource) AND $nb_ressource >= 0)
		{
			if($nom_ressource == "gold" OR $nom_ressource == "titane" OR $nom_ressource == "cristal" OR$nom_ressource == "orinia" OR $nom_ressource == "orinium")
			{
				
				if($nom_ressource == "gold")
				{
						if($nb_ressource <= $stock_gold )
						{

							//On va vérifier que le fret soit supérieur aux ressources proposé.
							$p=$bdd->prepare('UPDATE vaisseau_joueur SET stock_gold = stock_gold-? , fret=fret+? , poid = poid-? WHERE id_membre = ? AND id_planete = ? AND id = ?');
							$p->execute(array($nb_ressource,$nb_ressource,$nb_ressource,$id_membre,$planete_utilise,strip_tags($_POST['id_vaisseau'])));
							
							//Retrait des ressources
							$r=$bdd->prepare('UPDATE ressource SET gold = gold+? WHERE id_planete = ? AND id_membre = ? ');
							$r->execute(array($nb_ressource,$planete_utilise,$id_membre));
							
							$_SESSION['error'] = '<p class="green">Ressources destock&eacute;.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');

							
						}
						else
						{
							$_SESSION['error'] = '<p class="red"> Votre vaisseau ne poss&egrave;dent pas autant de ressources.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');
						}
				}



				if($nom_ressource == "titane")
				{

						if($nb_ressource <= $stock_titane)
						{

							//On va vérifier que le fret soit supérieur aux ressources proposé.
							$p=$bdd->prepare('UPDATE vaisseau_joueur SET stock_titane = stock_titane-? , fret=fret+? , poid = poid-? WHERE id_membre = ? AND id_planete = ? AND id = ?');
							$p->execute(array($nb_ressource,$nb_ressource,$nb_ressource,$id_membre,$planete_utilise,strip_tags($_POST['id_vaisseau'])));
							
							//Retrait des ressources
							$r=$bdd->prepare('UPDATE ressource SET titane = titane+? WHERE id_planete = ? AND id_membre = ? ');
							$r->execute(array($nb_ressource,$planete_utilise,$id_membre));
							
							$_SESSION['error'] = '<p class="green">Ressources destock&eacute;.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');

							
						}
						else
						{
							$_SESSION['error'] = '<p class="red"> Votre vaisseau ne poss&egrave;dent pas autant de ressources.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');
						}
				}

				 
				 
				if($nom_ressource == "cristal")
				{

						if($nb_ressource <= $stock_cristal)
						{

							//On va vérifier que le fret soit supérieur aux ressources proposé.
							$p=$bdd->prepare('UPDATE vaisseau_joueur SET stock_cristal = stock_cristal-? , fret=fret+? , poid = poid-? WHERE id_membre = ? AND id_planete = ? AND id = ?');
							$p->execute(array($nb_ressource,$nb_ressource,$nb_ressource,$id_membre,$planete_utilise,strip_tags($_POST['id_vaisseau'])));
							
							//Retrait des ressources
							$r=$bdd->prepare('UPDATE ressource SET cristal = cristal+? WHERE id_planete = ? AND id_membre = ? ');
							$r->execute(array($nb_ressource,$planete_utilise,$id_membre));
							
							$_SESSION['error'] = '<p class="green">Ressources destock&eacute;.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');

							
						}
						else
						{
							$_SESSION['error'] = '<p class="red"> Votre vaisseau ne poss&egrave;dent pas autant de ressources.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');
						}
				}
				

				if($nom_ressource == "orinia")
				{
						if($nb_ressource <= $stock_orinia)
						{

							//On va vérifier que le fret soit supérieur aux ressources proposé.
							$p=$bdd->prepare('UPDATE vaisseau_joueur SET stock_orinia = stock_orinia-? , fret=fret+? , poid = poid-? WHERE id_membre = ? AND id_planete = ? AND id = ?');
							$p->execute(array($nb_ressource,$nb_ressource,$nb_ressource,$id_membre,$planete_utilise,strip_tags($_POST['id_vaisseau'])));
							
							//Retrait des ressources
							$r=$bdd->prepare('UPDATE ressource SET orinia = orinia+? WHERE id_planete = ? AND id_membre = ? ');
							$r->execute(array($nb_ressource,$planete_utilise,$id_membre));
							
							$_SESSION['error'] = '<p class="green">Ressources destock&eacute;.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');

							
						}
						else
						{
							$_SESSION['error'] = '<p class="red"> Votre vaisseau ne poss&egrave;dent pas autant de ressources.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');
						}

				}

			
				if($nom_ressource == "orinium")
				{
						if($nb_ressource <= $stock_orinium)
						{

							//On va vérifier que le fret soit supérieur aux ressources proposé
							//Ajout du poid au vaisseau
							$p=$bdd->prepare('UPDATE vaisseau_joueur SET stock_orinium = stock_orinium-? , fret=fret+? , poid = poid-? WHERE id_membre = ? AND id_planete = ? AND id = ?');
							$p->execute(array($nb_ressource,$nb_ressource,$nb_ressource,$id_membre,$planete_utilise,strip_tags($_POST['id_vaisseau'])));
							
							//Retrait des ressources
							$r=$bdd->prepare('UPDATE ressource SET orinium = orinium+? WHERE id_planete = ? AND id_membre = ? ');
							$r->execute(array($nb_ressource,$planete_utilise,$id_membre));
							
							
							$_SESSION['error'] = '<p class="green">Ressources destock&eacute;.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');

							
						}
						else
						{
							$_SESSION['error'] = '<p class="red"> Votre vaisseau ne poss&egrave;dent pas autant de ressources.</p>';
							header('Location: '.pathView().'./flotte/transport_ressource.php');
						}
					
				}
			}
			else
			{
			$_SESSION['error'] = '<p class="red">Erreur dans le choix des ressources. Veuillez contacter le staff.</p>';
				header('Location: '.pathView().'./flotte/transport_ressource.php');
			}
		}
		else
		{
		$_SESSION['error'] = '<p class="red"> Veuillez entrer un nombre positif uniquement.</p>';
			header('Location: '.pathView().'./flotte/transport_ressource.php');
		}
	}
	else
	{
	$_SESSION['error'] = '<p class="red">Problème d\envoi du formulaire.</p>';
	header('Location: '.pathView().'./flotte/transport_ressource.php');
	}


?>
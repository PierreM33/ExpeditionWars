<?php

if($_POST)
	{
	require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
				//On delete de la faction le joueur
				$r=$bdd->prepare('UPDATE faction_joueur SET rang = ?, nom_rang = ? WHERE id_membre = ?');
				$r->execute(array(4," Dirigeant de la Faction",$id_membre));
				
				//recuperation faction du joueur
				$P=$bdd->prepare('SELECT * FROM faction_joueur WHERE id_membre = ?');
				$P->execute(array($id_membre));
				$P=$P->fetch();
				
				$temps1 = 604800;
				$temps = time() + $temps1;
				
				$temps2 = 691200;
				$temps3 = time() + $temps2;
				
				
				//7 jours = 604800 secondes
				$r=$bdd->prepare('INSERT INTO faction_dirigeant(nom_faction,id_membre,date,temps,temps2) VALUES(?,?,NOW(),?,?)');
				$r->execute(array($P['nom_faction'],$id_membre,$temps,$temps3));
				
				header('Location: '.pathView().'./faction/faction.php');
				$_SESSION['error'] = '<p class="green">Vous êtes dirigeant de votre faction.</p>';
	
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./faction/liste_faction.php');
	?>
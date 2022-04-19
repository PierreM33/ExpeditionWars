<?php
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);

//Récupère le pseudo de l'attaquant
$l=$bdd->prepare('SELECT * FROM membre WHERE id=?');
$l->execute(array($id_membre_attaquant));
$att=$l->fetch();

//Récupère le pseudo du defenseur
$l=$bdd->prepare('SELECT * FROM membre WHERE id=?');
$l->execute(array($id_membre_defenseur));
$def=$l->fetch();

$ins=$bdd->prepare('INSERT INTO `save_vainqueur_cb_spatial`(`id_membre_att`, `pseudo_atta`, `id_planete`, `id_membre_def`, `pseudo_def`, `numero_combat`, `resultat`, `rapport_lu`) VALUES (?,?,?,?,?,?,?,?)');
$ins->execute(array($id_membre_attaquant,$pseudo_attaquant,$id_planete_defenseur,$id_membre_defenseur,$pseudo_defenseur,$numero_combat_spatial,"nul",0));


//HISTORIQUE
//AJOUTE 1 combat aux deux joueurs
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET combat_total = combat_total + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_attaquant));

$historique=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET combat_total = combat_total + ? WHERE id_membre = ? ');
$historique->execute(array(1,$id_membre_defenseur));

// Ajoute 1 point par joueur
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET point_combat = point_combat + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_attaquant));

// Ajoute  1 match nul
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET match_nul = match_nul + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_attaquant));

// AJoute 1 match nul
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET match_nul = match_nul + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_defenseur));


?>
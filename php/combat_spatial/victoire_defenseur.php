<?php
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);

$ins=$bdd->prepare('INSERT INTO `save_vainqueur_cb_spatial`(`id_membre_att`, `pseudo_atta`, `id_planete`, `id_membre_def`, `pseudo_def`, `numero_combat`, `resultat`,`rapport_lu`) VALUES (?,?,?,?,?,?,?,?)');
$ins->execute(array($id_membre_attaquant,$pseudo_attaquant,$id_planete_defenseur,$id_membre_defenseur,$pseudo_defenseur,$numero_combat_spatial,"defenseur",0));


//AJOUTE DU MORAL ATTAQUANT PERD 1
$moral=$bdd->prepare('UPDATE moral SET moral=moral-? WHERE pseudo_membre=? AND id_membre=?');
$moral->execute(array(1,$pseudo_attaquant,$id_membre_attaquant));

//AJOUTE DU MORAL DEFENSEUR GAGNE 1
$moral=$bdd->prepare('UPDATE moral SET moral=moral+? WHERE pseudo_membre=? AND id_membre=?');
$moral->execute(array(1,$pseudo_defenseur,$id_membre_defenseur));

// HISTORIQUE DE COMBAT

//AJOUTE 1 combat aux deux joueurs
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET combat_total = combat_total + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_attaquant));

$historique=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET combat_total = combat_total + ? WHERE id_membre = ? ');
$historique->execute(array(1,$id_membre_defenseur));

// Ajoute 2 points au def
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET point_combat = point_combat + ? WHERE id_membre = ? ');
$historique_a->execute(array(2,$id_membre_defenseur));

// Ajoute  1 victoire au def
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET victoire = victoire + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_defenseur));

//1 defaite a l'attaquant
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET defaite = defaite + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_attaquant));

//On supprime maintenant l'action du vaisseau
$del=$bdd->prepare('DELETE FROM vaisseau_action WHERE id = ?');
$del->execute(array($id_action));	
?>
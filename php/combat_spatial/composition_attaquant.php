<?php
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);


// Initialisation de la variable à 0
$ATTAQUE_ATTAQUANT = 0;
$BOUCLIER_ATTAQUANT = 0;
$DEFENSE_ATTAQUANT = 0;

$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ? ');
$select->execute(array($id_membre_attaquant,$id_action));
while($s=$select->fetch())

{
	
$ATTAQUE_ATTAQUANT+=$s['attaque'];  // Ou on peut faire : $ATTAQUE = $ATTAQUE + $s['attaque'];  
$BOUCLIER_ATTAQUANT+=$s['bouclier'];
$DEFENSE_ATTAQUANT+=$s['defense'];
									

}

//ToTAL vaisseau par gabarit
$select=$bdd->prepare('SELECT a.id, a.id_membre, b.* FROM vaisseau_action AS a
						LEFT JOIN vaisseau_joueur AS b ON (b.id_action = a.id)
						WHERE a.id_membre = ? AND planete_vise = ? AND gabarit = ?');
$select->execute(array($id_membre_attaquant,$id_planete_defenseur,1));
$chasseur_a=$select->rowCount();

$select=$bdd->prepare('SELECT a.id, a.id_membre, b.* FROM vaisseau_action AS a
						LEFT JOIN vaisseau_joueur AS b ON (b.id_action = a.id)
						WHERE a.id_membre = ? AND planete_vise = ? AND gabarit = ?');
$select->execute(array($id_membre_attaquant,$id_planete_defenseur,2));
$leger_a=$select->rowCount();

$select=$bdd->prepare('SELECT a.id, a.id_membre, b.* FROM vaisseau_action AS a
						LEFT JOIN vaisseau_joueur AS b ON (b.id_action = a.id)
						WHERE a.id_membre = ? AND planete_vise = ? AND gabarit = ?');
$select->execute(array($id_membre_attaquant,$id_planete_defenseur,3));
$moyen_a=$select->rowCount();

//TOTAL DE VAISSEAU
$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ?');
$select->execute(array($id_membre_attaquant,$id_action));
$total_a=$select->rowCount();


?>
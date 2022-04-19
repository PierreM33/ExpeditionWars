<?php
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);


// Initialisation de la variable à 0
$ATTAQUE_DEFENSEUR = 0;
$BOUCLIER_DEFENSEUR = 0;
$DEFENSE_DEFENSEUR = 0;


//SELECTIONNE LES VAISSEAUX DU DEFENSEUR
$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id_action = ? ');
$select->execute(array($id_membre_defenseur,$id_planete_defenseur,0));
while($sd=$select->fetch())

{


$ATTAQUE_DEFENSEUR+=$sd['attaque'];  // Ou on peut faire : $ATTAQUE = $ATTAQUE + $s['attaque'];  
$BOUCLIER_DEFENSEUR+=$sd['bouclier'];
$DEFENSE_DEFENSEUR+=$sd['defense'];

}



$select=$bdd->prepare('SELECT a.id, a.id_membre, b.* FROM vaisseau_action AS a 
					LEFT JOIN vaisseau_joueur AS b ON (b.id_action = a.id) 
					WHERE a.id_membre = ? AND b.id_planete = ? AND gabarit = ?');
$select->execute(array($id_membre_defenseur,$id_planete_defenseur,1));
$chasseur_d=$select->rowCount();

$select=$bdd->prepare('SELECT a.id, a.id_membre, b.* FROM vaisseau_action AS a 
					LEFT JOIN vaisseau_joueur AS b ON (b.id_action = a.id) 
					WHERE a.id_membre = ? AND b.id_planete = ? AND gabarit = ?');
$select->execute(array($id_membre_defenseur,$id_planete_defenseur,2));
$leger_d=$select->rowCount();

$select=$bdd->prepare('SELECT a.id, a.id_membre, b.* FROM vaisseau_action AS a 
					LEFT JOIN vaisseau_joueur AS b ON (b.id_action = a.id) 
					WHERE a.id_membre = ? AND b.id_planete = ? AND gabarit = ?');
$select->execute(array($id_membre_defenseur,$id_planete_defenseur,3));
$moyen_d=$select->rowCount();


//TOTAL DE VAISSEAU
$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id_action = ?');
$select->execute(array($id_membre_defenseur,$id_planete_defenseur,0));
$total_d=$select->rowCount();



?>

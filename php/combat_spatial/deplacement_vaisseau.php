<?php
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);

//---- A LA FIN DU COMBAT ON VA RECUPERER LES VAISSEAUX DE VAISSEAUX SELECTION POUR LES METTRES EN MOUVEMENT
//ATTAQUE ACTION 1
//MOUVEMENT VERS PLANETE ALLIE ACTION 2
//MOUVEMENT VERS ESPACE ACTION 3

$TypeAttaque = $liste_vaisseau['type'];

//SI on attaque depuis une planete sinon c'est que c'est depuis l'espace.
if($TypeAttaque == 1)
{

//RETOUR VERS LA PLANETE
$nouveau_temps = time() + $stockage_valeur_deplacement;
//ON VA FAIRE UN UPDATE DE L'ACTION ET LE PASSER EN MODE RETOUR (TRANSPORT NUMERO 2)
//On update la cible comme sa propre planete en fonction du joueur et de l'id action
$Up = $bdd->prepare('UPDATE vaisseau_action SET planete_vise = ?, id_membre_vise = ? , nom_action = ? , temps = ? WHERE id_membre = ? AND id = ?');
$Up->execute(array($id_planete_attaquant,$id_membre_attaquant,2,$nouveau_temps, $id_membre_attaquant, $id_action ));


}
else
{

//RETOUR VERS LA PLANETE DEPUIS L'ESPACE
//- On recalcul le trajet

// Recuperer les infos de sa planete
$m = $bdd->prepare('SELECT * FROM planete WHERE id = ?');
$m->execute(array($id_planete_attaquant));
$PlaneteAttaquant=$m->fetch();	

// récuperer les coordonnées de la planète adversaire pour verifier qu'elle existe
$ga = $bdd->prepare("SELECT * FROM planete WHERE id = ?");
$ga->execute(array($id_planete_defenseur));
$PlaneteDefenseur=$ga->fetch();

//nos coordonnée

		$NUM_SYSTEME_vise = $PlaneteAttaquant['numero_systeme'];
		$X_vise = $PlaneteAttaquant['x'];
		$Y_vise = $PlaneteAttaquant['y'];

//coordonnée visé
		$NUM_SYSTEME = $PlaneteDefenseur['numero_systeme'];
		$X = $PlaneteDefenseur['x'];
		$Y = $PlaneteDefenseur['y'];
		
		
//depart
$s = $bdd->prepare('SELECT * FROM planete WHERE numero_systeme = ? AND x= ? AND y=?');
$s->execute(array($NUM_SYSTEME,$X_vise,$Y_vise));
$ar=$s->fetch();

//arriver
$s = $bdd->prepare('SELECT * FROM planete WHERE numero_systeme = ? AND x= ? AND y=?');
$s->execute(array($NUM_SYSTEME_vise,$X,$Y));
$dep=$s->fetch();


//Exemple 10X et 2 Y

//On prend le point d'origine
$depart_x = $dep['x'];
$depart_y = $dep['y'];

//On prend le point d'arriver
$arrive_x = $ar['x'];
$arrive_y = $ar['y'];

//On calcul le nombre de case sur X
//On calcul le nombre de case sur Y
$total_case_x = $depart_x - $arrive_x;
$total_case_y = $depart_y - $arrive_y;


//Si le calcul rend inferieur on le rend supérieur en inversant le calcul
if($total_case_x < 0)
{
	$total_case_x =  $arrive_x - $depart_x;
}
if($total_case_y < 0)
{
	$total_case_y =  $arrive_y - $depart_y;
}


//NUM SYS

$num_sys_ar = $ar['numero_systeme'];
$num_sys_dep = $dep['numero_systeme'];

//On calcul le nombre de systeme different.
$ns = $num_sys_dep - $num_sys_ar;


if($ns < 0)
{
	$ns = $num_sys_ar - $num_sys_dep;
}

//On affiche le temps
$total_case = $total_case_x + $total_case_y;


//10 minutes par case
//5 min par systeme

$temps_systeme = $ns * 1;
$temps_case = $total_case * 1;

$temps_general = $temps_case + $temps_systeme;
$nouveau_temps = $temps_general + time();

//RETOUR VERS LA PLANETE
$Up = $bdd->prepare('UPDATE vaisseau_action SET planete_vise = ?, id_membre_vise = ? , nom_action = ? , temps = ? WHERE id_membre = ? AND id = ?');
$Up->execute(array($id_planete_attaquant,$id_membre_attaquant,2,$nouveau_temps, $id_membre_attaquant, $id_action ));
}

/*
//- REMPLACER LE PLANETE VISE PAR LES COORDONNEES DE L'ESPACE APRES COMBAT
$select=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_membre = ? AND id_action = ? ');
$select->execute(array($id_membre_attaquant,$id_action));
while($sel=$select->fetch())
{			




// RETOUR DU VAISSEAU DANS L'ESPACE.
//On recupère la position de la planete vise
$position=$bdd->prepare('SELECT * FROM planete WHERE id = ?');
$position->execute(array($id_planete_defenseur));
$nv_position=$position->fetch();		

$systeme = htmlentities($nv_position['numero_systeme']);

$x = htmlentities($nv_position['x']);
$y = htmlentities($nv_position['y'])-1;


//On va notifier la nouvelle position du vaisseau en fonction de l'id de l'action
$up_nv_bdd=$bdd->prepare('UPDATE vaisseau_joueur SET x = ?, y = ? , systeme = ?, id_action = ? , case_planete = ? ,case_espace = ? WHERE id_membre = ? AND id_action = ? ');
$up_nv_bdd->execute(array($x,$y,$systeme,0,0,1,$id_membre_attaquant,$id_action)); 


//On supprime maintenant l'action du vaisseau
$del=$bdd->prepare('DELETE FROM vaisseau_action WHERE id = ?');
$del->execute(array($id_action));	

}*/



?>
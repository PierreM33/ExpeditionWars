<?php

//ATTAQUE ACTION 1
//MOUVEMENT VERS PLANETE ALLIE ACTION 2
//MOUVEMENT VERS ESPACE ACTION 3

// Recuperer les infos de sa planete
$m = $bdd->prepare('SELECT * FROM planete WHERE id = ?');
$m->execute(array($planete_utilise));
$Me=$m->fetch();	


//nos coordonnée

		$NUM_SYSTEME = $Me['numero_systeme'];
		$X = $Me['x'];
		$Y = $Me['y'];

//coordonnée visé
		$NUM_SYST = $Coord_Joueur_vise['numero_systeme'];
		$X_vise = $Coord_Joueur_vise['x'];
		$Y_vise = $Coord_Joueur_vise['y'];
		
		
//depart
$s = $bdd->prepare('SELECT * FROM planete WHERE numero_systeme = ? AND x= ? AND y=?');
$s->execute(array($NUM_SYSTEME,$X,$Y));
$dep=$s->fetch();

//arriver
$s = $bdd->prepare('SELECT * FROM planete WHERE numero_systeme = ? AND x= ? AND y=?');
$s->execute(array($NUM_SYST,$X_vise,$Y_vise));
$ar=$s->fetch();

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

//ON RECUPERE LE TEMPS DANS LA BDD
$RecupTempsDeplacement=$bdd->prepare('SELECT * FROM valeur_deplacement_flotte');
$RecupTempsDeplacement->execute(array());
$RTD=$RecupTempsDeplacement->fetch();

$CaseDeplacement = $RTD['case_map'];
$SystemeDeplacement = $RTD['systeme'];
//TEST DE DEPLACEMENTS

$temps_systeme = $ns * $CaseDeplacement;
$temps_case = $total_case * $SystemeDeplacement;

$temps_general = $temps_case + $temps_systeme;


?>

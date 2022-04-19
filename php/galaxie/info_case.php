<?php

if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

		
	$pseudo_membre = strip_tags($_POST['joueur']);
	$type = strip_tags($_POST['type']);
	$coord_spa = strip_tags($_POST['coordonnee_spatial']);
	$coord_t = strip_tags($_POST['coordonnee_terrestre']);
	$num = strip_tags($_POST['numero_systeme']);
	
	if($pseudo_membre == "")
	{
		$pseudo_membre = "Aucun";
	}

	
	if($coord_t == "")
	{
		$coord_t = "Aucun";
	}
	
	//On récupère l'id du membre via les coordonnee_terrestre 
	$m=$bdd->prepare('SELECT * FROM planete WHERE coordonnee_spatial = ? ');
	$m->execute(array($coord_spa));
	$mbr=$m->fetch();
	
	$id_m = $mbr['id_membre'];
	$x = $mbr['x'];
	$y = $mbr['y'];
	


	
	$fl=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE systeme = ? AND x = ? AND y=?');
	$fl->execute(array($num,$x,$y));
	$f=$fl->fetch();

	$compte=$fl->rowCount();
	
	$m2=$bdd->prepare('SELECT * FROM membre WHERE id = ? ');
	$m2->execute(array($f['id_membre']));
	$mb=$m2->fetch();
	

	$PS = $mb['pseudo'];
	
	if($PS == "")
	{
		$PS = "Aucun";
	}

	
	if($compte == "")
	{
		$compte = 0;
	}

header('Location: '.pathView().'galaxie/galaxie.php?numero_systeme=' . $num . '&coordonnee_spatial=' . $coord_spa . '&pseudo_membre=' . $pseudo_membre . '&coordonnee_terrestre=' . $coord_t . '&nombre_vaisseau=' . $compte . '&joueur=' . $PS . '');
	
}

?>
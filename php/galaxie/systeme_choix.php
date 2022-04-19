<?php

if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

	$numero_systeme = strip_tags($_POST['numero_systeme']);
if(!empty($numero_systeme))
{
	if(is_numeric($numero_systeme))
	{
		
	
		if($numero_systeme <= 0)
		{
		
		$numero_systeme = 1;
		}
		
		if($numero_systeme >=301)
		{
		
		$numero_systeme = 300;
		}	
		
//mise à jour sdes position des flottes dans l'espace

$fl=$bdd->prepare('SELECT * FROM vaisseau_position_espace WHERE systeme = ?');
$fl->execute(array($numero_systeme));
while($f=$fl->fetch())
{
	
$fx = $f['x'];
$fy = $f['y'];	

$pos=$bdd->prepare('UPDATE planete SET image = ? , case_numero = ? WHERE numero_systeme = ? AND x = ? AND y = ? AND case_numero = ? ');
$pos->execute(array("23.png",4,$numero_systeme,$fx,$fy,1));
}



$g=$fl->rowCount();

//Si aucun vaisseau on remplace par le numero 22
if($g == 0)
{
	
$pos=$bdd->prepare('UPDATE planete SET image = ? , case_numero = ? WHERE image = ? AND case_numero = ?');
$pos->execute(array("22.png",1,"23.png",4));
	
}
				header('Location: '.pathView().'galaxie/galaxie.php?numero_systeme=' . $numero_systeme . '');


}
else
$_SESSION['error'] = '<p class="red">Erreur.Utilisez un chiffre.</p>';
		
}
else
$_SESSION['error'] = '<p class="red">Le champs ne peut être vide.</p>';

	
}
?>
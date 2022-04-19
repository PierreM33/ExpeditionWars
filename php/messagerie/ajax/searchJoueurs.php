<?php

if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

	$users = array();

	if(isset($_POST['pseudo']) && !empty($_POST['pseudo']))
	{
		$reqSearch = $bdd->query("SELECT pseudo FROM membre WHERE pseudo LIKE '%" . htmlentities($_POST['pseudo'], ENT_QUOTES, "UTF-8") . "%' LIMIT 4");
		while($donSearch = $reqSearch->fetch())
			$users[] = $donSearch['pseudo'];
	}

	echo json_encode($users);
}

?>
<?php

if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
		
		if(!empty(strip_tags($_POST['strategie'])) OR strip_tags($_POST['strategie']) == 0 )
		{
				$nombre_strategie = strip_tags($_POST['strategie']);
				
				if(is_numeric($nombre_strategie))
				{			
							if($nombre_strategie >= 0 AND $nombre_strategie <= 100)
							{
								
								$a=$bdd->prepare('UPDATE strategie SET pourcentage_attaque_au_defense = ? WHERE id_membre = ?');
								$a->execute(array(strip_tags($_POST['strategie']),$id_membre));
								
								$_SESSION['error'] = '<p class="green">Pourcentage modifi&eacute; avec succ&egrave;s.</p>';
							}
							else
								$_SESSION['error']='<p class="red">Impossible de mettre un nombre n&eacute;gatif.</p>';
				}
				else
					$_SESSION['error'] = '<p class="red">Vous devez et ne pouvez mettre qu\'un chiffre ou un nombre.</p>';
		
		}
		else
			$_SESSION['error'] = '<p class="red">Impossible d\'avoir un champs vide.</p>';

}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'/hangar/strategie.php');

?>
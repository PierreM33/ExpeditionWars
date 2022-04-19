<?php

	
if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
		
		if(!empty($_POST['nombre_tour']))
		{
			
			$nombre_tour = strip_tags($_POST['nombre_tour']);
				//doit etre un nombre
				if(is_numeric($nombre_tour))
				{			
					if($nombre_tour > 0)
						{
								if($nombre_tour >= 5 AND $nombre_tour <= 20)
								{
									
									$a=$bdd->prepare('UPDATE strategie SET sortie_chasseur = ? WHERE id_membre = ?');
									$a->execute(array($nombre_tour,$id_membre));
									
									$_SESSION['error'] = '<p class="green">Nombre de tour modifi&eacute; avec succ&egrave;s.</p>';
								}
								else
									$_SESSION['error']='<p class="red">Impossible de mettre un nombre n&eacute;gatif.</p>';
						}
						else
						$_SESSION['error'] = '<p class="red">Vous ne pouvez pas mettre un chiffre n&eacute;gatif.</p>';
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
<?php

	
if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
			
			$colonisation_actif = strip_tags($_POST['colonisation_actif']);
				//doit etre un nombre
				if(is_numeric($colonisation_actif))
				{			
					if($colonisation_actif == 0 OR $colonisation_actif == 1)
						{

									
									$a=$bdd->prepare('UPDATE strategie SET coloniser_actif = ? WHERE id_membre = ?');
									$a->execute(array($colonisation_actif,$id_membre));
									
									$_SESSION['error'] = '<p class="green">Nombre de tour modifi&eacute; avec succ&egrave;s.</p>';
								
						}
						else
						$_SESSION['error'] = '<p class="red">Vous ne pouvez pas mettre un chiffre n&eacute;gatif.</p>';
				}
				else
					$_SESSION['error'] = '<p class="red">Vous devez et ne pouvez mettre qu\'un chiffre ou un neeeeeeeeombre.</p>';

}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'/hangar/strategie.php');

?>
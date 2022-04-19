<?php 
		
if($_POST)
	{
		require_once '../../include/connexion_bdd.php';

$id_planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']);

				$pseudo_allie=strip_tags($_POST['pseudo_allie']);
				$inversion_id=strip_tags($_POST['id_allie']);
						
				$p_n=$bdd->prepare('UPDATE diplomatie SET pacte = ?, demande_attente = ? WHERE id_membre = ? AND pseudo_allie = ?');
				$p_n->execute(array(0,0,$id_membre,$pseudo_allie));
				
				// LECTURE DE SON PSEUDO
				$mm=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
				$mm->execute(array($inversion_id));
				$mm=$mm->fetch();
				
				$race = htmlentities($mm['race']);
				
				if($race == "valhar")
				{
				$in=$bdd->prepare('DELETE FROM evenement_race WHERE id_membre = ?');
				$in->execute(array($id_membre));

				}
				
				echo $_SESSION['error'] = '<p class="red"> Vous avez refusé le pacte avec le jouruer ' . $pseudo_allie . '</p>';

	}
	else
	$_SESSION['error'] = '<p class="red"> Erreur lors de l\'envoie du formulaire refusé.</p>';


header('Location: '.pathView().'diplomatie/pacte.php');

?>
<?php 

if($_POST)
	{

require_once '../../include/connexion_bdd.php';

$id_planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']);

				$pseudo_allie=strip_tags($_POST['pseudo_allie']);
				$inversion_id=strip_tags($_POST['id_allie']);

				$p_o=$bdd->prepare('UPDATE diplomatie SET pacte = ? WHERE id_membre = ? AND pseudo_allie = ?');
				$p_o->execute(array(1,$id_membre,$pseudo_allie));
				
					// LECTURE DE SON PSEUDO
				$mb=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
				$mb->execute(array($id_membre));
				$m=$mb->fetch();
				
				// ON INSERT UNE LIGNE POUR SIGNIFIER QUE L'ON A UN PACTE AVEC LE JOUEUR
				$insert=$bdd->prepare('INSERT INTO diplomatie (id_membre,pseudo_membre,pseudo_allie,id_allie,message,pacte,demande_attente) VALUES ( ?,?,?,?,?,?,?)');
				$insert->execute(array($inversion_id,$pseudo_allie,$m['pseudo'],$id_membre,'msg',1,1));
				
				
					// LECTURE DE SON PSEUDO
				$mm=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
				$mm->execute(array($inversion_id));
				$mm=$mm->fetch();
				
				$race = htmlentities($mm['race']);
				
				if($race == "rahago")
				{
				$in=$bdd->prepare('UPDATE evenement_race SET envoi = ? ,accepter = ? WHERE id_membre = ?');
				$in->execute(array(1,1,$id_membre));

				$n=$bdd->prepare('UPDATE evenement SET bonus = bonus+?  WHERE id_membre = ?');
				$n->execute(array(1,$inversion_id));
				}

				echo $_SESSION['error'] = '<p class="green"> Vous avez accepté le pacte avec le jouruer ' . $pseudo_allie . '</p>';
	}
	else
	$_SESSION['error'] = '<p class="red"> Erreur lors de l\'envoie du formulaire accepté.</p>';			



header('Location: '.pathView().'diplomatie/pacte.php');

?>
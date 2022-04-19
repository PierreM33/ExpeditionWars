<?php 
	
if($_POST)
{
			require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

	if(!empty($_POST['affranchir'])) // Si les post sont remplis
	{ 
			
			// Pour récuprer les valeurs des la table population
			$reqpop=$bdd->prepare("SELECT * FROM population WHERE id_planete = ? "); 
			$reqpop->execute(array($planete_utilise));
			$population=$reqpop->fetch();
				
			//RECUPERE LA RACE DU JOUEUR
			$re=$bdd->prepare("SELECT * FROM membre WHERE id = ? "); 
			$re->execute(array($id_membre));
			$ra=$re->fetch();

			$race = htmlentities($ra['race']);
			
			// REDEFINITION DES VARIABLES
			$popuesclave=$population['esclave'];
			

			$postaffranchir=strip_tags($_POST['affranchir']);

			
			if($popuesclave >= 100)
			{
				
				$r_update_o=$bdd->prepare("UPDATE population SET esclave = esclave-?, population = population+? WHERE id_planete = ?");
				$r_update_o->execute(array(100,100,$planete_utilise));
				
				//$m=$bdd->prepare('UPDATE moral SET moral = moral+? WHERE id_membre = ? AND pseudo_membre = ?');
				//$m->execute(array(1,$id_membre,htmlentities($_SESSION['pseudo'])));
				
				if($race == "orak" OR $race == "droide")
				{
				$m=$bdd->prepare('UPDATE point_honneur SET nombre_point_honneur = nombre_point_honneur-? WHERE id_membre=?');
				$m->execute(array(100,$id_membre));	
				}
				if($race == "humain" OR $race == "valhar")
				{
				$m=$bdd->prepare('UPDATE point_honneur SET nombre_point_honneur = nombre_point_honneur+? WHERE id_membre=?');
				$m->execute(array(100,$id_membre));
				}

				$_SESSION['error']='<p class="green">Vous avez affranchi 100 esclaves.</p>';
								

			}
				else
					$_SESSION['error']='<p class="red">Vous n\'avez pas assez de population.</p>';
	}
	else
	$_SESSION['error']='<p class="red">Une erreur est survenue.</p>';
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'/population/population.php');
?>
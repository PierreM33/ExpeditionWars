<?php

		
if($_POST)
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
		
	if(!empty($_POST['id_cache'])) 
	{ 		
		$id_cache = strip_tags($_POST['id_cache']);
		
		
		//OBJET ont récupère les infos
		$a=$bdd->prepare('SELECT * FROM objet_joueur WHERE id_objet = ? AND id_planete = ?'); 
		$a->execute(array($id_cache,$planete_utilise));
		$OBJ=$a->fetch();
		
		$objet_possede = htmlentities($OBJ['objet_possede']); 
		
				if ($objet_possede > 0)
					{

						

						// il s'agit du bouclier de protection de 24heures donc on retire 1 bouclier a l'activation.
						$up_obj=$bdd->prepare('UPDATE objet_joueur SET nombre_objet=nombre_objet-? WHERE id_planete=? AND id_membre=? AND id_objet=?');
						$up_obj->execute(array(1,$planete_utilise,$id_membre,$id_cache));
						
						$temps = time()+86400; 
						
						//LECTURE DE SELECTION EXPLO JOUEUR
						$selet=$bdd->prepare('INSERT INTO bouclier_joueur (id_membre,id_planete,temps,actif,date) VALUE (?,?,?,?,NOW())');
						$selet->execute(array($id_membre,$planete_utilise,$temps,1));
													
							$_SESSION['error'] = '<p class="green">Bouclier activ&eacute; pendant 24 heures.</p>';
						

				}
				else
				$_SESSION['error'] = '<p class="red"> Vous n\'avez pas débloqué cet objet.</p>';


	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';		
	
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'objet/objet.php');

	?>
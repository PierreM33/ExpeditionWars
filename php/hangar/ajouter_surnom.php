<?php 

if($_POST)
	 {
		 
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

		 $numero_vaisseau = strip_tags($_POST['numero_vaisseau']);
		 $srn = htmlentities(htmlspecialchars(strip_tags($_POST['surnom'])));
		 //Verifier qu'il s'agit bien d'un texte compris entre 5 et 15 caractères.
		 $surnom = strlen($srn); // fonction strlen pour connaitre le nombre de caractères 
		
						if($surnom >= 5 AND $surnom <= 15)
						{
							//ajout du surnom au vaisseau
							$update=$bdd->prepare('UPDATE vaisseau_joueur SET surnom = ? WHERE id = ?');
							$update->execute(array($srn,$numero_vaisseau));
							
							$_SESSION['error'] = '<p class="green">Vous venez de renommer votre vaisseau ' . $srn . ' .</p>';

							header('Location: '.pathView().'hangar/ajouter_surnom.php?numero=' . $numero_vaisseau . '');
			
						}
						else
						$_SESSION['error'] = '<p class="red">Erreur. Le surnom doit &ecirc;tre compris entre 5 et 15 caract&egrave;res.</p>';
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur pendant l\'envoi du formulaire.Contacter le staff.</p>';

header('Location: '.pathView().'hangar/ajouter_surnom.php?numero=' . $numero_vaisseau . '');

	?>	
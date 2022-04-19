<?php



if($_POST)
		{
	require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
				
			//On récupère la valeur du joueur qui a été séléctionné
			$recuperation_id_membre_elu = strip_tags($_POST['vote']);
			
			//il doit etre un nombre
			if(is_numeric($recuperation_id_membre_elu))
				{
					if(!empty($recuperation_id_membre_elu))
						{
							if($recuperation_id_membre_elu > 0)
								{
									
									//Selectionne la ligne de la faction du joueur
									$select=$bdd->prepare('SELECT * FROM faction_joueur WHERE id_membre = ?');
									$select->execute(array($recuperation_id_membre_elu));
									$r=$select->fetch();

									$election=$bdd->prepare('UPDATE faction_joueur SET nombre_de_voix = nombre_de_voix + ? WHERE id_membre = ?');
									$election->execute(array(1,$recuperation_id_membre_elu));
									
									//On ajoute le fait qu'on ai déj&agrave; voté
									//Si le vote a ete effectue il passe sur 1
									$election=$bdd->prepare('UPDATE faction_joueur SET vote_du_joueur=?, vote_effectue=? WHERE id_membre = ?');
									$election->execute(array($r['pseudo_membre'],"Oui",$id_membre));

									$_SESSION['error'] = '<p class="green">Votre vote &agrave; bien &eacute;t&eacute; pris en compte.</p>';
								}
								else		
								$_SESSION['error'] = '<p class="red">Le vote doit &ecirc;tre sup&eacute;rieur &agrave; z&eacute;ro.</p>';
						}
						else		
						$_SESSION['error'] = '<p class="red">Le vote ne peut pas &ecirc;tre vide.</p>';
				}
				else		
				$_SESSION['error'] = '<p class="red">Une erreur s\'est produite lors de l\'envoi du formulaire. Merci de contacter le webmaster du site.</p>';
		}
		else		
		$_SESSION['error'] = '<p class="red">Une erreur s\'est produite lors de l\'envoi du formulaire. Merci de contacter le webmaster du site.</p>';
	
header('Location: '.pathView().'./faction/faction_election.php');

?>
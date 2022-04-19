<?php
if($_POST)
		{
	require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
			//On récupère la valeur de la loi qui a été séléctionné
			$recuperation_numero_loi = strip_tags($_POST['numero']);
			
			//il doit etre un nombre
			if(is_numeric($recuperation_numero_loi))
				{	
					//il ne doit pas être vide
					if(!empty($recuperation_numero_loi))
						{
							// il doit être supérieur à zéro	
							if($recuperation_numero_loi > 0)
								{
									//ON RECUPERE LE NOM DE LA FACTION
									$mo=$bdd->prepare(' SELECT * FROM faction_joueur WHERE id_membre = ?');
									$mo->execute(array($id_membre));
									$f=$mo->fetch();

									$fa=$bdd->prepare(' SELECT * FROM faction WHERE nom_faction = ?');
									$fa->execute(array(htmlentities($f['nom_faction'])));
									$FA=$fa->fetch();
									
									//Selectionne la ligne de la faction du joueur
									$select=$bdd->prepare('UPDATE faction SET nombre_loi = nombre_loi - ? WHERE nom_faction = ?');
									$select->execute(array(1,$FA['nom_faction']));
									$r=$select->fetch();

									$election=$bdd->prepare('UPDATE faction_loi SET adopte = ?, indisponible = ? WHERE id = ?');
									$election->execute(array(1,1,$recuperation_numero_loi));
									

									$_SESSION['error'] = '<p class="green">Votre vote &agrave; bien &eacute;t&eacute; pris en compte.</p>';
								}
								else		
								$_SESSION['error'] = '<p class="red">Le vote doit &ecirc;tre sup&eacute;rieur &agrave; z&eacute;ro.</p>';
						}
						else		
						$_SESSION['error'] = '<p class="red">Le vote ne peut pas &ecirc;tre vide.</p>';
				}
				else		
				$_SESSION['error'] = '<p class="red">Il ne peut s\'agir que d\'un numéro.</p>';
		}
		else		
		$_SESSION['error'] = '<p class="red">Une erreur s\'est produite lors de l\'envoi du formulaire. Merci de contacter le webmaster du site.</p>';
	
header('Location: '.pathView().'./faction/administration_faction.php');

?>
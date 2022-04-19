<?php
@ini_set('display_errors', 'on');
if($_POST)  // Si je valide le bouton se connecter
{
	
	include("../../include/connexion_bdd.php");
					
	if(!empty($_POST['pseudoconnex']) && !empty($_POST['mdpconnex']))
	{
		if(!isset($_SESSION['id']) || empty($_SESSION['id']) && !isset($_SESSION['pseudo']) || empty($_SESSION['pseudo']))
		{
			$pseudo = strip_tags(htmlspecialchars($_POST['pseudoconnex']));	
			$passw = strip_tags(sha1($_POST['mdpconnex']));
			
			// Recherche le pseudo du joueur dans la bdd si il n'y est pas c'est ok
			$requser = $bdd->prepare('SELECT * FROM membre WHERE pseudo = ? AND mdp = ?'); 
			$requser->execute(array($pseudo,$passw));  
			$pseudoexiste = $requser -> rowCount();
				
			
				
			if($pseudoexiste == 1)
			{
				$verif=$bdd->prepare('SELECT * FROM membre WHERE pseudo = ?');
				$verif->execute(array($pseudo));
				$v=$verif->fetch();
					
				if(htmlentities($v['confirm']) == 1)
				{
					if(htmlentities($v['avertissement']) == 0)
					{
						$userinfo = $requser->fetch();    // Permet de créer les sessions sur le membre 
						$_SESSION['id'] = $userinfo['id'];
						$_SESSION['pseudo'] = $userinfo['pseudo'];
						$_SESSION['mail'] = $userinfo['mail'];
						$_SESSION['point'] = $userinfo['point'];
						$_SESSION['planete_utilise'] = $userinfo['planete_utilise'];
						
							
						// Met à jours toute les energies au dessus de 1.000 de la galaxie à la connexion de n'importe quel joueurs.
						$se=$bdd->prepare('SELECT * FROM ressource');
						$se->execute(array());
						$r=$se->fetch();
							if(htmlentities(htmlspecialchars($r['energie'])) >= 1001)
						{
							$up=$bdd->prepare('UPDATE ressource SET energie = ?');
							$up->execute(array(1000));
						}
						
						
						
						$MAJ=$bdd->prepare('SELECT * FROM connexion_joueur WHERE id_membre = ?');
						$MAJ->execute(array($_SESSION['id']));
						$MA=$MAJ->fetch();

						$restant = htmlentities($MA['temps']) - time();

						//COnnexion du joueur
						if($restant <= 0)
						{
							//On met à jour le temps
							$temps = time()+84600;
							//Insertion du temps de connexion
							$b=$bdd->prepare('UPDATE connexion_joueur SET id_membre = ? , temps = ? , valide = ? WHERE id_membre = ? AND valide = ?');
							$b->execute(array($_SESSION['id'],$temps,0,$_SESSION['id'],1));
						}
						

						//ENVOIE SUR LA SALLE DE CONTROLE
						header("Location: ".pathView()."sdc/salle_de_controle.php"); 
						
					}
					else
					$_SESSION['error_co'] = '<div class="erreur">Votres compte est banni. Rendez-vous sur le discord pour plus de renseignements.</div>';

				}
				else
				$_SESSION['error_co'] = '<div class="erreur">Votre Email n\'est pas confirmé.</div>';

			}			
			else
			$_SESSION['error_co'] = '<div class="erreur">Pseudo ou mot de passe incorrect.</div>';
				
		}
		else
		$_SESSION['error_co'] = '<div class="erreur">Les identifiants sont incorrect.</div>';

	}
	else
	$_SESSION['error_co'] = '<div class="erreur">Veuillez remplir tous les champs.</div>';

}
else
$_SESSION['error_co'] = '<div class="erreur">Un problème est survenu lors de l\'envoi du formulaire. Merci de contacter le webmaster du site.</div>';
	
header("Location: ../../index.php");
?>




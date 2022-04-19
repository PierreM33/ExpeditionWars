<?php	
 @ini_set('display_errors', 'on');
 
if($_POST['accepter'])
{
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
	
			//on selectionne la troupe "soldat"
			$req=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?'); 
			$req->execute(array($planete_utilise));
			$soldat=$req->fetch();
			
			if(htmlentities(htmlspecialchars($soldat['soldat'])) >= 100)			
			{
				//Soustrait les soldats au joueurs
				$r=$bdd->prepare('UPDATE population SET soldat = soldat-? WHERE id_planete = ?');
				$r->execute(array(100,$planete_utilise));
				
				// RECUPERE territoire
				$ter=$bdd->prepare('SELECT * FROM territoire_planete WHERE id_planete = ? AND id_membre=?'); 
				$ter->execute(array($planete_utilise,$id_membre));
				$territoire=$ter->fetch();
				
					if($territoire['territoire_decouvert'] < 7) 
					{
						
						$ter=$bdd->prepare('UPDATE territoire_planete SET territoire_decouvert=territoire_decouvert+? WHERE id_planete = ? AND id_membre=?'); 
						$ter->execute(array(1,$planete_utilise,$id_membre));
						
					
						//PERMET DE SELECTIONNER UN CHIFFRE AU HASARD ENTRE 1 ET 8 QUI DONNE LA MINE OU NON
						$selection = rand(0,7);
						
						

						if($selection >= 1 AND $selection <= 5)						
						{

						
						//ON UPDATE LA MINE
						$s=$bdd->prepare('UPDATE mines_joueur SET mine_possede = ? WHERE id_planete = ? AND id_mine=?'); 
						$s->execute(array(1,$planete_utilise,$selection));
						
							//NOM DES MINES
							if($selection == 1)
							{
								$NomMine = " Mine d'Or";
							}
							if($selection == 2)
							{
								$NomMine = " Mine de Titane";
							}
							if($selection == 3)
							{
								$NomMine = " Mine de Cristal";
							}
							if($selection == 4)
							{
								$NomMine = " Mine d'Orinia";
							}
							if($selection == 5)
							{
								$NomMine = " Mine d'Orinium";
							}
						
						
						$_SESSION['error'] = '<p class="green">Territoire recherché, vous avez trouvé une ' . $NomMine . '.</p>';
						}						
						else
						$_SESSION['error'] = '<p class="red">Vous venez d\'explorer une partie du territoire de votre planète aucun gisement de mine présent.</p>';
					}
					else
					$_SESSION['error'] = '<p class="red">Impossible de d&eacute;passer les 100% du territoire.</p>';

			}
			else
				$_SESSION['error'] = '<p class="red">Vous devez poss&eacute;der 100 soldats pour explorer votre plan&egrave;te.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';
	
header('Location: '.pathView().'sdc/salle_de_controle.php');
?>
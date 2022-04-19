<?php 
@ini_set('display_errors', 'on');
if($_POST)
{
			require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
	

	if(!empty($_POST['ouvrier']) || !empty($_POST['civil']) || !empty($_POST['soldat']) || !empty($_POST['chercheur']) || !empty($_POST['pilote'])) // Si les post sont remplis
	{ 
		if(is_numeric($_POST['ouvrier']) || is_numeric($_POST['civil']) || is_numeric($_POST['soldat']) || is_numeric($_POST['chercheur']) || is_numeric($_POST['pilote'])) 
		{ 

			$reqpop=$bdd->prepare("SELECT * FROM population WHERE id_planete = ? "); /* Pour récuprer les valeurs des la table population */
			$reqpop->execute(array($planete_utilise));
			$population=$reqpop->fetch();

			// QUETE NUMERO 4
			$rq=$bdd->prepare('SELECT * FROM quete WHERE  numero_quete = ? AND id_membre = ? '); 
			$rq->execute(array(4,$id_membre));
			$quete_fini=$rq->fetch();
			

			if($quete_fini['valide'] == 0)
			{
			$req=$bdd->prepare('UPDATE quete SET valide=? WHERE id_membre= ? AND numero_quete = ?');
			$req->execute(array(1,$id_membre,4));
				}	
						
						
			// REDEFINITION DES VARIABLES
			$populationsimple=$population['population'];
		
			$popuouvrier=$population['ouvrier'];
			$popucivil=$population['civil'];
			$popusoldat=$population['soldat'];
			$popuchercheur=$population['chercheur'];
			$popupilote=$population['pilote'];
			$popuesclave=$population['esclave'];
			$popuglobal=$popucivil+$popusoldat+$popuchercheur+$popuesclave+$popupilote+$popuouvrier;

			$postouvrier=strip_tags($_POST['ouvrier']);
			$postsoldat=strip_tags($_POST['soldat']);
			$postchercheur=strip_tags($_POST['chercheur']);
			$postcivil=strip_tags($_POST['civil']);
			$postpilote=strip_tags($_POST['pilote']);

			if (($postouvrier <= $populationsimple) AND ($postcivil <= $populationsimple) AND ($postsoldat <= $populationsimple) AND ($postchercheur <= $populationsimple) AND ($postpilote <= $populationsimple))
			{
				if($postpilote+$postcivil+$postchercheur+$postsoldat+$postouvrier >= 0)
					{
						if($postpilote+$postcivil+$postchercheur+$postsoldat+$postouvrier <= $populationsimple)
						{
							if(($postouvrier >= 0) AND ($postcivil >= 0) AND ($postsoldat >= 0) AND ($postchercheur >= 0) AND ($postpilote >= 0)) // Verifie que pour chaque classe ce soit supérieur à 0
							{
										
								$retrait_total=$postouvrier+$postsoldat+$postchercheur+$postcivil+$postpilote;
																							
								$r_update_o=$bdd->prepare("UPDATE population SET ouvrier = ouvrier+?, civil=civil+?, soldat=soldat+?, chercheur=chercheur+?, pilote=pilote+?,  population = population-? WHERE id_planete = ?");
								$r_update_o->execute(array($postouvrier,$postcivil,$postsoldat,$postchercheur,$postpilote,$retrait_total,$planete_utilise));
								
								$_SESSION['error']='<p class="green">Population formée avec succès.</p>';
								
							}
							else
								$_SESSION['error']='<p class="red">Impossible de mettre un nombre négatif.</p>';
						}
							else
								$_SESSION['error']='<p class="red">Vous n\'avez pas assez de population.</p>';
					}
						else
							$_SESSION['error']='<p class="red">Impossible de mettre un nombre négatif sur plusieurs champs.</p>';	
			}
			else
				$_SESSION['error'] = '<p class="red">Vous n\'avez pas assez de population.</p>';
		}
		else
			$_SESSION['error'] = '<p class="red">Vous devez et ne pouvez mettre qu\'un chifre ou un nombre.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Vous devez remplir au moins un des champs.</p>';
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'/population/population.php');
?>
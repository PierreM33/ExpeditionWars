<?php


	
if($_POST)
{
	
			require_once '../../include/connexion_bdd.php';
			$planete_utilise=htmlentities($_SESSION['planete_utilise']);
			$id_membre=htmlentities($_SESSION['id']); 

			$nom_mine=strip_tags($_POST['nom_mine']);
		$id_mine=strip_tags($_POST['id_cache']);
		
		
	if($_POST['nom'] == 'Mine d\'Or'){
		$mine = 'mine_gold';
	}
	elseif($_POST['nom'] == 'Mine de Titane'){
		$mine = 'mine_titane';
	}
	elseif($_POST['nom'] == 'Mine de Cristal'){
		$mine = 'mine_cristal';
	}
	elseif($_POST['nom'] == 'Mine d\'Orinia'){
		$mine = 'mine_orinia';
	}
	elseif($_POST['nom'] == 'Mine d\'Orinium'){
		$mine = 'mine_orinium';
	}
	else $mine = 'mine_organique';
	
	

	
	$r_p=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_mine = ? AND id_planete = ?');
	$r_p->execute(array($id_mine,$planete_utilise));
	$M=$r_p->fetch();
							
	$ouvrier = $M['ouvrier'];
	$esclave = $M['esclave'];

	$total = $ouvrier + $esclave;
		
		if(!empty($_POST['nom']))
		{			
					
																
					/* MET A JOUR LE CHAMP OUVRIER DANS TABLE MINE */
					$req_deduction_ouvrier_preforme=$bdd->prepare("UPDATE mines_joueur SET ouvrier = ouvrier - ?, esclave = esclave - ? WHERE id_planete = ? AND id_mine = ?");
					$req_deduction_ouvrier_preforme->execute(array($ouvrier,$esclave,$planete_utilise,$id_mine));

																
					/* MET A JOUR LE CHAMP ESCLAVE DANS TABLE POPULATION */
					$req_modif_esclave_stock=$bdd->prepare("UPDATE population SET population = population+? WHERE id_planete = ?");
					$req_modif_esclave_stock->execute(array($total,$planete_utilise));
					
					//On retire les 100 de Matière organique
					$R=$bdd->prepare('UPDATE membre SET credit=credit-? WHERE id=?');
					$R->execute(array(100,$id_membre));
												
							$_SESSION['error']='<p class="green">Mine remise à zéro.</p>';

		}
		else
			$_SESSION['error']='<p class="red">Cette mine n\'existe pas.</p>';
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'mines/' . $mine . '.php');				


?>
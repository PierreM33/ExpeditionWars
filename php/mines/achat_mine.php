<?php

	
if($_POST)
{
	
			require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
	
	$nom_mine=strip_tags($_POST['nom_mine']);
	
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
	
	

	
	$r_p=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?');
	$r_p->execute(array($planete_utilise));
	$a_p=$r_p->fetch();
							
	$ouvrier_preforme=$a_p['ouvrier'];
	$esclave_preforme=$a_p['esclave'];
	$post=strip_tags($_POST['id_cache']);
	
	if(is_numeric($_POST['ouvrier'])|| is_numeric($_POST['esclave']))
	{ 	
		if(!empty($_POST['nom']))
		{
			if(strip_tags($_POST['ouvrier']) >= 0)
			{
				if($_POST['ouvrier']<= $ouvrier_preforme)
				{			
					
					$post_ouvrier=strip_tags($_POST['ouvrier']);
					$post_esclave=strip_tags($_POST['esclave']);
																
					/* MET A JOUR LE CHAMP OUVRIER DANS TABLE MINE */
					$req_deduction_ouvrier_preforme=$bdd->prepare("UPDATE mines_joueur SET ouvrier = ouvrier + ? WHERE id_planete = ? AND id_mine = ?");
					$req_deduction_ouvrier_preforme->execute(array($post_ouvrier,$planete_utilise,$post));
																
					/* MET A JOUR LE CHAMP OUVRIER DANS TABLE POPULATION */
					$req_modif_ouvrier_stock=$bdd->prepare("UPDATE population SET ouvrier = ouvrier- ? WHERE id_planete = ? ");
					$req_modif_ouvrier_stock->execute(array($post_ouvrier,$planete_utilise));
																						
					/* ON AJOUTE POUR LES ESCLAVES */
					if(strip_tags($_POST['esclave']) >= 0)
					{
						if($_POST['esclave']<= $esclave_preforme)
						{
												
							/* MET A JOUR LE CHAMP ESCLAVE DANS TABLE MINE */
							$req_deduction_esclave_preforme=$bdd->prepare("UPDATE mines_joueur SET esclave = esclave + ? WHERE id_planete = ? AND id_mine = ?");
							$req_deduction_esclave_preforme->execute(array($post_esclave,$planete_utilise,$post));
																									
							/* MET A JOUR LE CHAMP ESCLAVE DANS TABLE POPULATION */
							$req_modif_esclave_stock=$bdd->prepare("UPDATE population SET esclave = esclave- ? WHERE id_planete = ?");
							$req_modif_esclave_stock->execute(array($post_esclave,$planete_utilise));
												
							$_SESSION['error']='<p class="green">Modification effectuée.</p>';
						}
						else
							$_SESSION['error']='<p class="red">Pas assez d\'esclaves disponible. Rendez-vous dans la gestion de votre population.</p>';
					}
					else
						$_SESSION['error']='<p class="red">Impossible de mettre une valeur négative.</p>';
				}
				else
					$_SESSION['error']='<p class="red">Pas assez d\'ouvriers disponible. Rendez-vous dans la gestion de votre population.</p>';
			}
			else
				$_SESSION['error']='<p class="red">Impossible de mettre une valeur négative.</p>';
		}
		else
			$_SESSION['error']='<p class="red">Cette mine n\'existe pas.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Vous devez entrer un nombre.</p>';
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'mines/' . $mine . '.php');				

?>

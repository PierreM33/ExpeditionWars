<?php 

if($_POST)
	 {
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
		$id_membre=htmlentities($_SESSION['id']); 
		
		

			$IdChasseur = strip_tags($_POST['numero']);
			$IdHote = strip_tags($_POST['hote']);
			
			echo $IdChasseur;
			echo $IdHote;
			
			//ON VA UPDATE LA LISTE DE VAISSEAU ET AJOUTER LE VAISSEAU DANS LE VAISSEAU HOTE
			$Update=$bdd->prepare('UPDATE vaisseau_joueur SET id_vaisseau_hote = ?, disponible = ? WHERE id = ?');
			$Update->execute(array(0,0,$IdChasseur));
			
			//ON VA INFORMER LE VAISSEAU HOTE QU'IL POSSEDE UN CHASSEUR DANS SON STOCK
			$Update=$bdd->prepare('UPDATE vaisseau_joueur SET limite_chasseur = limite_chasseur-? WHERE id = ?');
			$Update->execute(array(1,$IdHote));

			
			$_SESSION['error'] = '<p class="green">Le vaisseau à été retiré.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';
	
header('Location: '.pathView().'hangar/decharger_vaisseaux.php?numero= ' . $IdHote . '.php'); 
	?>	
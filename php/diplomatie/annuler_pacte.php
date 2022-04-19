<?php

//VA PERMETTRE AUX JOUEURS D'ANNULER LES PACTES QU'ILS ONT ENTRE EUX.

if($_POST)
	{
		require_once '../../include/connexion_bdd.php';
		$id_planete_utilise=htmlentities($_SESSION['planete_utilise']);
		$id_membre=htmlentities($_SESSION['id']);
		
		//ON RECUPERE LE NUMERO DU FORMULAIRE DANS NAME, IL S'AGIT DU NUMERO DE ID_ALLIE
		$IdPacte = strip_tags($_POST['numero']);
		
		//ON RECUPERE LES INFOS DE LE TABLE
		$I=$bdd->prepare('SELECT * FROM diplomatie WHERE id_allie = ? AND id_membre = ?');
		$I->execute(array($IdPacte,$id_membre));
		$InfoPacte=$I->fetch();
		
		$PseudoAllie = $InfoPacte['pseudo_allie'];
		$PseudoJoueur = $InfoPacte['pseudo_membre'];
		
		//ON VA UPDATE LA BDD EN SUPPRIANT LA LIGNE DES DEUX NUMERO CONCERNE
		$del=$bdd->prepare('DELETE FROM diplomatie WHERE id_allie = ? AND id_membre = ?');
		$del->execute(array($IdPacte,$id_membre));
		
		//ON SUPPRIMER LE SECOND JOUEUR
		$del2=$bdd->prepare('DELETE FROM diplomatie WHERE id_allie = ? AND id_membre = ?');
		$del2->execute(array($id_membre,$IdPacte));
		
		//ENVOIE DU MESSAGE AUX DEUX MEMBRES
		$message1=" Le joueur " . $PseudoJoueur . " à annulé le pacte avec votre Empire. Il lui sera maintenant possible de vous attaquer.";
				
		$msg1=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
		$msg1->execute(array($id_membre,$IdPacte,$message1,time(),0,"Fin de pacte"));
		
		$message=" Vous avez annulé le pacte avec le joueur : " . $PseudoAllie . " ";
				
		$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
		$msg->execute(array($IdPacte,$id_membre,$message,time(),0,"Fin de pacte"));
		
		$_SESSION['error'] = '<p class="green"> Vous n\'êtes plus allié avec le joueur ' . $PseudoAllie . '. Envoyer un diplomate pour un prochain pacte.</p>';
		
		
	}
	else
	$_SESSION['error'] = '<p class="red"> Erreur lors de l\'envoie du formulaire refusé.</p>';


header('Location: '.pathView().'diplomatie/pacte.php');
?>
<?php 

if($_POST['diplomatie'])
		{
			
			require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);
	
	// OBTENIR LA LISTE DES UNITES DIPLOMATE DE LA PLANETE SELECTIONNE
	$nb_dipl=$bdd->prepare('SELECT * FROM caserne_joueur WHERE id_planete = ? AND id_caserne = ?');
	$nb_dipl->execute(array($planete_utilise,1));
	$e=$nb_dipl->fetch();
	// LECTURE DE VOTRE PSEUDO
	$mb=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$mb->execute(array($id_membre));
	$membre=$mb->fetch();
	
	// RECUPERER LID DE LA PORTE CONNECTE
	$v=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$v->execute(array($planete_utilise));
	$id_porte_connecte=$v->fetch();

	// PERMET DE RECUPERER L'ID DU MEMBRE
	$ve=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$ve->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
	$cible=$ve->fetch();
	
	// LECTURE PSEUDO DU JOUEUR OU L'ON A OUVERT LE VORTEX
	$mb=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$mb->execute(array(htmlentities($cible['id_membre'])));
	$m=$mb->fetch();
	
	// REQUETE POUR VERIFIER QUE LE JOUEUR N'A PAS DEJA ENVOYER UNE DEMANDE DE PACTE
	$pacte=$bdd->prepare('SELECT * FROM diplomatie WHERE id_membre = ? AND id_allie = ? ');
	$pacte->execute(array(htmlentities($cible['id_membre']),$id_membre));
	$p=$pacte->fetch();

	
	
			if( $p['demande_attente'] == 0 )
				{
					$up=$bdd->prepare('UPDATE caserne_joueur SET nombre_unite = nombre_unite-? WHERE id_planete = ? AND id_caserne = ?');// Retire 1 diplomate au joueur qui l'envoie.
					$up->execute(array(1,$planete_utilise,2));
					
					// Message qui sera affiché dans la messagerie du joueur qui envoie le diplomate.
					$message=" Votre diplomate traverse le vortex pour se rendre sur la planète sélectionnée et entamer des négociations. ";
					// Insertion du message
					$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
					$msg->execute(array($id_membre,$id_membre,$message,time(),0,"Rapport de diplomatie avec le joueur " . htmlentities($m['pseudo']) . ""));
					
					// Message qui sera affiché dans la messagerie du joueur qui recoie le diplomate.
					$messagedeux=" Vous venez de recevoir la visite d'un diplomate venant d'une autre planète. Celui-ci vous propose une alliance officielle permettant une entraide pour les combats spatiaux si vos flottes se retrouvent au même endroit. 
					RENDEZ VOUS DANS L'ONGLET DIPLOMATIE POUR ACCEPTER OU REFUSER LE PACTE.";
					// Insertion du message
					$msgd=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
					$msgd->execute(array($id_membre,htmlentities($cible['id_membre']),$messagedeux,time(),0," Reception du diplomate du joueur " . htmlentities($membre['pseudo']) . ""));
					
					//Envoie de la demande de pacte dans la page concerné
					$mess="Demande de signer un traîté pour un pacte entre nos armées et nos négociations.";
					$pacte=$bdd->prepare('INSERT INTO diplomatie (id_membre,pseudo_membre,pseudo_allie,id_allie,message,pacte,demande_attente) VALUES (?,?,?,?,?,?,?) ');
					$pacte->execute(array(htmlentities($cible['id_membre']),htmlentities($m['pseudo']),htmlentities($membre['pseudo']),htmlentities($membre['id']),$mess,2,1));
		
					$_SESSION['error'] = '<p class="green">Votre diplomate vient de traverser la porte. Un message vous à été envoyé dans votre boite mail.</p>';
				}
				else
				$_SESSION['error'] = '<p class="red">Vous avez déjà envoyé une demande de diplomatie avec ce joueur.</p>';	
		}
		else
		$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoi du formulaire.</p>';
		
header('Location: '.pathView().'vortex/envoyer_diplomate.php');


?>
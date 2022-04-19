<?php

	
if($_POST)
	{		
require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);

	
	// RECUPERER LID DE LA PORTE CONNECTE
	$v=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$v->execute(array($planete_utilise));
	$id_porte_connecte=$v->fetch();

	// PERMET DE RECUPERER L'ID DU MEMBRE
	$ve=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$ve->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
	$cible=$ve->fetch();
	
	$rm=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$rm->execute(array(htmlentities($cible['id_membre'])));
	$req_m=$rm->fetch();
	
	
			$ress=$bdd->prepare('SELECT * FROM ressource WHERE id_planete = ? AND id_membre = ?');
			$ress->execute(array($planete_utilise,$id_membre));
			$stock=$ress->fetch();
			
			//JOUEUR ENVOYEUR
			$pop=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?');
			$pop->execute(array($planete_utilise));
			$popu=$pop->fetch();	

			//JOUEUR RECOIT
			$popR=$bdd->prepare('SELECT * FROM population WHERE id_planete = ?');
			$popR->execute(array($id_porte_connecte['porte_connecte']));
			$popuR=$popR->fetch();		

			//infrastructure
			$infra=$bdd->prepare('SELECT * FROM infrastructure WHERE id_planete = ?');
			$infra->execute(array(htmlentities($id_porte_connecte['porte_connecte'])));
			$IF=$infra->fetch();
			
					$gold=strip_tags($_POST['gold']);
					$titane=strip_tags($_POST['titane']);
					$cristal=strip_tags($_POST['cristal']);
					$orinia=strip_tags($_POST['orinia']);
					$orinium=strip_tags($_POST['orinium']);
					$organique=strip_tags($_POST['organique']);
					$population=strip_tags($_POST['population']);
					
					//On calcul la liite de population
					$limite_population = $IF['limite'] - htmlentities($popuR['population']);


		if(is_numeric($_POST['gold']) AND is_numeric($_POST['titane']) AND is_numeric($_POST['cristal']) AND is_numeric($_POST['orinia']) AND is_numeric($_POST['orinium']) AND is_numeric($_POST['organique']) AND is_numeric($_POST['population']))
			{ 
				if($_POST['gold'] OR $_POST['titane'] OR $_POST['cristal'] OR $_POST['orinia'] OR $_POST['orinium'] OR $_POST['organique'] OR $_POST['population'] > 0)
					{ 
						if ((htmlentities($popu['population']) >= $population) AND (htmlentities($stock['gold']) >= $gold) AND (htmlentities($stock['titane']) >= $titane) AND (htmlentities($stock['cristal']) >= $cristal) AND (htmlentities($stock['orinia']) >= $orinia) AND (htmlentities($stock['orinium']) >= $orinium) AND(htmlentities($stock['organique']) >= $organique)) // Permet de vérifier que ses stocks soit sup à la demande d'achat d'or
							{		

								//On va verifier que le joueur peut recevoir de la population
								if( $limite_population >= $population OR empty($population))
								{

							
								//JOUEUR ENVOYEUR
								$envoyeur=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
								$envoyeur->execute(array($id_membre));
								$env=$envoyeur->fetch();
								
								// LECTURE DU PSEUDO DU MEMBRE ALLIE - EGALEMENT FICTIF ACTUELLEMENT JOUEUR 2
								$mb=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
								$mb->execute(array(htmlentities($cible['id_membre'])));
								$m=$mb->fetch();

								
								$id_planete_recepteur=htmlentities($id_porte_connecte['porte_connecte']); // A REMPLACER PLUS TARD PAR LE PSEUDO DE LA PLANETE VISE
								$pseudo_recepteur=htmlentities($req_m['pseudo']); // A REMPLACER PLUS TARD PAR LE PSEUDO DE LA PLANETE VISE
								

								//MAJ POPULATION
								$maj=$bdd->prepare('UPDATE population SET population=population-? WHERE id_planete = ?');
								$maj->execute(array($population,$planete_utilise));
								
								//MAJ POPULATION RECEPTEUR
								$maja=$bdd->prepare('UPDATE population SET population=population+? WHERE id_planete = ?');
								$maja->execute(array($population,$id_planete_recepteur));
								
								// MISE A JOUR DES RESSOURCES DE L'ENVOYEUR
								$majb=$bdd->prepare('UPDATE ressource SET gold=gold-?, titane=titane-?, cristal=cristal-?, orinia=orinia-?, orinium=orinium-?, organique=organique-? WHERE id_planete = ? AND id_membre = ?');
								$majb->execute(array($gold,$titane,$cristal,$orinia,$orinium,$organique,$planete_utilise,$id_membre));
								
								//SAVE DANS LA BDD DE L'ECHANGE
								$save=$bdd->prepare('INSERT INTO echange_joueur (id_planete_envoyeur,pseudo_envoyeur,id_planete_recepteur,pseudo_recepteur,population,gold,titane,cristal,orinia,orinium,organique,date_echange) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW())');
								$save->execute(array($planete_utilise,htmlentities($env['pseudo']),$id_planete_recepteur,$pseudo_recepteur,$population,$gold,$titane,$cristal,$orinia,$orinium,$organique));
								
								// MISE A JOUR DES RESSOURCES DU RECEPTEUR
								$allie=$bdd->prepare('UPDATE ressource SET gold=gold+?, titane=titane+?, cristal=cristal+?, orinia=orinia+?, orinium=orinium+?, organique=organique+? WHERE id_planete = ? AND id_membre = ?');
								$allie->execute(array($gold,$titane,$cristal,$orinia,$orinium,$organique,$id_planete_recepteur,htmlentities($cible['id_membre'])));
								
								
								// Message qui sera affiché dans la messagerie du joueur qui envoie l'échange
								$message=" Résumé de l'échange avec le joueur " . htmlentities($m['pseudo']) . " : </br></br> Population : " . $population . " </br>  -OR : -" . $gold . "</br>- TITANE : -" . $titane . "</br>- CRISTAL : -" . $cristal . "</br>- ORINIA : -" . $orinia . "</br>- ORINIUM : -" . $orinium . "</br>- MATIERE ORGANIQUE : -" . $organique . "";
								// Insertion du message 				
								$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
								$msg->execute(array($id_membre,$id_membre,$message,time(),0,"Rapport d'échange avec le joueur " . htmlentities($m['pseudo']) . ""));
								
								
								// Message qui sera affiché dans la messagerie du joueur qui reçoie
								$message=" Résumé de l'échange avec le joueur " . $env['pseudo'] . " :</br></br> Population : " . $population . " </br>  -OR : " . $gold . "</br>- TITANE : " . $titane . "</br>- CRISTAL : " . $cristal . "</br>- ORINIA : " . $orinia . "</br>- ORINIUM : " . $orinium . "</br>- MATIERE ORGANIQUE : " . $organique . "";
								// Insertion du message 				
								$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
								$msg->execute(array(htmlentities($cible['id_membre']),htmlentities($m['id']),$message,time(),0,"Rapport d'échange avec le joueur " . htmlentities($env['pseudo']) . ""));

								$_SESSION['error'] = '<p class="green">Votre échange s\'est déroulé avec succès.</p>';
								
								}
								else
								$_SESSION['error'] = '<p class="red">La limitation de population de la planète qui reçoit la population sera dépassé, transfert refusé.</p>';
								

						}
							else
							$_SESSION['error'] = '<p class="red">Votre stock de ressources n\'est pas suffisant.</p>';
					}
					else
					$_SESSION['error'] = '<p class="red">Impossible de mettre une valeur négative ou d\'envoyer aucune ressources.</p>';

			}
			else
			$_SESSION['error'] = '<p class="red">Impossible de mettre un nombre négatif.</p>';
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';


header('Location: '.pathView().'vortex/echanger.php');

?>

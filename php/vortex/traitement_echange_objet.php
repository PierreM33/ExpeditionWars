<?php
	
if($_POST)
	{
require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);

	
	// RECUPERER LID DE LA PORTE CONNECTE
	$v=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$v->execute(array($planete_utilise));
	$IdPorteConnecte=$v->fetch();
	
	$PlaneteVise = htmlentities($IdPorteConnecte['porte_connecte']);

	// PERMET DE RECUPERER L'ID DU MEMBRE
	$ve=$bdd->prepare('SELECT * FROM portail WHERE id_planete = ?');
	$ve->execute(array($PlaneteVise));
	$cible=$ve->fetch();
	
	//PSEUDO ENVOYEUR
	$Psd=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$Psd->execute(array($id_membre));
	$Pseu=$Psd->fetch();
	
	//PSEUDO CIBLE
	$PsdVise=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
	$PsdVise->execute(array($MembreVise));
	$PseuVise=$PsdVise->fetch();
	
	$MembreVise = htmlentities($cible['id_membre']);

	
	
	//RARE
	$IdObjetRare = strip_tags($_POST['IdObjetRare']);
	//AMULETTE
	$NombreAmul = strip_tags($_POST['NombreAmul']);	
	//DIAMANT
	$NombreDiamant = strip_tags($_POST['NombreDiamant']);

	//VERIFICATION DU STOCK CELON LES ID OBJET RARES
	$Stock=$bdd->prepare('SELECT * FROM objet_rare WHERE id_objet_rare = ? AND id_membre = ? AND id_planete = ?');
	$Stock->execute(array($IdObjetRare,$id_membre,$planete_utilise));
	$SockRare=$Stock->fetch();
	
	$NombreStockRare = $SockRare['nombre_objet'];
	
	
			
	//COMMUN
	$IdObjet = strip_tags($_POST['IdObjet']);
	$NombreObjet = strip_tags($_POST['Nombre']);
	
	//IDENTITE OBJET
	$Obj1=$bdd->prepare('SELECT * FROM objet WHERE id = ?');
	$Obj1->execute(array($IdObjet));
	$InfoObjet=$Obj1->fetch();
	
	$NomCommun = $InfoObjet['nom_objet'];
	
	//VERIFICATION DU STOCK CELON LES ID
	$Stock2=$bdd->prepare('SELECT * FROM objet_joueur WHERE id_objet = ? AND id_membre = ? AND id_planete = ?');
	$Stock2->execute(array($IdObjet,$id_membre,$planete_utilise));
	$SockCommun=$Stock2->fetch();
	
	$NombreStockCommun = $SockCommun['nombre_objet'];


//ON VA FAIRE EN SORTE QUE LES $_POSTE SOIT PAS VIDE
	if($NombreAmul == "")
	{
		$NombreAmul = 0;
	}
	
	if($NombreDiamant == "")
	{
		$NombreDiamant = 0;
	}
	
	if($NombreObjet == "")
	{
		$NombreObjet = 0;
	}
	if($NomCommun == "")
	{
		$NomCommun = "Aucun";
	}


	
			//ON VERIFIE QUE LES OBJETS SOIENT BIEN DES NOMBRES OU QU'ILS SOIENT VIDES
		if(is_numeric($NombreDiamant) OR !empty($NombreDiamant) AND is_numeric($NombreAmul) OR !empty($NombreAmul) AND is_numeric($NombreObjet) AND !empty($NombreObjet))
		{ 
	
			if($NombreDiamant >= 0 AND $NombreAmul >= 0 AND $NombreObjet >= 0)
			{
				
				//ON VERIFIE QUE LE CHIFFRE ENVOYE NE DEPASSE PAS LE STOCK
				//SI NOMBRE RARE EST SUPERIEUR AU STOCK ERREUR ET PAREIL POUR LE COMMUN, SI VDE C'EST OK
				if($NombreAmul <= $NombreStockRare AND $NombreDiamant <= $NombreStockRare AND $NombreObjet <= $NombreStockCommun)
				{
					
							

							
							//AMULETTE
							//ON RETIRE L'OBJET D'UN COTÉ PUIS ON L'AJOUTE DE L'AUTRE
							$retrait=$bdd->prepare('UPDATE objet_rare SET nombre_objet=nombre_objet-? WHERE id_membre = ? AND id_planete = ? AND id_objet_rare = ?');
							$retrait->execute(array($NombreAmul,$id_membre,$planete_utilise,$IdObjetRare));
							
							$ajout=$bdd->prepare('UPDATE objet_rare SET nombre_objet=nombre_objet+? WHERE id_membre = ? AND id_planete = ? AND id_objet_rare = ?');
							$ajout->execute(array($NombreAmul,$MembreVise,$PlaneteVise,$IdObjetRare));
							
							//DIAMANT
							$retrait=$bdd->prepare('UPDATE objet_rare SET nombre_objet=nombre_objet-? WHERE id_membre = ? AND id_planete = ? AND id_objet_rare = ?');
							$retrait->execute(array($NombreDiamant,$id_membre,$planete_utilise,$IdObjetRare));
							
							$ajout=$bdd->prepare('UPDATE objet_rare SET nombre_objet=nombre_objet+? WHERE id_membre = ? AND id_planete = ? AND id_objet_rare = ?');
							$ajout->execute(array($NombreDiamant,$MembreVise,$PlaneteVise,$IdObjetRare));
							
							//OBJET COMMUN
							$retrait=$bdd->prepare('UPDATE objet_joueur SET nombre_objet=nombre_objet-? WHERE id_membre = ? AND id_planete = ? AND id_objet = ?');
							$retrait->execute(array($NombreObjet,$id_membre,$planete_utilise,$IdObjet));
							
							$ajout=$bdd->prepare('UPDATE objet_joueur SET nombre_objet=nombre_objet+? WHERE id_membre = ? AND id_planete = ? AND id_objet = ?');
							$ajout->execute(array($NombreObjet,$MembreVise,$PlaneteVise,$IdObjet));
							
							
							// MESSAGE QUI SERA AFFICHÉ DANS LA MESSAGERIE DU JOUEUR QUI ENVOIE L'ÉCHANGE
							$message=" Résumé de l'échange avec le joueur " . htmlentities($Vise['pseudo']) . " : </br></br> Nombre d'amulette transferé : " . $NombreAmul . 
							"</br></br> Nombre de Diamant transferé : " . $NombreDiamant . 
							"</br></br> Nombre " . $NomCommun . " transferé : " . $NombreObjet . "";
							// INSERTION DU MESSAGE 				
							$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
							$msg->execute(array($id_membre,$id_membre,$message,time(),0,"Rapport d'échange avec le joueur " . htmlentities($Pseu['pseudo']) . ""));
							
							
							// MESSAGE QUI SERA AFFICHÉ DANS LA MESSAGERIE DU JOUEUR QUI REÇOIE
							$message=" Résumé de l'échange avec le joueur " . htmlentities($Pseu['pseudo']) . " : </br></br> Nombre d'amulette transferé : " . $NombreAmul . 
							"</br></br> Nombre de Diamant transferé : " . $NombreDiamant . 
							"</br></br> Nombre de " . $NomCommun . " transferé : " . $NombreObjet . "";
							// INSERTION DU MESSAGE 				
							$msg=$bdd->prepare('INSERT INTO messagerie (id_expediteur,id_destinataire,message,dat_envoi,lu,objet) VALUES (?,?,?,?,?,?) ');
							$msg->execute(array($id_membre,$MembreVise,$message,time(),0,"Rapport d'échange avec le joueur " . htmlentities($Pseu['pseudo']) . ""));

							$_SESSION['error'] = '<p class="green">Votre échange s\'est déroulé avec succès.</p>';
					
				}
				else
				$_SESSION['error'] = '<p class="red">Votre stock est insuffisant.</p>';
					
					
			}
			else
			$_SESSION['error'] = '<p class="red">Impossible de mettre un nombre négatif.</p>';
		}
		else
		$_SESSION['error'] = '<p class="red">Vous devez entrer un chiffre.</p>';

	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';


header('Location: '.pathView().'vortex/echange_objet.php');

?>

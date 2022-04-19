<?php

@ini_set('display_errors', 'on');	
				
$cloture = 1 ;
if($cloture == 1)
{
	if($_POST) /* Si je valide le bouton s'inscrire */
	{
		require_once "../../include/connexion_bdd.php";

		$_SESSION['pseudo'] = strip_tags(htmlspecialchars($_POST['pseudo']));
		$_SESSION['mail'] = strip_tags(htmlspecialchars($_POST['mail']));
		$_SESSION['mail2'] = strip_tags(htmlspecialchars($_POST['mail2']));				
		$_SESSION['mdp'] = strip_tags(htmlspecialchars($_POST['mdp']));
		$_SESSION['mdp2'] = strip_tags(htmlspecialchars($_POST['mdp2']));
		$_SESSION['planete'] = strip_tags(htmlspecialchars($_POST['planete']));
		$_SESSION['parrain'] = strip_tags(htmlspecialchars($_POST['parrain']));
				
		$pseudo = strip_tags(htmlspecialchars($_POST['pseudo'])); /* Permet de proteger contre les caractères speciaux */	
		$mail = strip_tags(htmlspecialchars($_POST['mail']));
		$mail2 = strip_tags(htmlspecialchars($_POST['mail2']));
		$mdp_hors_cryptage = strip_tags($_POST['mdp']); /* permet de securisé avec un hachage du mot de passe */
		$mdp2_hors_crytage = strip_tags($_POST['mdp2']); /* NE PAS METTRE D'ESPACE ENTRE SHA et ($_POST....) */
		$mdp = strip_tags(sha1($_POST['mdp'])); /* permet de securisé avec un hachage du mot de passe */
		$mdp2 = strip_tags(sha1($_POST['mdp2'])); /* NE PAS METTRE D'ESPACE ENTRE SHA et ($_POST....) */
		$planete = strip_tags(htmlspecialchars($_POST['planete']));
		$race = strip_tags($_POST['race']);
		$titre = strip_tags($_POST['titre']);
		$parrain = strip_tags($_POST['parrain']);
				
		// a corriger je voulais bloquer les insultes
		$interdits = array('baise','connard,','encule','enculer','batard','batarde','salope','filsdepute','salaud','salaud','cons','staff','admin','humain','orak','valhar','droide','droïde','pute','noir','naigre','negre','arabe');
		
		if(!in_array($pseudo,$interdits))
		{
			if(!empty($pseudo) AND !empty($mail) AND !empty($mail2) AND !empty($mdp_hors_cryptage) AND !empty($mdp2_hors_crytage) AND !empty($planete) AND !empty($race) AND !empty($titre))    
			{
				$pseudolength = strlen($pseudo); /* fonction strlen pour connaitre le nombre de caractères */
				$longueur_planete = strlen($planete);//compte le nombre de caractère de la planete
						
				if( $longueur_planete >= 3 && $longueur_planete <= 10)
				{
					if($pseudolength >= 5 && $pseudolength <= 15) /* Ne doit pas être en dessous de 5 caractères et au dessus se trouve dans le Input */
					{
						$reqpseudo = $bdd->prepare('SELECT * FROM membre WHERE pseudo = ?');
						$reqpseudo->execute(array($pseudo));
						$pseudoexiste = $reqpseudo->rowCount();
				
						if($pseudoexiste == 0) /* si le pseudo n'est pas déjà dans la table donc superieur à zero c'est bon sinon message d'erreur */
						{						
							if($mail == $mail2)   /* SI mail et le mail 2 sont identique c'est bon on passe au "mot de passe" sinon on affiche le ELSE avec l'erreur.*/
							{
								if($race == "valhar" OR $race == "humain" OR $race == "droide" OR $race == "orak")
								{


										if($titre == "gouverneur" OR $titre == "maitre" OR $titre == "monsieur" OR $titre == "commandant" OR $titre == "empereur" OR $titre == "majeste" OR	$titre == "seigneur" OR $titre == "general" OR $titre == "tyran" OR $titre == "commodor" OR $titre == "imperatrice" OR $titre == "roi" OR $titre == "sultan" )
										{
											if(!empty($parrain) == NULL OR $parrain != NULL)
											{
												//verifie la liste pseudo
												$vf=$bdd->prepare('SELECT * FROM membre WHERE pseudo = ?');
												$vf->execute(array($parrain));
												$joueur_present=$vf->rowCount();
																			
												if($joueur_present == 1 )
												{
													//on ajoute le joueur et le parrain
													$ins=$bdd->prepare('INSERT INTO parrain(pseudo,pseudo_parrain,bonus,valide) VALUES(?,?,?,?)');
													$ins->execute(array($pseudo,$parrain,0,0));
																					
													//Verification et ajout de points de parrain a la connexion dans include
												}
																					
												if(filter_var($mail, FILTER_VALIDATE_EMAIL))    
												{
													$reqmail = $bdd->prepare("SELECT * FROM membre WHERE mail = ?"); 
													$reqmail->execute(array($mail));  
													$mailexiste = $reqmail -> rowCount(); 
													
													if($mailexiste == 0)// Si il n'existe pas l'opération continue
													{
														if($mdp == $mdp2)// Mdp et mdp2 identique tout est ok
														{
															$longueurkey = 12;
															$key = "";
															for($i=1;$i<$longueurkey;$i=$i+1)
															{   /*  MEMO: for($i=1;$i<$longueurkey;$i=++) La fin signifie la meme chose en plus court */
																$key .= mt_rand(0,9);
															}
															$mdplength = strlen($mdp);
																
															if($mdplength >= 5)	
															{	
																require_once "inscription_requete_planete.php";
																	
																//Si la requete a la fin de l'inscription planète est sur 1 donc une planète à été trouvé alors on valide 
																if( $requete_ok == 1)
																{																													
																
																																			
																require_once 'inscription_requete.php';
																
																$headers = "MIME-Version: 1.0" . "\r\n";
																$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
																	// Expéditeur
																$from = "Inscription à Expedition-wars <noreply@expedition-wars.fr>";
																$headers .= "From : " . $from . "\n";
																	// Adresse de retour en cas de non réception du mail
																$headers .= "Return-path : " . $from . "\n";
																	// On modifie l'adresse de réponse du mail
																$headers .= "Reply-to : " . $from . "\n";
																	
																$searchReplace = array('#titre_mail#' => 'INSCRIPTION sur Expedition Wars',
																					   '#texte_mail#' => "Vous avez correctement effectué votre inscription sur le jeu le plus énigmatique, le plus passionnant de la galaxie.<br /> <br />Connectez-vous au jeu en cliquant ici : <br />Bon jeu sur <a href=\"https://expedition-wars.fr/\">Expedition Wars</a> !");

																$search = array_keys($searchReplace);
																$replace = array_values($searchReplace);

																$templateFile = file_get_contents('../../include/mail.template.php');
																$msg_html = str_replace($search, $replace, $templateFile);

																mail($mail, 'Inscription sur Expedition-wars.fr', $msg_html, $headers);
																	
																//Inscription réussi. Adresses GMAIL, si vous ne recevez pas l\'email veuillez vérifier dans vos spams, ou patienter sinon contacter un administrateur sur le forum ou par discord. Merci.
																$_SESSION['error'] = '<div class="valide">Inscription activé. Bon jeu.</div>';
																																	
																// header('Location: ../../index.php');
																	
																}
																else
																$_SESSION['error'] = '<div class="erreur">Aucune planète disponible.</div>';
															}
															else		
															$_SESSION['error'] = '<div class="erreur">Le mot de passe doit contenir entre 6 et 20 caractères.</div>';
														}
														else		
														$SESSION['error'] = '<div class="erreur">Vos mot de passe ne correspondent pas.</div>';
													}
													else		
													$_SESSION['error'] = '<div class="erreur">Votre adresse email est déjà utilisé.</div>';
												}
												else		
												$_SESSION['error'] = '<div class="erreur">Votre adresses mail n\'est pas valide.</div>';
											}
											else		
											$_SESSION['error'] = '<div class="erreur">Votre parrain n\'existe pas.</div>';
										}
										else
										$_session['error'] = '<div class="erreur">Ce titre n\'existe pas</div>'; 
								}
								else		
								$_SESSION['error'] = '<div class="erreur">Erreur sur la race.</div>';
							}
							else		
							$_SESSION['error'] = '<div class="erreur">Vos adresses mail ne correspondent pas.</div>';
						}
						else		
						$_SESSION['error'] = '<div class="erreur">Le pseudo est déjà utilisé.</div>';
					}
					else		
					$_SESSION['error'] = '<div class="erreur">Votre pseudo doit être compris entre 5 et 15 caractères.</div>';
				}
				else		
				$_SESSION['error'] = '<div class="erreur">Votre planète doit être compris entre 3 et 10 caractères.</div>';
			}
			else		
			$_SESSION['error'] = '<div class="erreur">Tous les champs doivent être completés.</div>';
		}
		else		
		$_SESSION['error'] = '<div class="erreur">Mot interdit dans votre pseudo.</div>';
	}
	else		
	$_SESSION['error'] = '<div class="erreur">Une erreur s\'est produite lors de l\'envoi du formulaire. Merci de contacter le webmaster du site.</div>';
}
else		
$_SESSION['error'] = '<div class="erreur">Inscription fermée.</div>';

header('Location: ../../index.php');
?>

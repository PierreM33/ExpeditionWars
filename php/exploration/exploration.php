<?php
@ini_set('display_errors', 'on');

if($_POST['explorer'])
	{
		require_once '../../include/connexion_bdd.php';
		
	$planete_utilise=htmlentities(htmlspecialchars($_SESSION['planete_utilise']));
	$id_membre=htmlentities(htmlspecialchars($_SESSION['id']));
		
		if(!empty($_POST['explorer']))
		{
			$id_equipe_choisi= strip_tags($_POST['exploration']); // Recupère l'id de l'équipe envoyé (1 ou 2)
			
			//protection du bug
				$actif=$bdd->prepare('UPDATE portail SET protection_lien = ? WHERE id_planete = ?');
				$actif->execute(array(0,$planete_utilise));
			
			// Up de l'equipe la randant indisponible à la selection car elle se trouve en mission
			$dispo=$bdd->prepare('UPDATE equipe_exploration_joueur SET disponible = ? WHERE id_planete = ? AND id_equipe = ?');
			$dispo->execute(array(1,$planete_utilise,$id_equipe_choisi));
			
			$nvv=$bdd->prepare('SELECT * FROM equipe_exploration_joueur WHERE id_planete = ? AND id_equipe = ?');
			$nvv->execute(array($planete_utilise,$id_equipe_choisi));
			$niveau=$nvv->fetch();
					
					
					//Récuperation du niveau
					$niveau_equipe = $niveau['niveau'];
					
					$n=$bdd->prepare('SELECT * FROM numero_mission WHERE id = ?');
					$n->execute(array(1));
					$nv=$n->fetch();
					
					
					if($nv['maintenance'] == 1)
					{						
					//PERMET DE FAIRE LA SELECTION ENTRE LA MISSION X ET MISSION Y, EXEMPLE MISSION 15 ET 19
					//POUR LA MAINTENANCE JE ME LAISSE UN ACCES AVEC UN CHOIX DE BLOQUER LES MISSIONS A CE QUE JE VEUX OU NON
					
					$numero_choisi = rand($nv['numero_un'],$nv['numero_deux']);
					}
					else
					{
						$TAB=$bdd->prepare('SELECT * FROM mission_liste');
						$TAB->execute(array());
						$TABLE=$TAB->fetch();

						//RECUPERE LE NOMBRE DE MISSION DANS LA TABLE
						$Miss=$bdd->prepare("SELECT MAX(numero_mission) AS maximum FROM mission");
						$Miss->execute(array());
						$Mission=$Miss->fetch(); 

						//NOMBRE DE MISSION AU TOTAL DANS LA TABLE
						$maximum = $Mission['maximum'];


						$rand_choix_mission = rand(1,$maximum);
						$liste =  json_decode($TABLE['liste_mission'], true);

						if (gettype($liste) == "integer"){
						$liste = array($liste);
						}


						$n = 0;
						while(in_array(($rand_choix_mission + $n) % $maximum +1, $liste))
						{
						  $n += 1;
						  //SI ON ARRIVE AU MAXIMUM ON REMET LA MISTE A ZÉRO
						  if ($n == $maximum)
						  {
							$liste = [];
							
						  }
						  //SI LE NUMERO EST DANS LA LISTE ON LE RELANCE
							if(json_encode($liste) == $numero_choisi )
							{
							$numero_choisi = ($rand_choix_mission + 1) % $maximum +1 ;
							}
						}

						$numero_choisi = ($rand_choix_mission + $n) % $maximum +1;

						array_push($liste, $numero_choisi);

						// CETTE PARTIE RECONVERTIS LA LISTE EN TEXTE
						$missions_en_texte = json_encode($liste);
						//UPDATE DANS LA BDD LA LISTE
						$UpdateListe=$bdd->prepare('UPDATE mission_liste SET liste_mission = ? WHERE id_membre = ? ');
						$UpdateListe->execute(array(json_encode($liste),$id_membre));
					}
					
					
					
			$E=$bdd->prepare('SELECT * FROM exploration_joueur WHERE id_planete = ?');
			$E->execute(array($planete_utilise));
			$EE=$E->fetch();

			//on va verifier que le joueur possède bien une equipe d'exploration
			if($EE == 0)
			{
			
			// INSERTION de la partie exploration		
			$up=$bdd->prepare('INSERT INTO exploration_joueur (id_equipe,id_planete,id_membre,numero_mission,heure_depart,actif,tour,etape) VALUES (?,?,?,?,NOW(),?,?,?)');
			$up->execute(array($id_equipe_choisi,$planete_utilise,$id_membre,$numero_choisi,1,0,1));
			
			$actif=$bdd->prepare('UPDATE portail SET actif = ? , interagir = ?, porte_connecte = ?, id_membre = ?, protection_lien = ? WHERE id_planete = ?');
			$actif->execute(array(0,0,0,0,0,$planete_utilise));

			//ENVOIE DE L'EQUIPE RETOUR AU PORTAIL
			
			header('Location: '.pathView().'vortex/page_portail_spatial.php');
			$_SESSION['error'] = '<p class="green">Votre &eacute;quipe &agrave; franchi la porte avec succ&egrave;s. Cliquez de nouveau sur "Explorer une plan&egrave;te" pour poursuivre la mission.</p>';
			
			}
			else
			$_SESSION['error'] = '<p class="green">Aucune équipe disponible pour explorer.</p>';
		}
		else
		$_SESSION['error'] = '<p class="green">Aucune équipe n\'a été sélectionné.</p>';
		
	}
header('Location: '.pathView().'vortex/page_portail_spatial.php');

?>
<?php

require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']); 

// Cette page permettra la vérification de la mission et redirigera 

//LECTURE DE SELECTION EXPLO JOUEUR
$s=$bdd->prepare('SELECT * FROM exploration_joueur WHERE id_planete = ? AND id_membre = ?');
$s->execute(array($planete_utilise,$id_membre));
$exploration_on=$s->fetch();

$datetime1 = date_create($exploration_on['heure_depart']);
$datetime2 = date_create($exploration_on['heure_actuelle']);
$interval = date_diff($datetime1, $datetime2);
//echo $interval->format('%H:%i:%s');

//LECTURE DU TEMPS FICTIF
$tf=$bdd->prepare('SELECT * FROM temps_fictif');
$tf->execute(array());
$t=$tf->fetch();


$faux_datetime1 = date_create($t['temps_un']);
$faux_datetime2 = date_create($t['temps_deux']);
$faux_interval = date_diff($faux_datetime1, $faux_datetime2);
//echo $faux_interval->format('%H:%i:%s');



		if($exploration_on['actif'] == 0) // Si l'exploration n'est pas active on affiche le choix des équipes a envoyer
		{
			
			header('Location: '.pathView().'exploration/choix_equipe_exploration.php');
		}
		elseif($interval->format('%Y:%M:%D:%H:%i:%s') >= $faux_interval->format('%Y:%M:%D:%H:%i:%s'))
		{
		// SI actif est sur 1 dans la BDD signifie que votre équipe est partie. 
		// Mais si le temps est écoulé, votre équipe vous envoie son rapport et l'on accède à la partie suivante.
		// Premier est un chrono par rapport a la date et heure d'envoie /-/ Doit etre superieur a /-/ Le second la date fictive en BDD
				header('Location: '.pathView().'exploration/mission.php');
				// SI l'heure est bonne, on envoie sur la mission

		}
		elseif(htmlentities($exploration_on['actif']) == 1)
		{

			header('Location: '.pathPhp().'exploration/verif_explorer.php');
			

		}


?>
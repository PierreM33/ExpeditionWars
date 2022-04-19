<?php 

require_once '../../include/connexion_bdd.php';

	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']); 
	
//LECTURE DE SELECTION EXPLO JOUEUR
$selet=$bdd->prepare('SELECT * FROM exploration_joueur WHERE id_planete = ? AND id_membre = ?');
$selet->execute(array($planete_utilise,$id_membre));
$s=$selet->fetch();


//VERIFIER QUE L'ON POSSEDE BIEN UNE EQUIPE SUR LA PLANETE
$selet=$bdd->prepare('SELECT * FROM equipe_exploration_joueur WHERE id_planete = ? AND unite_possede=?');
$selet->execute(array($planete_utilise,1));
$vide=$selet->rowCount();



//MISE A JOUR DE L'HEURE ACTUELLE
$maj_d=$bdd->prepare('UPDATE exploration_joueur SET heure_actuelle = NOW() WHERE id_membre = ?');
$maj_d->execute(array($id_membre));


$datetime1 = date_create($s['heure_depart']);
$datetime2 = date_create($s['heure_actuelle']);
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

if(!empty($_SESSION['error'])){ echo $_SESSION['error']; } 


		if(htmlentities($s['actif']) == 0) // Si l'exploration n'est pas active on affiche le choix des équipes a envoyer
		{
			header('Location: '.pathView().'exploration/choix_equipe_exploration.php');
		}
		// SI actif est sur 1 dans la BDD signifie que votre équipe est partie. 
		// Mais si le temps est écoulé, votre équipe vous envoie son rapport et l'on accède à la partie suivante.
		// Premier est un chrono par rapport a la date et heure d'envoie /-/ Doit etre superieur a /-/ Le second la date fictive en BDD
		elseif($interval->format('%Y:%M:%D:%H:%i:%s') >= $faux_interval->format('%Y:%M:%D:%H:%i:%s'))
		{
				
				header('Location: '.pathView().'exploration/mission.php');
				// SI l'heure est bonne, on envoie sur la mission

		}
		elseif(htmlentities($s['actif']) == 1)
		{
		header('Location: '.pathView().'exploration/message.php');
		}



 ?>
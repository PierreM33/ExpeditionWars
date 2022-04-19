<?php

if($_POST)
	{	

require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 


 //on protège le variable
 				$id_vaisseau = strip_tags($_POST['numero_chasseur']);
				$id_vaisseau_hote = strip_tags($_POST['numero_vaisseau_hote']);
				//On sécurise le fait que ce soit bien un nombre entrer
				
 if(is_numeric($id_vaisseau) AND is_numeric($id_vaisseau_hote))
 {
		//RECUPERE VAISSEAU JOUEUR CHASSEUR
		$cha=$bdd->prepare("SELECT * FROM vaisseau_joueur WHERE id_planete = ? AND gabarit = ? AND id= ?");
		$cha->execute(array($planete_utilise,1,strip_tags($_POST['numero_chasseur'])));
		$c=$cha->fetch();

		//RECUPERE VAISSEAU JOUEUR HOTE
		$chass=$bdd->prepare("SELECT * FROM vaisseau_joueur WHERE id_planete = ? AND id= ?");
		$chass->execute(array($planete_utilise,strip_tags($_POST['numero_vaisseau_hote'])));
		$D=$chass->fetch();

		
				$id_planete_origine = htmlentities($c['id_planete']);
				$nom_vaisseau =  htmlentities($c['nom_vaisseau']);
				$surnom = htmlentities($c['surnom']);
				$attaque = htmlentities($c['attaque']);
				$defense = htmlentities($c['defense']);
				$bouclier = htmlentities($c['bouclier']);
				$vitesse = htmlentities($c['vitesse']);
				$type = htmlentities($c['type']);
				$gabarit = htmlentities($c['gabarit']);
				$fret = htmlentities($c['fret']);
				$poid = htmlentities($c['poid']);
				
				
				//Si la limite de stockage des chasseurs n'est pas atteinte
				if($D['chasseur'] <= $D['limite_chasseur'])
				{

				
				//J'insère le vaisseau dans la table de chasseur embarqué pour n'être utilisé que dans le combat
				$rec=$bdd->prepare('INSERT INTO vaisseau_chasseur_embarque (id_vaisseau, id_membre, id_planete, id_planete_origine, id_vaisseau_hote, nom_vaisseau, surnom, attaque, defense, bouclier, vitesse, type, gabarit, poid, id_action) VALUES (?,?, ?,?,?, ?,?,?, ?,?,?, ?,?,?,?)');
				$rec->execute(array($id_vaisseau,$id_membre, $planete_utilise, $id_planete_origine, $id_vaisseau_hote, $nom_vaisseau, $surnom, $attaque, $defense, $bouclier, $vitesse, $type, $gabarit, $poid, 0));
				
				//Retire le vaisseau de la liste de selection
				$delete_vaisseau=$bdd->prepare('DELETE FROM vaisseau_joueur WHERE id_membre = ? AND id_planete = ? AND id = ?');
				$delete_vaisseau->execute(array($id_membre,$planete_utilise,$id_vaisseau));
				

				
				//Ajouter dans le vaisseau +1 dans les places disponible
				$aga=$bdd->prepare('UPDATE vaisseau_joueur SET chasseur = chasseur + ? WHERE id_membre = ? AND id_planete = ? AND id = ?');
				$aga->execute(array(1,$id_membre,$planete_utilise,$id_vaisseau_hote));
				
				$_SESSION['error'] = '<p class="green"> Vaisseau ajout&eacute; dans le hangar de son vaisseau h&ocirc;te.</p>';
				}
				else
				$_SESSION['error'] = '<p class="red">Le vaisseau s&eacute;lectionn&eacute; ne peut plus accueillir de chasseur.</p>';
	}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';
}
	else
	$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./flotte/embarquement.php');
	?>
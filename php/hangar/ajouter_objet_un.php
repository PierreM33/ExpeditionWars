<?php 

if($_POST)
	 {
		 			require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

			//Recuperation des informations de l'objet
			$q=$bdd->prepare('SELECT ob.id, ob.nom_objet, ob.image, ob.description, ob.attaque, ob.defense, ob.bouclier, ob.att_m, ob.def_m,ob.constructible, obj.id_objet, obj.objet_possede, obj.nombre_objet, obj.id_planete, obj.id_membre, obj.ajout FROM objet AS ob LEFT JOIN objet_joueur AS obj ON ob.id=obj.id_objet WHERE ob.nom_objet = ?');
			$q->execute(array(strip_tags($_POST['objet_un'])));
			$o=$q->fetch();
			
			//ajout des statistiques au vaisseau
			$update=$bdd->prepare('UPDATE vaisseau_joueur SET attaque = attaque+? , defense=defense+? , bouclier = bouclier+?, objet_un=? , nombre_objet_un=? WHERE id = ?');
			$update->execute(array(strip_tags($o['attaque']),strip_tags($o['defense']),strip_tags($o['bouclier']),strip_tags($_POST['objet_un']),1,strip_tags($_POST['numero'])));
			
			//retire l'objet au joueur
			$qq=$bdd->prepare('UPDATE objet_joueur SET nombre_objet=nombre_objet-? WHERE id_objet = ?  AND id_planete = ?');
			$qq->execute(array(1,htmlentities($o['id']),$planete_utilise));
			
			$_SESSION['error'] = '<p class="green">L\'objet ' . strip_tags($_POST['objet_un']) . ' vient d\'être ajouté au vaisseau.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';
	
header('Location: '.pathView().'hangar/liste_vaisseau.php'); 
	?>	
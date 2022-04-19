<?php
// @ini_set('display_errors', 'on');
			// PERMET DE FAIRE REVENIR LES FLOTTES ENVOYEES										
if($_POST)
{
require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 


//ON RECUPERE LE NUMERO DE VAISSEAUX CONCERNEE
$IdVaisseau = strip_tags($_POST['id_cache']);

// var_dump($IdVaisseau);
//VAISSEAU ACTION EN FONCTION DU NUMERO D'ACTION
$va = $bdd->prepare('SELECT * FROM vaisseau_action WHERE id_membre = ? AND nom_action = ? AND id = ?');
$va->execute(array($id_membre,2, $IdVaisseau));
while($VaisseauAction=$va->fetch())
{
	
	
	//on recupère le id action et chacun des vaisseaux;
	$inf=$bdd->prepare('SELECT * FROM vaisseau_joueur WHERE id_action = ?');
	$inf->execute(array($VaisseauAction['id']));
	$info=$inf->fetch();
	


	//On récupère le id_action
		$id_action = $VaisseauAction['id'];
		
	//On va récupérer le vaisseaux qui devront faire le retour grace au ID_ action de vaisseau action
	$idA = $bdd->prepare('SELECT * FROM vaisseau_action WHERE id_membre = ? AND id = ?');
	$idA->execute(array($id_membre,$id_action));
	$IdAction=$idA->fetch();
	
	
//On va déduire le temps ecoulé par rapport au temps de depart, depuis la planète de départ.
//Planete de depart
$PlaneteOrigine = $IdAction['id_planete'];

//TEmps du points A au points B
$TempsOrigine = $IdAction['temps'];

//Récupération du temps enregistré de base
$stockage_valeur_deplacement = $IdAction['stockage_valeur_deplacement'];

//Temps du trajet - temps normal
$TempsEcouleDepuisDepart = ($stockage_valeur_deplacement + time()) - $TempsOrigine;

// var_dump($TempsEcouleDepuisDepart);

//STOCKAGE PLUS TEmps
$NV = ($TempsEcouleDepuisDepart + time());

//On update le nouveau temps dans la bdd, la nouvelle destination et on passe le vaisseau a 2 en type
//PASSER LE VAISSEAU ACTION A 2
$up=$bdd->prepare('UPDATE vaisseau_action SET temps = ?, stockage_valeur_deplacement = ?, type = ?, nom_action = ?, planete_vise = ? ,id_membre_vise = ? WHERE id_membre = ? AND id = ?');
$up->execute(array($NV,$TempsEcouleDepuisDepart,2,2,$PlaneteOrigine,$id_membre, $id_membre, $id_action));

}


}
else
$_SESSION['error'] = '<p class="red">Erreur lors de l\'envoie du formulaire.</p>';

header('Location: '.pathView().'./flotte/vaisseaux_en_deplacement.php');
?>
<?php

$insertmembre = $bdd->prepare("INSERT INTO membre (pseudo,mail,mdp,confirmekey,confirm,point,race,titre,rang,avertissement) VALUES ( ?, ?, ?, ?, 1, 0, ?, ?, 0, 0)");/* Enregistre une entrée dans la BDD */
$insertmembre->execute(array($pseudo, $mail, $mdp, $key,$race, $titre));
							
																												
$id_membre=$bdd->lastInsertId();// DERNIER MEMBRE INSERE


$insertmembredeux = $bdd->prepare("UPDATE membre SET id_technologie = :id_technologie WHERE ID = $id_membre");
$insertmembredeux->execute(array('id_technologie' => $id_membre));	
// ID technologie est le même que l'id joueur

//ON CHOISIR UN NUMERO DE SYSTEME COMPRIS ENTRE 100 et 200 ( LA GALAXIE FAIT 0 a 300 SYSTEME (05.12.2020))
$Systeme = random_int(100,200);

//SELECTION D'UN ID ET ATTRIBUTION SI PLANETE VIDE
$s=$bdd->prepare('SELECT * FROM planete WHERE planete_occupe = ? AND planete = ? AND cite = ? AND numero_systeme = ?');
$s->execute(array(0,1,0,$Systeme));
$selection=$s->fetch();
$select=$s->rowCount();

// selectionne un chiffre et le rajoute avant le .jpg pour definir l'image de la planète.
$avatar = rand(1,16);
$avatar_planete = $avatar . ".jpg";

// selectionne l'id de la planete
$id_choix_planete = htmlentities($selection['id']);

if($select > 0)
	{
	$insertplanete = $bdd->prepare('UPDATE planete SET nom_planete=?, planete_mere = ?, avatar_p = ?, id_membre = ?, planete_occupe = ?, pseudo_membre = ? WHERE planete_occupe = ? AND planete = ? AND id = ?');
	$insertplanete->execute(array($planete,1,$avatar_planete,$id_membre,1,$pseudo,0,1,$id_choix_planete)); 

	$requete_ok = 1;

	}
else
	{
	$requete_ok = 0;	

	$del_mbr=$bdd->prepare('DELETE FROM membre WHERE id = ?');
	$del_mbr->execute(array($id_membre));
	}





?>
<?php
if($_POST){
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
	
	if(!empty($_POST['dest']) && !empty($_POST['sujet']) && !empty($_POST['mess'])){
		
		$req=$bdd->prepare('SELECT id,pseudo FROM membre WHERE pseudo=?');
		$req->execute(array(strip_tags($_POST['dest'])));
		$res=$req->fetch();
		
		$req2=$bdd->prepare('SELECT id,pseudo FROM membre WHERE id=?');
		$req2->execute(array($_SESSION['id']));
		$res2=$req2->fetch();
		
		if($res['pseudo'] == $_POST['dest']) {
			
			if($_POST['dest'] != $res2['pseudo']){
			
				$q=$bdd->prepare('INSERT INTO messagerie (`id_expediteur`,`id_destinataire`,`message`,`dat_envoi`,`objet`) VALUES (:exp, :dest, :mess, :dat, :obj)');
				$q->bindValue(':exp', $_SESSION['id'], PDO::PARAM_INT);
				$q->bindValue(':dest', $res['id'], PDO::PARAM_INT);
				$q->bindValue(':mess', strip_tags($_POST['mess']), PDO::PARAM_STR);
				$q->bindValue(':dat', time(), PDO::PARAM_INT);
				$q->bindValue(':obj', strip_tags($_POST['sujet']), PDO::PARAM_STR);
				$q->execute();
				
				$_SESSION['error'] = '<p class="green">Message envoyé avec succès.</p>';
			}
			else
				$_SESSION['error'] = '<p class="red">Vous ne pouvez pas vous envoyer de message à vous-même.</p>';
		}
		else
			$_SESSION['error'] = '<p class="red">Ce joueur n\'existe pas.</p>';
	}
	else
		$_SESSION['error'] = '<p class="red">vous devez remplir tous les champs.</p>';
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire. Veuillez contacter le webmaster du jeu.</p>';

header ('Location: '.pathView().'messagerie/messagerie.php');
?>
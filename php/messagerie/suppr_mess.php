<?php
if($_POST['supprimer']){
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

	if(!empty($_SESSION['id']))
	{
		if(!empty($_POST['rid']) && is_numeric($_POST['rid']))
		{
			$req = $bdd->prepare("DELETE FROM messagerie WHERE id= :id AND id_destinataire= :destinataire");
			$req->bindValue(':id', $_POST['rid'], PDO::PARAM_INT);
			$req->bindValue(':destinataire', $_SESSION['id'], PDO::PARAM_INT);
			$req->execute();
			
			$_SESSION['error'] = '<p class="green">Le message a bien été supprimé.</p>';
		}
		else
			$_SESSION['error'] = '<p class="red">Ce message n\'existe pas ou plus.</p>';
		header('Location:'. pathView() .'messagerie/messagerie.php');
	}
	else
		header('Location:'. path(false));
}
?>
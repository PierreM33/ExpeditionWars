<?php
if($_POST['supprimer']){
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 

	if(!empty($_SESSION['id']))
	{
		if(!empty($_POST['list']) && is_array($_POST['list']))
		{
			foreach($_POST['list'] as $lists)
			{
				$req = $bdd->prepare("DELETE FROM messagerie WHERE id= :id AND id_destinataire= :destinataire");
				$req->bindValue(':id', $lists, PDO::PARAM_INT);
				$req->bindValue(':destinataire', $_SESSION['id'], PDO::PARAM_INT);
				$req->execute();
			}
			$_SESSION['error'] = '<p class="green">Le(s) message(s) sélectionné(s) ont été supprimé(s).</p>';
		}
		else
			$_SESSION['error'] = '<p class="red">Aucun message à supprimer</p>';
		header('Location:'. pathView() .'messagerie/messagerie.php');
	}
	else
		header('Location:'. path(false));
}
?>
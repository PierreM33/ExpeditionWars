<?php

if($_POST['validation'])
	{
		require_once '../../include/connexion_bdd.php';

$planete_utilise=htmlentities(htmlspecialchars($_SESSION['planete_utilise']));
$id_membre=htmlentities(htmlspecialchars($_SESSION['id']));


		if(!empty(strip_tags($_POST['validation'])))
			{
				$e=$bdd->prepare('SELECT * FROM enigme WHERE id_membre = ? AND numero_enigme = ?');
				$e->execute(array($id_membre,strip_tags($_POST['numero_enigme'])));
				$en=$e->fetch();
				
				$validation = strip_tags($_POST['validation']);
								
										if($validation == htmlentities(htmlspecialchars($en['reponse'])))// SI le mot écrit dans l'enigme est le meme que celui de la base de données alors c'est ok sinon on ajoute +1 dans le nombre de reponse
											{
												
												$_SESSION['error'] = '<p class="green">Félicitation vous avez trouvé la réponse à l\'énigme.</p>';
												
												$e=$bdd->prepare('UPDATE enigme set reponse_correct = ? WHERE id_membre = ? AND numero_enigme = ?');
												$e->execute(array(1,$id_membre,strip_tags($_POST['numero_enigme'])));
											}
											else
											{
												$_SESSION['error'] = '<p class="red">Ceci n\'est pas la bonne réponse à l\'énigme.</p>';
											}

			}
			else
				$_SESSION['error'] = '<p class="red">Veuillez inscrire une réponse.Le champs ne peut rester vide.</p>';
	}
header('Location: '.pathView().'enigme/enigme.php?numero_enigme=' . strip_tags($_POST['numero_enigme']) . '');

?>
<?php


if($_POST) 
	{        
		require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 
	
		$LST_PLA = strip_tags($_POST['liste_planete']);
		
		//On va récuperer les informations de la planète selectionné
		$Pp=$bdd->prepare("SELECT * FROM planete WHERE id = ?"); 
		$Pp->execute(array($LST_PLA));
		$Pl_P= $Pp->fetch();
		
		$plnaete_M=$bdd->prepare("SELECT * FROM planete WHERE id_membre = ? AND planete_mere = ?"); 
		$plnaete_M->execute(array($id_membre,1));
		$PM = $plnaete_M->fetch();
	
		
		if(htmlentities($Pl_P['id_membre']) == $id_membre)
		{            

			$up_nouv_pl=$bdd->prepare("UPDATE membre SET planete_utilise = ? WHERE id = ?");
			$up_nouv_pl->execute(array($LST_PLA,$id_membre));


			$nouv_s_p=$bdd->prepare("SELECT * FROM membre WHERE id = ? "); 
			$nouv_s_p->execute(array($id_membre));
			$nouvelle_s_pla = $nouv_s_p->fetch();

			$_SESSION['planete_utilise'] = htmlentities($nouvelle_s_pla['planete_utilise']);

			header('location: '.pathView().'sdc/salle_de_controle.php');
		}
		else // Si la planete selectionné n'est pas une du joueur il renvoi sur la planete mère
		{
			$_SESSION['planete_utilise'] = htmlentities($PM['id']);

			header('location: '.pathView().'sdc/salle_de_controle.php');
		}

	}

header('Location: '.pathView().'sdc/salle_de_controle.php');
?>
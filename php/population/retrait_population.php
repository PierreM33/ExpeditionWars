<?php 

if($_POST)
{
			require_once '../../include/connexion_bdd.php';
		$planete_utilise=htmlentities($_SESSION['planete_utilise']);
$id_membre=htmlentities($_SESSION['id']); 


		$nom = strip_tags($_POST['retrait_pop']);
		$nombre = strip_tags($_POST['nombre']);
		
		$reqpop=$bdd->prepare("SELECT * FROM population WHERE id_planete = ? "); /* Pour récuprer les valeurs des la table population */
		$reqpop->execute(array($planete_utilise));
		$population=$reqpop->fetch();
		
		// REDEFINITION DES VARIABLES
		$populationsimple=$population['population'];

		$popuouvrier=$population['ouvrier'];
		$popucivil=$population['civil'];
		$popusoldat=$population['soldat'];
		$popuchercheur=$population['chercheur'];
		$popupilote=$population['pilote'];
		$popuesclave=$population['esclave'];
		$popuglobal=$popucivil+$popusoldat+$popuchercheur+$popuesclave+$popupilote+$popuouvrier;

		if($nombre >= 0)
		{
			if(is_numeric($nombre))
				{
					if($nom == "ouvrier")
					{
						if($nombre <= $popuouvrier)
						{
							$r_update=$bdd->prepare("UPDATE population SET ouvrier = ouvrier-? , population = population+? WHERE id_planete = ?");
							$r_update->execute(array($nombre,$nombre,$planete_utilise));

							$_SESSION['error']='<p class="green">Population retiré avec succès.</p>';
						}
					}
					if($nom == "pilote")
					{
						if($nombre <= $popupilote)
						{
							$r_update=$bdd->prepare("UPDATE population SET pilote = pilote-? , population = population+? WHERE id_planete = ?");
							$r_update->execute(array($nombre,$nombre,$planete_utilise));

							$_SESSION['error']='<p class="green">Population retiré avec succès.</p>';
						}
					}

					if($nom == "chercheur")
					{
						if($nombre <= $popuchercheur)
						{
							$r_update=$bdd->prepare("UPDATE population SET chercheur = chercheur-? , population = population+? WHERE id_planete = ?");
							$r_update->execute(array($nombre,$nombre,$planete_utilise));

							$_SESSION['error']='<p class="green">Population retiré avec succès.</p>';
						}
					}
					if($nom == "civil")
					{
						if($nombre <= $popucivil)
						{
							$r_update=$bdd->prepare("UPDATE population SET civil = civil-? , population = population+? WHERE id_planete = ?");
							$r_update->execute(array($nombre,$nombre,$planete_utilise));

							$_SESSION['error']='<p class="green">Population retiré avec succès.</p>';
						}
					}
					if($nom == "soldat")
					{
						if($nombre <= $popusoldat)
						{
							$r_update=$bdd->prepare("UPDATE population SET soldat = soldat-? , population = population+? WHERE id_planete = ?");
							$r_update->execute(array($nombre,$nombre,$planete_utilise));

							$_SESSION['error']='<p class="green">Population retiré avec succès.</p>';
						}
					}

				}
				else
				$_SESSION['error'] = '<p class="red">Ceci doit être un nombre.</p>';
		}
		else
		$_SESSION['error'] = '<p class="red">Ceci doit être un nombre positif.</p>';

		
}
else
	$_SESSION['error'] = '<p class="red">Un problème est survenu lors de l\'envoi du formulaire.</p>';

header('Location: '.pathView().'/population/population.php');
?>
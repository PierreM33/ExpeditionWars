
<form method="POST" action="<?php echo pathPhp(); ?>include/changement_planete.php">
<select name="liste_planete">
<?php

//SELECTION DE LA PLANETE	
$requete=$bdd->prepare("SELECT * FROM planete WHERE id_membre = ? ");  
$requete->execute(array($id_membre));
while($resultat = $requete->fetch())
{

?> 
<option value="<?= $resultat['id'] ?>" <?= $planete_utilise === $resultat['id'] ? 'selected' : '' ?>><?php echo htmlentities(htmlspecialchars($resultat['nom_planete'])); ?> : <?php echo htmlentities(htmlspecialchars($resultat['coordonnee_spatial'])); ?></option>
			
<?php
}
?>
</select>
<input type="submit" value="Changement de planète"   />
</form>		
	
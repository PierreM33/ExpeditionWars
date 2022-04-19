<?php
			require_once '../../include/connexion_bdd.php';
	
	$planete_utilise=htmlentities($_SESSION['planete_utilise']);
	$id_membre=htmlentities($_SESSION['id']);



//Récupère la liste et valeurs des ressources du défenseur
$ls=$bdd->prepare('SELECT * FROM ressource WHERE id_planete=?');
$ls->execute(array($id_planete_defenseur));
$ress=$ls->fetch();

//Récupère la population du défenseur
$lf=$bdd->prepare('SELECT * FROM population WHERE id_planete=?');
$lf->execute(array($id_planete_defenseur));
$pop=$lf->fetch();

////-----------------MINES ---/////////
//Récupère la population dans les mines
$m=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete=? AND id_mine=?');
$m->execute(array($id_planete_defenseur,1));
$mine_or=$m->fetch();

$m=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete=? AND id_mine=?');
$m->execute(array($id_planete_defenseur,2));
$mine_titane=$m->fetch();

$m=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete=? AND id_mine=?');
$m->execute(array($id_planete_defenseur,3));
$mine_cristal=$m->fetch();

$m=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete=? AND id_mine=?');
$m->execute(array($id_planete_defenseur,4));
$mine_orinia=$m->fetch();

$m=$bdd->prepare('SELECT * FROM mines_joueur WHERE id_planete=? AND id_mine=?');
$m->execute(array($id_planete_defenseur,5));
$mine_orinium=$m->fetch();

$retrait_aleatoire = rand(10,5000);
$retrait_aleatoire_ress = rand(100,500);

//RESSOURCES DU DEFENSEUR CALCUL DE PERTE
$perte_population=(10*$pop['population'])/$retrait_aleatoire;

$perte_esclave_or=(10*$mine_or['esclave'])/$retrait_aleatoire;
$perte_ouvrier_or=(10*$mine_or['ouvrier'])/$retrait_aleatoire;

$perte_esclave_titane=(10*$mine_titane['esclave'])/$retrait_aleatoire;
$perte_ouvrier_titane=(10*$mine_titane['ouvrier'])/$retrait_aleatoire;

$perte_esclave_cristal=(10*$mine_cristal['esclave'])/$retrait_aleatoire;
$perte_ouvrier_cristal=(10*$mine_cristal['ouvrier'])/$retrait_aleatoire;

$perte_esclave_orinia=(10*$mine_orinia['esclave'])/$retrait_aleatoire;
$perte_ouvrier_orinia=(10*$mine_orinia['ouvrier'])/$retrait_aleatoire;

$perte_esclave_orinium=(10*$mine_orinium['esclave'])/$retrait_aleatoire;
$perte_ouvrier_orinium=(10*$mine_orinium['ouvrier'])/$retrait_aleatoire;


$perte_gold=(10*$ress['gold'])/$retrait_aleatoire_ress;
$perte_titane=(10*$ress['titane'])/$retrait_aleatoire_ress;
$perte_cristal=(10*$ress['cristal'])/$retrait_aleatoire_ress;
$perte_orinia=(10*$ress['orinia'])/$retrait_aleatoire_ress;
$perte_orinium=(10*$ress['orinium'])/$retrait_aleatoire_ress;

if($perte_population <= 0)
{
$perte_population = 0;
}
//PERTE DE LA POPULATION
$vol_popu=$bdd->prepare('UPDATE population SET population=population-? WHERE id_planete = ?');
$vol_popu->execute(array(ceil($perte_population),$id_planete_defenseur));


// PERTE DES RESSOURCES DU JOUEUR ATTAQUE
$perte=$bdd->prepare('UPDATE ressource SET gold=gold-?, titane=titane-?, cristal=cristal-?, orinia=orinia-?, orinium=orinium-?  WHERE id_planete = ? AND id_membre = ?');
$perte->execute(array(ceil($perte_gold),ceil($perte_titane),ceil($perte_cristal),ceil($perte_orinia),ceil($perte_orinium),$id_planete_defenseur,$id_membre_defenseur));



//ESCLAVES ET OUVRIERS MORT OR
$vol_popu=$bdd->prepare('UPDATE mines_joueur SET esclave=esclave-?, ouvrier=ouvrier-? WHERE id_planete = ? AND id_mine = ?');
$vol_popu->execute(array(ceil($perte_esclave_or),ceil($perte_ouvrier_or),$id_planete_defenseur,1));

//ESCLAVES ET OUVRIERS MORT TITANE
$vol_popu=$bdd->prepare('UPDATE mines_joueur SET esclave=esclave-?, ouvrier=ouvrier-? WHERE id_planete = ? AND id_mine = ?');
$vol_popu->execute(array(ceil($perte_esclave_titane),ceil($perte_ouvrier_titane),$id_planete_defenseur,2));

//ESCLAVES ET OUVRIERS MORT TITANE
$vol_popu=$bdd->prepare('UPDATE mines_joueur SET esclave=esclave-?, ouvrier=ouvrier-? WHERE id_planete = ? AND id_mine = ?');
$vol_popu->execute(array(ceil($perte_esclave_cristal),ceil($perte_ouvrier_cristal),$id_planete_defenseur,3));

//ESCLAVES ET OUVRIERS MORT TITANE
$vol_popu=$bdd->prepare('UPDATE mines_joueur SET esclave=esclave-?, ouvrier=ouvrier-? WHERE id_planete = ? AND id_mine = ?');
$vol_popu->execute(array(ceil($perte_esclave_orinia),ceil($perte_ouvrier_orinia),$id_planete_defenseur,4));

//ESCLAVES ET OUVRIERS MORT ORINIUM
$vol_popu=$bdd->prepare('UPDATE mines_joueur SET esclave=esclave-?, ouvrier=ouvrier-? WHERE id_planete = ? AND id_mine = ?');
$vol_popu->execute(array(ceil($perte_esclave_orinium),ceil($perte_ouvrier_orinium),$id_planete_defenseur,5));



// SAVE BDD
$ins=$bdd->prepare('INSERT INTO `save_vainqueur_cb_spatial`(`id_membre_att`, `pseudo_atta`, `id_planete`, `id_membre_def`, `pseudo_def`, `numero_combat`, `resultat`, `p_population`,`p_ouvrier_or`,`p_esclave_or`,`p_ouvrier_titane`,`p_esclave_titane`,`p_ouvrier_cristal`,`p_esclave_cristal`,`p_ouvrier_orinia`,`p_esclave_orinia`,`p_ouvrier_orinium`,`p_esclave_orinium`, gold,titane,cristal,orinia,orinium,rapport_lu) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?,?,?,?,?,?)');
$ins->execute(array($id_membre,$pseudo_attaquant,$id_planete_defenseur,$id_membre_defenseur,$pseudo_defenseur,$numero_combat_spatial,"attaquant",$perte_population,$perte_ouvrier_or,$perte_esclave_or,$perte_ouvrier_titane,$perte_esclave_titane,$perte_ouvrier_cristal,$perte_esclave_cristal,$perte_ouvrier_orinia,$perte_esclave_orinia,$perte_ouvrier_orinium,$perte_esclave_orinium,$VG,$VT,$VC,$VO,$VOR,0));


//AJOUTE DU MORAL ATTAQUANT GAGNE 1
$moral=$bdd->prepare('UPDATE moral SET moral=moral+? WHERE pseudo_membre=? AND id_membre=?');
$moral->execute(array(1,$pseudo_attaquant,$id_membre_attaquant));

//AJOUTE DU MORAL DEFENSEUR PERD 1
$moral=$bdd->prepare('UPDATE moral SET moral=moral-? WHERE pseudo_membre=? AND id_membre=?');
$moral->execute(array(1,$pseudo_defenseur,$id_membre_defenseur));


//AJOUTE 1 combat aux deux joueurs
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET combat_total = combat_total + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_attaquant));

$historique=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET combat_total = combat_total + ? WHERE id_membre = ? ');
$historique->execute(array(1,$id_membre_defenseur));

// Ajoute 2 points a l'attaquant
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET point_combat = point_combat + ? WHERE id_membre = ? ');
$historique_a->execute(array(2,$id_membre_attaquant));

// Ajoute  1 victoire a l'attaquant
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET victoire = victoire + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_attaquant));

//Ajoute 1 defaite au defenseur
// Ajoute  1 victoire a l'attaquant
$historique_a=$bdd->prepare('UPDATE historique_combat_spatial_joueur SET defaite = defaite + ? WHERE id_membre = ? ');
$historique_a->execute(array(1,$id_membre_defenseur));

//PARTIE GUERRE ALLIANCE

//En cas de victoire sur un adversaire d'une guerre il faut ajouter les points de guerre
$recup=$bdd->prepare('SELECT * FROM alliance_membre WHERE id_membre = ?');
$recup->execute(array($id_membre_attaquant));
$REC=$recup->fetch();

$ID_ALLIANCE_UN = htmlentities($REC['id_alliance']);

//RECUPERER LE NUMERO DE l'alliance vise
$recup=$bdd->prepare('SELECT * FROM alliance_membre WHERE id_membre = ?');
$recup->execute(array($id_membre_defenseur));
$REC_B=$recup->fetch();

$ID_ALLIANCE_DEUX = htmlentities($REC_B['id_alliance']);

// Ajouter les points à l'alliance en fonction de l'alliance

// ca ne marche pas
// Ajoute 2 points a l'attaquant
$historique_G=$bdd->prepare('UPDATE alliance_guerre SET point = point + ? WHERE id_alliance_un = ?  AND id_alliance_deux = ? ');
$historique_G->execute(array(5,$ID_ALLIANCE_UN,$ID_ALLIANCE_DEUX));



?>
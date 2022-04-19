<?php



//ON RECUPERE LE PSEUDO
$Pseud=$bdd->prepare('SELECT * FROM membre WHERE id = ?');
$Pseud->execute(array($id_membre_attaquant));
$PsdAtt=$Pseud->fetch();

//PSEUDO ATTAQUANT
$PseudoAttaquant = $PsdAtt['pseudo'];


// RECUP�RATION DE SA PLANETE ME
$IdMD=$bdd->prepare('SELECT * FROM planete WHERE id_membre = ? AND planete_mere = ?');
$IdMD->execute(array($id_membre_defenseur,1));
$PlaneteMO=$IdMD->fetch();

//ON R�CUP L'ID DE SA 
$PlaneteMereOrigine = htmlentities($PlaneteMO['id']);

/* MESSAGE POUR INFORMER LA COLONISATION */
//ON VA UPDATE LA PAGE DU JOUEUR QUI A LA PLANETE VOLE
//QU'IL NE SOIT PAS SUR LA PAGE DE LA PLANETE EXISTANT PLUS



$message_combat= 'Vous avez capturé la colonie du joueur attaqué. Félicitation.'; 
$message_combat_deux = 'Suite au combat spatial, votre planète étant sans défenses vous avez perdu une de vos colonie.';

$message_attaquant=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_attaquant->execute(array($id_membre_attaquant,$id_membre_attaquant,$message_combat,time(),0," Rapport: Nouvelle planete"));
								
$message_defenseur=$bdd->prepare('INSERT INTO messagerie (id_expediteur, id_destinataire, message, dat_envoi, lu, objet) VALUES (?,?,?,?,?,?)');
$message_defenseur->execute(array($id_membre_attaquant,$id_membre_defenseur,$message_combat_deux,time(),0," Rapport : Perte planete"));




//On enregistre les ressources
$req_m=$bdd->prepare('SELECT * FROM ressource WHERE id_planete = ?');
$req_m->execute(array($id_planete_defenseur));
$R=$req_m->fetch();

$gold = htmlentities($R['gold']);
$titane = htmlentities($R['titane']);
$cristal = htmlentities($R['cristal']);
$orinia = htmlentities($R['orinia']);
$orinium = htmlentities($R['orinium']);
$organique = htmlentities($R['organique']);


//ON VA UPDATE TOUT CE UI APPARTIENT A LA PLANETE POUR LUI VOLER
//ON LE RENVOI SUR SA PLANETE MERE
$ch=$bdd->prepare('UPDATE membre SET planete_utilise = ? WHERE id = ?');
$ch->execute(array($PlaneteMereOrigine,$id_membre_defenseur));

//ATTAQUE SALLE DE CONTROLE
$ch=$bdd->prepare('UPDATE attaque_sdc SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//BOUCLIER JOUEUR	--------> SERRAIT IMPOSSIBLE A ATTAQUER

$aleatoire = rand(20,30);

//ON BAISSE LA STABILITE DU JOUEUR A 0
$ch=$bdd->prepare('UPDATE stable SET stabilite = stabilite-? WHERE id_membre = ?');
$ch->execute(array($aleatoire,$id_membre_attaquant));



//CHANTIER SPATIAL
$ch=$bdd->prepare('UPDATE chantier_spatial SET id_joueur = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//CONSTRUCTION CASERNE
$ch=$bdd->prepare('UPDATE construction_caserne SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//CONSTRUCTION ETAB
$ch=$bdd->prepare('UPDATE construction_etab SET joueur = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//CONSTRUCTION HANGAR
$ch=$bdd->prepare('UPDATE construction_hangar SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//CONSTRUCTION DEFENSE
$ch=$bdd->prepare('UPDATE construction_defense SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//CONSTRUCTION EQUIPE
$ch=$bdd->prepare('UPDATE construction_equipe SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//CONSTRUCTION OBJET
$ch=$bdd->prepare('UPDATE construction_objet SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));


//ETABLISSEMENT
$ch=$bdd->prepare('UPDATE etablissement_joueur SET joueur = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//EXPLORATION JOUEUR
$ch=$bdd->prepare('UPDATE exploration_joueur SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//INFRASTRUCTURE
$ch=$bdd->prepare('UPDATE infrastructure SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//OBJET JOUEUR
$ch=$bdd->prepare('UPDATE objet_joueur SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//OBJET RARE
$ch=$bdd->prepare('UPDATE objet_rare SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//PLANETE
$ch=$bdd->prepare('UPDATE planete SET id_membre = ? WHERE id = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//RESSOURCES
$ch=$bdd->prepare('UPDATE ressource SET id_membre = ?, gold = ?, titane= ?, cristal = ?, orinia = ?, orinium=?,organique = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$gold,$titane,$cristal,$orinia,$orinium,$organique,$id_planete_defenseur));


//TERRITOIRE
$ch=$bdd->prepare('UPDATE territoire_planete SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));

//VAISSEAUX SUR LA PLANETE
$ch=$bdd->prepare('UPDATE vaisseau_joueur SET id_membre = ? WHERE id_planete = ?');
$ch->execute(array($id_membre_attaquant,$id_planete_defenseur));


?>
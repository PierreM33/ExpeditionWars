<?php 
require_once('include/connexion_bdd.php');


//ENVOI VERS LA PARTIE JEU
if(isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && is_numeric($_SESSION['id'])){header('Location: game/sdc/salle_de_controle.php');}


?>
<!DOCTYPE html>
<html lan="fr">
<meta charset="utf-8">
<head>
	<title>Expedition Wars - Jeu en ligne par navigateur</title>
	<link href="<?php echo pathCSS(); ?>style3.css?v=00015" rel="stylesheet" type="text/css">
	<link href="<?php echo pathCSS(); ?>scrollbar.css?v=00007" rel="stylesheet" type="text/css">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="<?php echo pathJS(); ?>jquery.scrollbar.js"></script>
</head>
<body>

	<div class="planete"></div>
	<div class="lune"></div>
	<div class="station"></div>
	<div class="Bsat"></div>
	<div class="Ssat"></div>
	<div class="vaisseau"></div>
	
	<div class="overHome"></div>
	<header>
		<div class="btMob"></div>
		<div class="social">
			<span>NOUS SUIVRE : </span><a target="blank" href="https://www.facebook.com/expeditionwars/"><img src="<?php echo pathImg(); ?>accueil/ico_fb.png" alt="ico_fb.png" /></a>	
			<a target="blank" href="https://www.youtube.com/channel/UCSrCDnXyfk83EVYBSxpXrvw"><img src="<?php echo pathImg(); ?>accueil/ico_youtube.png" alt="ico_youtube.png" /></a>	
		</div>
	</header>
	<div class="mMob">
		<ul>
			<li><a href="index.php">ACCUEIL</a></li>
			<li><a href="https://www.youtube.com/watch?v=owJDwKKerqk&t=12s&ab_channel=ExpeditionWars">Youtube</a></li>
			<li><a id="histoire">HISTOIRE</a></li>
			<li><a id="races">RACES</a></li>
			<li><a id="presentation">PRÉSENTATION</a></li>
			<li><a id="images">IMAGES</a></li>
		</ul>
	</div>
	
	<!-- On affiche les erreurs -->
	<?php if(!empty($_SESSION['error_co'])){ echo $_SESSION['error_co']; } ?>
	<?php if(!empty($_SESSION['error'])){ echo $_SESSION['error']; } ?>
	
	<script>
		setInterval(function(){ $('.erreur').fadeOut(200); }, 5000);
		setInterval(function(){ $('.valide').fadeOut(200); }, 5000);
	</script>
	<!-- fin affichage des erreurs -->
	<nav>
		<div class="left_menu">
			<div class="leftBanim"></div>
			<div class="leftSanim"></div>
		</div>
		<div class="menu">
			<div class="leftLoader"></div>
			<div class="rightLoader"></div>
			<ul>
				<li><a href="index.php">ACCUEIL</a></li>
			<li><a href="https://www.youtube.com/watch?v=owJDwKKerqk&t=12s&ab_channel=ExpeditionWars">Youtube</a></li>
				<li><a id="histoire">HISTOIRE</a></li>
				<li><a id="races">RACES</a></li>
				<li><a id="presentation">PRÉSENTATION</a></li>
				<li><a id="images">IMAGES</a></li>
			</ul>
		</div>
		<div class="right_menu">
			<div class="rightBanim"></div>
			<div class="rightSanim"></div>
		</div>
	</nav>
	
	<div class="connexion">
		<div class="head_connexion">CONNEXION</div>
		<div class="body_connexion">
			<form action="php/users/connexion.php" method="post">
				<input class="connex"  type="text" name ="pseudoconnex" placeholder="Identifiant" />
				<input class="connex" type="password" name ="mdpconnex" placeholder="Mot de passe" />
				<a id="oubli">Mot de passe oublié ?</a>
				<input class="envoyer"  type="submit"  name="formconnexion" value="CONNEXION" />
				<div class="lct_bt"></div>
				<div class="rct_bt"></div>
				<div class="rcb_bt"></div>
				<div class="lcb_bt"></div>
			</form>
		</div>
	</div>
	<div class="oubli">
		<div class="inner-oubli">
			<button class="bt_close_oubli"></button>
			<div class="head_oubli">RAPPEL DE MOT DE PASSE</div>
			<div class="body_oubli">
				<form action="<?php echo pathPhp(); ?>users/oublier.php" method="post">
					<input type="texte" class="connex" placeholder="Votre pseudo" name="pseudo" id="pseudo" value="<?php if(isset($pseudo)) {echo $pseudo;} ?>"/>
					<input type="mail" class="connex" placeholder="Email" name="mail" id="mail" value="<?php if(isset($mail)) {echo $mail;}?>"/>
					<input class="envoyer" type="submit" value="RÉINITIALISER">
				</form>
			</div>
		</div>
	</div>
	
	<div class="informations">
		<div class="informations_title">INFORMATIONS</div>
		<div class="informations_body">
			<div class="scrollbar-outer">
				<?php
			 $r=$bdd->prepare('SELECT * FROM news ORDER BY id DESC LIMIT 0, 3');
			 $r->execute(array());
			 while($n=$r->fetch())
			 {
				 ?>
				<div class="bloc_news">
					<div class="titre"><?php echo htmlentities($n['titre']); ?></div>
						<div class="texte">
						<?php echo nl2br(htmlentities($n['message'])); ?>
						</div>
							<div class="date">Posté le <?php echo htmlentities($n['date']); ?> à <?php echo htmlentities($n['temps']); ?></div>
				</div>
				<hr />
				<?php
			 }
			 ?>
			</div>
		</div>
	</div>
	
	<div class="cadre_delai">
		<div class="head_delai">OUVERTURE LE 31.01.2019</div>
		<div class="body_delai"><?php require_once "portail/car.php" ; ?></div>
		<div class="foot_delai">Inscrivez vous sur le Forum pour recevoir un message 24H avant l'ouverture.</div>
	</div>
	
	<div class="inscription">
		<div class="inner_inscription">
			<div class="leftTopCorner"></div>
			<div class="rightTopCorner"></div>
			<div class="rightBottomCorner"></div>
			<div class="leftBottomCorner"></div>
			<div class="head_inscription">INSCRIVEZ-VOUS AUJOURD'HUI</div>
			<div class="body_inscription">
				<form method="POST" action="php/users/inscription.php">
					<div class="left_body">
						<input class="inscr" type="text"  placeholder="Choisissez votre pseudo" name="pseudo" id="pseudo" />
						<input class="inscr" type="email"  placeholder="Saisir votre Email" name="mail" id="mail" />
						<input class="inscr" type="email"  placeholder="Confirmez votre Email" name="mail2" id="mail2" />
						<input class="inscr" type="password"  placeholder="Choisir un mot de passe" name="mdp" id="mdp" />
						<input class="inscr" type="password"  placeholder="Resaisir votre mot de passe" name="mdp2" id="mdp2" />
					</div>
					<div class="right_body">
						<input class="inscr" type="text" placeholder="Nom de votre planète" name="planete" id="planete" />
						<div class="connex" id="race_input">Choissiez votre race</div>
						<select class="inscr" name="titre">
						  <option selected>Choisissez votre Titre</option> 
						  <option value="gouverneur">Gouverneur</option> 
						  <option value="maitre">Maître</option>
						  <option value="monsieur">Monsieur</option>
						  <option value="commandant">Commandant</option>
						  <option value="majeste">Majesté</option> 
						  <option value="seigneur">Seigneur</option>
						  <option value="empereur">Empereur</option>
						  <option value="general">Général</option>
						  <option value="tyran">Tyran</option> 
						  <option value="imperatrice">Impératrice</option>
						  <option value="roi">Roi</option>
						  <option value="sultan">Sultan</option>
						</select> 
						<input class="inscr" type="text" placeholder="Nom du parrain (Faculltatif)" name="parrain" id="parrain" />
						<input type="submit"  class="bt_inscr" value="VALIDER" >
					</div>
					<div class="cadre_races">
						<div class="race">
							<div class="race_title">HUMAINS</div>
							<div class="race_body">
								<figure>
									<figcaption class="fig1">
										<h2>Choisir cette race</h2>
										<input type="radio" class="check_race" name="race" id="1" value="humain">
										<img class="coche1" src="static/img/accueil/coche.png" alt="coche.png"/>
									</figcaption>
									<img src="static/img/accueil/race_humain.png" alt="race_humain.png">
								</figure>
							</div>
						</div>
						<div class="race">
							<div class="race_title">VALHARIENS</div>
							<div class="race_body">
								<figure>
									<figcaption class="fig2">
										<h2>Choisir cette race</h2>
										<input type="radio" class="check_race" name="race" id="2" value="valhar">
										<img class="coche2" src="static/img/accueil/coche.png" alt="coche.png"/>
									</figcaption>
									<img src="static/img/accueil/race_valharien.png" alt="race_valharien.png">
								</figure>
							</div>
						</div>
						<div class="race">
							<div class="race_title">ORAKS</div>
							<div class="race_body">
								<figure>
									<figcaption class="fig3">
										<h2>Choisir cette race</h2>
										<input type="radio" class="check_race" name="race" id="3" value="orak">
										<img class="coche3" src="static/img/accueil/coche.png" alt="coche.png"/>
									</figcaption>
									<img src="static/img/accueil/race_orak.png" alt="race_orak.png">
								</figure>
							</div>
						</div>
						<div class="race">
							<div class="race_title">DROÏDES</div>
							<div class="race_body">
								<figure>
									<figcaption class="fig4">
										<h2>Choisir cette race</h2>
										<input type="radio" class="check_race" name="race" id="4" value="droide">
										<img class="coche4" src="static/img/accueil/coche.png" alt="coche.png"/>
									</figcaption>
									<img src="static/img/accueil/race_droid.png" alt="race_droid.png">
								</figure>
							</div>
						</div>
						<div class="race_foot"><div class="envoyer">VALIDER</div></div>
					</div>
				</form>
			</div>
			<div class="foot_inscription"></div>
		</div>
	</div>
	
	<!--<div class="cadre_bas_gauche">
	
	</div> -->
	
	<div class="anim_bas_droite">
		<div class="multi-spinner-container">
			<div class="multi-spinner">
				<div class="multi-spinner">
					<div class="multi-spinner">
					   <div class="multi-spinner">
							<div class="multi-spinner">
								<div class="multi-spinner"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="logo">
		<img src="static/img/accueil/logo.png" alt="logo.png">
	</div>
	
	<div class="overlay"></div>
	
	<div class="cadre_mentions">
		<div class="inner-mentions">
			<div class="mentions_head"><!--<h2>MENTIONS LÉGALES--></h2></div>
		</div>
	</div>
	<div class="politique">
	
	</div>
	<div class="cgu">
		<div class="inner-cgu">
			<button class="bt_close_cgu"></button>
			<div class="head_cgu"><h2>CONDITIONS GÉNÉRALES D'UTILISATION</h2></div>
			<div class="body_cgu">
				<div class="scrollbar-outer">
					<h3>Charte d'inscription.</h3>

					<h3>Généralités</h3>
					
					Expedition-wars est un jeu spatial par navigateur accessible en ligne à l'adresse : https://expedition-wars.fr. Expedition-wars est un jeu gratuit et sans obligation d'achat, ouvert à tous les joueurs majeurs et aux mineurs, à conditions qu'ils aient obtenu l'autorisation de leurs parents ou de leur tuteur légal le cas échéant.

					<h3>Jeu gratuit</h3>

					En dehors du jeu, il existe sur le site un ensemble d'options et services payants. L'utilisation de ces services et options étant facultatifs, ils ne sauraient faire l'objet d'une demande de remboursement. Les informations sur ces services ainsi que leurs coûts est clairement stipulé lors de l'achat.

					<h3>Validité du compte</h3>

					Un compte actif n'a pas de durée de validité dans le temps. Mais si un joueur ne se connecte pas pendant une période de plus de 6 mois, les webmestres se réservent le droit de supprimer son compte et ce, sans préavis.
					La pratique du multi-compte (plusieurs inscriptions pour le même utilisateur) est interdite. Tous les comptes de l'utilisateur pratiquant le multi-compte pourront être supprimés sans préavis par les webmestres ou administrateurs du jeu.

					<h3>Echange de message</h3>

					Sur le jeu et le forum*, des modules (messagerie, tchat, blogs,etc..) permettent l'échange de messages et le dialogue entre joueurs. Il est interdit de tenir des propos injurieux, racistes, sexistes, discriminatoires. D'une manière générale, vous êtes tenus de respecter les lois en vigueur en France. Les utilisateurs sont seuls responsables des propos tenus et des informations échangées (textes, images, etc.). Les webmestres et/ou administrateurs du jeu se réservent le droit de supprimer sans préavis tout élément ne respectant pas ces règles.

					<h3>Vos données personnelles.</h3>

					Les informations que nous sommes amenés à recueillir resteront confidentielles. Nous n'enregistrons et ne transmettons en aucun cas vos données personnelles. Sauf à l'occasion d'un jeu ou d'un concours par exemple. Votre enregistrement dans la base de données des newsletters** nous permet de vous envoyer les actualités par e-mail issues du ou des sites de votre choix.
					Un joueur peut à tout moment se désinscrire du site en cliquant sur le lien de désinscription se trouvant dans l'édition de son profil. La suppression du compte est alors immédiate et définitive et le joueur ne pourra prétendre à aucune demande de remboursement.

					<p>* Forums : L'outil de forum est lié à la base de données de Newsletter et la création d'un profil unique entre le système de newsletter et le forum est actuellement disponible.</p>

					** Newsletters : Nous portons une grande attention à la confidentialité de vos données. Celles-ci sont enregistrées dans notre base personnelle et ne sont pas cédées à des tiers. Vous disposez par ailleurs d'un droit d'accès, de rectification, de modification et de suppression concernant les données qui vous concernent. Vous pouvez exercer ce droit en envoyant un mail en utilisant l'adresse indiquée sur la page où nous vous demandons de remplir vos coordonnées ou en utilisant le lien proposé en bas des newsletters que vous recevez.

					<h3>Modifications</h3>

					Les responsables du site se réservent le droit de modifier à tout moment les présentes conditions. Si nous décidons de changer notre politique d'intimité, nous signalerons ces changements sur notre page d'accueil ainsi nos utilisateurs seront informés sur les informations que nous rassemblons, comment nous l'utilisons, et dans quelles circonstances. Les utilisateurs auront le choix de savoir si oui ou non nous utilisons leurs informations de cette façon.

					<h3>L'univers du jeu</h3>

					L'univers du jeu Expedition-wars, l'histoire, les personnages, les événements clés, le récit et l'ensemble de ce qui constitue la trame de fond du jeu sont la propriété de son créateur Pierre BOURDAIS. En jouant à Expedition-wars, vous créez un compte qui rentre dans cet univers et vos actions vont être amenées à le modifier. L'ensemble des changements que vous êtes susceptibles d'apporter à l'univers par le biais de vos actions dans le jeu ou les récits que vous faites sur le forum ou tout autre média est susceptible d'être intégré à l'univers officiel et devenir la propriété de son créateur. L'univers d'Expedition-wars n'est pas libre d'utilisation. En vous inscrivant au site et en acceptant cette charte vous obtenez le droit de l'utiliser à des fins non commerciales et dans le cadre stricte du jeu en ligne expedition-wars.fr. En contrepartie vous cédez les droits de vos créations littéraires et graphiques faites dans le cadre de ce jeu. La publication de textes sur le forum le site ou le blog équivaut à une cession des droits.
					NOTEZ BIEN que tout travail que vous réalisez avec notre Propriété Intellectuelle ne vous «appartient» pas. Il s'agit d'une «oeuvre dérivée», et les parties de votre site basées sur notre PI ne peuvent être utilisées sans notre autorisation en notre qualité de propriétaire des oeuvres d'origine. Gardez-le toujours en mémoire lorsque vous utilisez notre PI.

					<h3>Sites liés</h3>

					Expedition-wars propose des liens vers d'autres sites. Expedition-wars n'ayant aucun contrôle sur ces sites, Expedition-wars n'est pas responsable et ne peut pas être tenu responsable de la disponibilité de ces sites ou de la fiabilité de leur contenu, des publicités, des produits ou d'autres éléments présents ou disponibles sur ces sites. Les liens vers ces sites sont fournis pour votre confort et vous y accédez à vos risques et périls. De plus, Expedition-wars n'est pas responsable ou être tenu pour responsable, directement ou indirectement, pour tout dommage ou perte causé ou présumé causé par ou durant une connexion à l'un de ces sites et consécutif à l'utilisation du contenu, des biens et des services présents sur ces sites.
				</div>
			</div>
			<div class="cguAnim">
				<div class="content_anim">
					<div class="dot dot-one"></div>
					<div class="dot dot-two"></div>
					<div class="dot dot-three"></div>
					<div class="dot dot-four"></div>
					<div class="dot dot-five"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="partenaires">
		<div class="inner-partenaires">
			<button class="bt_close_partenaires"></button>
			<div class="head_partenaires"><h2>LISTE DE NOS PARTENAIRES</h2></div>
			<div class="body_partenaires">
				<div class="scrollbar-outer">
					<!-- Partie à dupliquer -->
					<section>
						<a href="https://terre-noire.fr/"><img src="https://terre-noire.fr/static/img/thumbs.jpg" alt="thumbs.jpg" /></a> <h3>Terre Noire</h3>
					
						<p>Terre Noire est un jeu de rôle gratuit multijoueurs en ligne qui plonge ses protagonistes au cœur d'une guerre de pouvoir et de contrôle. Ce jeu est entièrement évolutif dans son histoire par les joueurs eux-même grâce à leur implication au sein même de la communauté et de leur capacité à devenir de bon RPistes.</p>
					
						<a href="https://terre-noire.fr">https://terre-noire.fr</a>
					</section>

					<!-- fin de la Partie à dupliquer -->
										<!-- Partie à dupliquer -->
					<section>
						<a href="https://www.amazon.fr/%C3%80-vie-mort-Laura-ANTONINI/dp/B07D51Y7QK"><img src="https://expedition-wars.fr/static/img/partenaire/laura.jpg" alt="thumbs.jpg" /></a> <h3>À la vie, à la mort</h3>
					
						<p>
						Dans un monde futuriste, l’argent a disparu et les achats se règlent au prix du sang, à crédit, ou en prélevant directement sur son espérance de vie. Maëlys prend peu à peu conscience des effets néfastes de ce système et des dangers encourus, surtout lorsque son frère jumeau aux mœurs peu recommandables décède prématurément.
						</p>
					
						<a href="https://www.amazon.fr/%C3%80-vie-mort-Laura-ANTONINI/dp/B07D51Y7QK">Cliquez ici : À la vie, à la mort</a>
					</section>

					<!-- fin de la Partie à dupliquer -->
					<!-- Partie à dupliquer -->
					<section>
						<a href="https://soundcloud.com/riraksa"><img src="https://expedition-wars.fr/static/img/partenaire/risaka.png" alt="thumbs.jpg" /></a> <h3>Riraksa Sounds</h3>
					
						<p>Rakshasa, dix-neuf ans et compositeur amateur néophyte ayant complété sept ans de formation musicale. Je crées des musiques personnalisées en fonction de la demande à ceux qui d'aventure me passent commande.</p>
					
						<a href="https://soundcloud.com/riraksa">https://soundcloud.com/riraksa</a>
					</section>

					<!-- fin de la Partie à dupliquer -->
										<!-- Partie à dupliquer -->
					<section>
						<a href="https://cryptomaniaks.com/?fbclid=IwAR07E7K9rQKo4y9AVn_lLzShmvUwId7k707JgVTXcdTAoVgQznJ1nG282-k"><img src="https://expedition-wars.fr/static/img/partenaire/btc.png" alt="thumbs.jpg" /></a> <h3>Cryptomaniaks</h3>
					
						<p>La principale plate-forme d'éducation sur la crypto-monnaie. </br></br>Votre guide expert dans le monde des bitcoins et des cryptomonnaies.</p>
					
						<a href="https://cryptomaniaks.com/?fbclid=IwAR07E7K9rQKo4y9AVn_lLzShmvUwId7k707JgVTXcdTAoVgQznJ1nG282-k">https://cryptomaniaks.com</a>
					</section>

					<!-- fin de la Partie à dupliquer -->
					
															<!-- Partie à dupliquer -->
					<section>
						<a href="https://anouck.book.fr/?fbclid=IwAR3MPhToiCFUYCGcBACiMOEI-VzmRQFIjVFHi3j1GR-385jVgG57zjK1OZM"><img src="https://expedition-wars.fr/static/img/partenaire/anouck.jpg" alt="thumbs.jpg" /></a> <h3>Anouck</h3>
					
						<p>Bonjour et bienvenue sur mon book photo ! Je vous invite à découvrir des photos diverses et variées et pour en voir toujours plus voici mon instagram : @anouck.es. </br> N'hésitez pas à me contacter pour toutes précisions.
						Bonne visite et à bientôt! </br> Anouck</p>
					
						<a href="https://anouck.book.fr/?fbclid=IwAR3MPhToiCFUYCGcBACiMOEI-VzmRQFIjVFHi3j1GR-385jVgG57zjK1OZM">Lien vers le book!</a>
					</section>

					<!-- fin de la Partie à dupliquer -->
				</div>
			</div>
			<div class="cguAnim">
				<div class="content_anim">
					<div class="dot dot-one"></div>
					<div class="dot dot-two"></div>
					<div class="dot dot-three"></div>
					<div class="dot dot-four"></div>
					<div class="dot dot-five"></div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="histoire">
		<div class="inner_histo">
			<button class="bt_close_histo"></button>
			<div class="histo_title">HISTOIRE DE L'UNIVERS EXPEDITION WARS</div>
			<div class="histo_body">
				<div class="scrollbar-outer">
					<h1>INTRODUCTION</h1>
					Tout commença il y a des siècles dans la Voie Lactée.<br />
					Les "Oraks", maîtres incontestés de cette partie de l'Univers, dominaient toutes les planètes et réduisaient leurs habitants en esclavage jusqu'au jour où les "Valhars" débarquèrent, venant d'une autre galaxie, chassés par les "Droïdes" contre lesquels ils menaient une lutte depuis des millénaires. 

					<p>La guerre éclata entre les "Valhars" et les "Oraks". Ces derniers, plus nombreux mais moins puissant que leurs adversaires, durent se résoudre à un accord afin d'enrayer le massacre après des années de conflit.</p> 

					<p>Les deux "Grand Conseil" de chaque race se retrouvèrent sur une planète neutre de la galaxie où le traité de paix fut signé entre les représentants de chaque peuple avec la règle suivante : Non agression sur les territoires contrôlés.<br /> 
					La paix prit alors place dans la Voie Lactée et ce pendant des siècles...</p> 

					<p>Puis vint l'émergence des Humains devenus libres de leurs développement technologique. Les "Valhars" trouvèrent en eux de précieux compagnons, une alliance naquit entre les deux peuples. Cependant, les humains ne tardèrent pas à coloniser petit à petit la galaxie se confrontant de façon régulière à la dictature imposée par les "Oraks", ceux-ci finirent par se révolter contre la suprématie et l'esclavagisme des "Oraks".</p>

					<p>Constatant ceci, les "Oraks" rompirent le traité de paix sans attendre. La guerre fut de nouveau présente dans la galaxie. </p>

					<p>Mais un jour au fil des explorations une équipe fit une curieuse découverte dans une lointaine bibliothèque oubliée, celle des vestiges d'un ancien peuple appelé "Ankariens", vraisemblablement disparu...</p>
				</div>
			</div>
			<div class="histo_foot">
				<div id="block_1" class="barlittle"></div>
				<div id="block_2" class="barlittle"></div>
				<div id="block_3" class="barlittle"></div>
				<div id="block_4" class="barlittle"></div>
				<div id="block_5" class="barlittle"></div>
			</div>
		</div>
	</div>
	<div class="races">
		<div class="inner-races">
			<ul>
				<li id="1" class="bt_L bt"><span class="bt_races_corner-left"></span>HUMAINS<span class="bt_races_corner-right"></span></li>
				<li id="2" class="bt_L bt"><span class="bt_races_corner-left"></span>VALHARIENS<span class="bt_races_corner-right"></span></li>
				<li id="3" class="bt_S bt"><span class="bt_races_corner-left"></span>ORAKS<span class="bt_races_corner-right"></span></li>
				<li id="4" class="bt_S bt"><span class="bt_races_corner-left"></span>DROÏDES<span class="bt_races_corner-right"></span></li>
			</ul>
			<button class="bt_close_races"></div>
			<!-- Cadre des Humains -->
			<div class="body_races_accueil activ_race" id="race1">
				<div class="raceHead">
					<div class="img_race"><img src="static/img/accueil/humain_150.jpg" alt="humain_150.jpg" /></div>
					<div class="descript_left">
						<h2>HUMAINS</h2>
						<div class="plus"><img src="static/img/accueil/plus.png" alt="plus.png" /></div>
						<div class="moins"><img src="static/img/accueil/moins.png" alt="moins.png" /></div>
					</div>
					<div class="descript_right">
						<div class="desc_plus">
							Production de population : 100/heures. Race forte contre les Droïdes.
						</div>
						<div class="desc_moins">
							En difficulté contre les Oraks et Valhariens.
						</div>
					</div>
				</div>
				<div class="raceBody">
					<div class="scrollbar-outer">
						Les humains vivent dans leur Voie lactée. Durant des siècles, ils ont été sous le joug des Oraks, jusquèà l'arrivée des Valhariens.
						
						<p>Leur alliance avec ce peuple, leur permit de s'émanciper technologiquement, de coloniser divers mondes et ainsi, de commencer la rebellion contre les Oraks.</p>
						
						<p>Bien que solidaires entre eux, les humains, ne sont pas pour autant les êtres les plus pacifiques et des conflits peuvent apparaître au sein de l'espèce. La liberté de chacun est pour eux, une notion primordiale pour laquelle, ils sont prêts à tous les sacrifices.</p>
						
						<p>Si leur niveau technologique n'est pas des plus performants, la maîtrise des stratégies martiales fait d'eux de bon combattants. Les combats dans l'espace sont devenus monnaie courante depuis plusieurs siècles, faisant de leurs vaisseaux, une flotte de combat acceptable.</p>
						
						<p>En effet, la croissance de leur population est tout juste suffisante, ce qui leur donne une raison de plus de s'allier avec ceux qui le veulent.</p>
					</div>
				</div>
			</div>
			
			<!-- Cadre des Valhariens -->
			<div class="body_races_accueil" id="race2">
				<div class="raceHead">
					<div class="img_race"><img src="static/img/accueil/valharien_150.jpg" alt="valharien_150.jpg" /></div>
					<div class="descript_left">
						<h2>VALHARIENS</h2>
						<div class="plus"><img src="static/img/accueil/plus.png" alt="plus.png" /></div>
						<div class="moins"><img src="static/img/accueil/moins.png" alt="moins.png" /></div>
					</div>
					<div class="descript_right">
						<div class="desc_plus">
							 Production de population : 80/heures. Race forte contre les humains et Oraks. 
						</div>
						<div class="desc_moins">
							En difficulté contre les Droïdes.
						</div>
					</div>
				</div>
				<div class="raceBody">
					<div class="scrollbar-outer">
						Originaires d'Andromède, les Valhariens sont un peuple de science, de sagesse et d'entraide. 

						<p>Ils durent fuir pour sauver leurs espèces après la création et la perte de contrôle des «Droïdes» après des millénaires de guerres. Ils arrivèrent dans la Voie Lactée où ils furent attaqués par les Oraks déjà présents.</p>

						<p>Après un conflit de plusieurs années à leur avantage, un traité de paix fut signé et leur permit de s'installer durablement dans la galaxie. </p>

						<p>Ils découvrirent alors les humains avec lesquels ils s'allièrent et partagèrent certains de leurs savoirs ce qui leur permirent de se rebeller contre les Oraks et ce malgré la volonté des Valhariens qui prônent avant tout la paix et n'envisagent la guerre qu'en dernier recours.</p>

						<p>Leur savoir est tel qu’ils sont largement supérieurs à quiconque dans l'univers.</p> 

						En revanche, leur population peine à s'accroître, arrivant tout juste à garder un équilibre démographique. 
					</div>
				</div>
			</div>
			
			<!-- Cadre des Oraks -->
			<div class="body_races_accueil" id="race3">
				<div class="raceHead">
					<div class="img_race"><img src="static/img/accueil/orak_150.jpg" alt="orak_150.jpg" /></div>
					<div class="descript_left">
						<h2>ORAKS</h2>
						<div class="plus"><img src="static/img/accueil/plus.png" alt="plus.png" /></div>
						<div class="moins"><img src="static/img/accueil/moins.png" alt="moins.png" /></div>
					</div>
					<div class="descript_right">
						<div class="desc_plus">
							Production de population : 110/heures. Race forte contre les Humains et les Valhariens.
						</div>
						<div class="desc_moins">
							En difficulté contre les Droïdes.
						</div>
					</div>
				</div>
				<div class="raceBody">
					<div class="scrollbar-outer">
						De loin le peuple le plus vicelard, dangereux et sauvage de l'Univers.

						<p>Arrivée d'une galaxie aujourd'hui disparue, cette race a envahi la Voie Lactée et l'a colonisée en peu de temps.</p>

						<p>Leur unique but est tout contrôler, de s'enrichir et en cas de conflit, de tout détruire. Les Oraks n'hésitent pas à réduire en esclavage leurs ennemis une fois les guerres terminées.</p>
						
						<p>Leur désir de combat est toutefois puissant et il arrive que des conflits éclatent au sein même du peuple, raison pour laquelle le « Grand Conseil » a été créé afin de limiter les dégâts et imposer des règles.</p>

						<p>Les Oraks ont un niveau technologique assez performant, bien qu'imparfait. C'est précisément pour cela qu'ils soumettent leurs ennemis afin de s'approprier leurs technologies.</p>

						Leur démographie est par ailleurs excellente ce qui leur permet de compenser la qualité et la puissance de leurs troupes par le nombre.
					</div>
				</div>
			</div>
			
			<!-- Cadre des Droïds -->
			<div class="body_races_accueil" id="race4">
				<div class="raceHead">
					<div class="img_race"><img src="static/img/accueil/droid_150.jpg" alt="droid_150.jpg" /></div>
					<div class="descript_left">
						<h2>DROÏDES</h2>
						<div class="plus"><img src="static/img/accueil/plus.png" alt="plus.png" /></div>
						<div class="moins"><img src="static/img/accueil/moins.png" alt="moins.png" /></div>
					</div>
					<div class="descript_right">
						<div class="desc_plus">
							Production de population : 120/heures. Race forte contre les Valhariens et les Oraks.
						</div>
						<div class="desc_moins">
							En difficulté contre les Humains.
						</div>
					</div>
				</div>
				<div class="raceBody">
					<div class="scrollbar-outer">
						Venus d'Andromède, les Droïdes sont le résultat d'une expérience qui a mal tourné. Créés par un savant Valharien, les prototypes ont développé une autonomie et une réflexion incontrôlables. 

						<p>Ils se sont reproduits en masse dans le laboratoire du savant complètement dépassé avant de l'éliminer et de prendre petit à petit possession du monde puis de la galaxie obligeant ainsi les Valhars à quitter Andromède. Sur leur passage, seule la destruction reste.</p>

						<p>Ils volent les technologies de tous ceux qu'ils croisent puis les déciment sans état d'âme et poursuivent ainsi leur route telles des armées de fourmis. Ils ne connaissent que l'alliance au sein de leur peuple, celle avec d'autres êtres est tout simplement inimaginable.</p>

						Leur nombre impressionnant est dû à leur capacité à se reproduire quasi-miraculeuse. Cela leur permet de compenser leur piètre qualité lors des combats. Leur niveau moyen en technologie est également un handicap que la supériorité numérique corrige plus ou moins. Car voler les technologies de leurs adversaires décimés ne signifie pas qu'ils les maîtrisent totalement, loin de là.
					</div>
				</div>
			</div>
			<div class="loader_races">
				<div class="content">
					<div class="circle"></div>
					<div class="circle1"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="presentation">
		<div class="inner-presentation">
			<div class="present_head"><h1>EXPEDITION WARS SE PRESENTE</h1></div>
			<button class="bt_close_presentation"></button>
			<div class="present_body">
				<div class="scrollbar-outer">
					<h2>Expedition Wars un jeu de conquête spatiale mais pas seulement...</h2>
					Expédition wars est un jeu de conquête et d'exploration spatiale.
					<h3>Votre objectif dans le jeu ?</h3>
					<ul>
						 <li>Vous débuterez comme dirigeant d'une planète dans l'univers.</li>
						 <li>Vous aurez le choix parmi quatre races ayant chacune des compétences spécifiques et une histoire propre.</li>
						 <li>Vous aurez plusieurs objectifs dans le jeu. Vous pourrez ainsi explorer la galaxie, y trouver les vestiges d'un ancien peuple disparu, résoudre des énigmes complexes,	trouver des cités perdues ainsi que des objets rares donnant de puissant bonus et en nombre limité dans l'univers.</li>
						 <li>Vous irez combattre vos ennemis pour accroître votre territoire, vous propageant alors sur un nombre infini de planètes ; voler les planètes de vos ennemis qui vous barrent le passage, conquérir des parcelles de l'univers... Évoluant en combat aérien à l'aide de vaisseaux spatiaux personnalisables et de diverses stratégies de combat.</li>
						 <li>Vous aurez également la possibilité que vos troupes partent au combat en traversant l'espace au moyen de vortex , voyageant de planète en planète ou directement déployées par vos vaisseaux spatiaux.</li>
						 <li>Visualisez votre empire, vos déplacements en temps réel grâce à une carte de l'univers et de la galaxie.</li>
						 <li>Gérer sur chacune de vos planètes les populations, les territoires ainsi qu'également ses relations sera un des facteurs important pour la stratégie de votre empire. Bonus/Malus seront présents et affecteront votre production, votre moral et rendra la gestion de votre empire complexe pour un gameplay vivant.</li>
						 <li>L'histoire de l'univers évoluera selon les actions des joueurs. Un univers dynamique, avec de nombreux éléments à gagner pour prospérer dans le jeu. Que ce soit vos alliances, vos guerres, vos recherches, tout ce que vous allez découvrir ou faire influera sur l'univers entier... A vous d'écrire l'avenir...</li>
					</ul>
				</div>
			</div>
			<div class="loader_present">
				<div class="content">
					<div class="circle"></div>
					<div class="circle1"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="images">
		<div class="inner-images">
			<div class="images_head"><h2>SCREENSHOTS</h2></div>
			<button class="bt_close_images"></div>
			<div class="images_body">
				<div class="thumbs">
					<div class="rowL">
						<img class="th" id="1" src="static/img/accueil/thumbs/thumb1.jpg" alt="thumb1.jpg" />
						<img class="th" id="3" src="static/img/accueil/thumbs/thumb3.jpg" alt="thumb3.jpg" />
						<img class="th" id="5" src="static/img/accueil/thumbs/thumb5.jpg" alt="thumb5.jpg" />
						<img class="th" id="7" src="static/img/accueil/thumbs/thumb7.jpg" alt="thumb7.jpg" />
						<img class="th" id="9" src="static/img/accueil/thumbs/thumb9.jpg" alt="thumb9.jpg" />
						<img class="th" id="11" src="static/img/accueil/thumbs/thumb11.jpg" alt="thumb11.jpg" />
						<img class="th" id="13" src="static/img/accueil/thumbs/thumb13.jpg" alt="thumb13.jpg" />
					</div>
					<div class="rowR">
						<img class="th" id="2" src="static/img/accueil/thumbs/thumb2.jpg" alt="thumb2.jpg" />
						<img class="th" id="4" src="static/img/accueil/thumbs/thumb4.jpg" alt="thumb4.jpg" />
						<img class="th" id="6" src="static/img/accueil/thumbs/thumb6.jpg" alt="thumb6.jpg" />
						<img class="th" id="8" src="static/img/accueil/thumbs/thumb8.jpg" alt="thumb8.jpg" />
						<img class="th" id="10" src="static/img/accueil/thumbs/thumb10.jpg" alt="thumb10.jpg" />
						<img class="th" id="12" src="static/img/accueil/thumbs/thumb12.jpg" alt="thumb12.jpg" />
						<img class="th" id="14" src="static/img/accueil/thumbs/thumb14.jpg" alt="thumb14.jpg" />
					</div>
				</div>
				<div class="projecteur">
					<img class="img default" id="image1" src="static/img/accueil/images/image1.jpg" alt="image1.jpg" />
					<img class="img" id="image2" src="static/img/accueil/images/image2.jpg" alt="image2.jpg" />
					<img class="img" id="image3" src="static/img/accueil/images/image3.jpg" alt="image3.jpg" />
					<img class="img" id="image4" src="static/img/accueil/images/image4.jpg" alt="image4.jpg" />
					<img class="img" id="image5" src="static/img/accueil/images/image5.jpg" alt="image5.jpg" />
					<img class="img" id="image6" src="static/img/accueil/images/image6.jpg" alt="image6.jpg" />
					<img class="img" id="image7" src="static/img/accueil/images/image7.jpg" alt="image7.jpg" />
					<img class="img" id="image8" src="static/img/accueil/images/image8.jpg" alt="image8.jpg" />
					<img class="img" id="image9" src="static/img/accueil/images/image9.jpg" alt="image9.jpg" />
					<img class="img" id="image10" src="static/img/accueil/images/image10.jpg" alt="image10.jpg" />
					<img class="img" id="image11" src="static/img/accueil/images/image11.jpg" alt="image11.jpg" />
					<img class="img" id="image12" src="static/img/accueil/images/image12.jpg" alt="image12.jpg" />
					<img class="img" id="image13" src="static/img/accueil/images/image13.jpg" alt="image13.jpg" />
					<img class="img" id="image14" src="static/img/accueil/images/image14.jpg" alt="image14.jpg" />
				</div>
			</div>
			<div class="loader_images">
				<div class="content">
					<div class="circle"></div>
					<div class="circle1"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="bottomLeft">
		<div class="inner-bLeft">
			<a href="https://discord.gg/FKXx6FX" target="_blank"><img src="static/img/blank.png" alt="ico_discord.png"/></a>
		</div>
	</div>
	<footer>
		&copy; COPYRIGHT EXPÉDITION-WARS 2019 - AUTEUR : MALIBX - DESIGN PAR STEFDE3 - <a id="cgu">CONDITIONS GÉNÉRALES D'UTILISATION</a> - <font color="#33A8FF"><b><a id="partenaires">PARTENAIRES</a></b></font> 
	</footer>
	
</body>
<script src="static/js/core.js?v=00005"></script>
<script>
	$(document).ready(function(){
		$('.scrollbar-outer').scrollbar();
	});
</script>
<noscript>Votre navigateur n'a pas JavaScript d'activé !</noscript>
	
</html>

<?php if(!empty($_SESSION['error'])) $_SESSION['error'] = array(); ?>
<?php if(!empty($_SESSION['error_co'])) $_SESSION['error'] = array(); ?>
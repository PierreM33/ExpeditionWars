$(document).ready(function() {
	$('#race_input').click(function() {
		$(".overlay").fadeIn(200);
		$(".cadre_races").css({'display':"flex"}, 200);
	});
	
	$('div.envoyer').on('click', function(){
		$(".overlay").fadeOut(200);
		$(".cadre_races").fadeOut(200);
	});
	
	
	$('input[type="radio"].check_race').on('click', function(){
		//On récupère l'id et le nom de la radio
		var id = $(this).attr('id');
		var value = $(this).attr('value');

		$('.cadre_races > .race > .race_body').each(function( index, element ) {
			var inputRadio	= $(this).find('input[type="radio"]');
			var idRace		= inputRadio.attr('id');

			$('.fig' + idRace + ' > h2').html('Choisir cette race');
			$('.fig' + idRace).removeAttr('style');
			$('.coche' + idRace).css({'display':'none'});
		});

		/* Sur la race sélectionnée */	
		$('.fig' + id + ' > h2').html('Race sélectionnée');
		$('.fig' + id).css({'display':"block"});
		$('.coche' + id).css({'display':"block"});
		$('div.connex').html(value);
	});
});

$(document).ready(function() {
	
	//on affiche le cadre du choix des races à l'inscription "sans" fond noir transparent
	
	$('#race_input').click(function() {
		$(".cadre_races").css({'display':"flex"}, 200);
	});
	
	//on cache le cadre du choix des races
	$('div.envoyer').on('click', function(){
		$(".cadre_races").fadeOut(200);
	});
	
	
	// Choix des races à l'inscription
	
	$('input[type="radio"].check_race').on('click', function(){
		//On récupère l'id et le nom de la radio
		var id = $(this).attr('id');
		var value = $(this).attr('value');

		$('.cadre_races > .race > .race_body').each(function( index, element ) {
			var inputRadio	= $(this).find('input[type="radio"]');
			var idRace		= inputRadio.attr('id');

			$('.fig' + idRace + ' > h2').html('Choisir cette race');
			$('.fig' + idRace + ' > h2').removeClass('white');
			$('.fig' + idRace).removeAttr('style');
			$('.coche' + idRace).css({'display':'none'});
		});

		// Sur la race sélectionnée 	
		$('.fig' + id + ' > h2').html('Race sélectionnée');
		$('.fig' + id + ' > h2').addClass('white');
		$('.fig' + id).css({'display':"block"});
		$('.coche' + id).css({'display':"block"});
		$('div.connex').html(value);
	});
	
	
	
	// Changer les infos sur les races au click du bouton concerné
	
	$('li.bt').on('click', function() {
		//On récupère l'id de la description de la race concernée
		var id = $(this).attr('id');
				
		$('.body_races_accueil').removeClass('activ_race').fadeOut(200);
		
		// Sur la race sélectionnée on affiche sa description
		$('.body_races_accueil#race' + id).addClass('activ_race').fadeIn(200);
	});
	
	
	
	// Changer la grande image du projecteur sur le click des vignettes
	$('img.th').on('click', function() {
		//On récupère l'id de la vignette
		var id = $(this).attr('id');
		
		// On efface toutes les grandes images		
		$('img.img').removeClass('default').fadeOut(200);
		
		// Sur la vignette sélectionnée on affiche sa grande image
		$('img.img#image' + id).addClass('default').fadeIn(200);
	});
	
	
	
	
	// On affiche le cadre descriptif des races avec son fond noir transparent
	$('a#races').on('click', function() {
		$(".overlay").fadeIn(200);
		$('.races').fadeIn(200);
		$('.histoire').fadeOut(200);
		$('.presentation').fadeOut(200);
		$('.images').fadeOut(200);
		$('.cgu').fadeOut(200);
		$('.partenaires').fadeOut(200);
	});
	//on cache le cadre  descriptif des races et le fond noir transparent
	$('.bt_close_races').on('click',function() { 
		$(".overlay").fadeOut(200);
		$('.races').fadeOut(200);
	});
	
	
	// On affiche le cadre d'histoire avec son fond noir transparent
	$('a#histoire').on('click', function() {
		$(".overlay").fadeIn(200);
		$('.histoire').fadeIn(200);
		$('.presentation').fadeOut(200);
		$('.images').fadeOut(200);
		$('.races').fadeOut(200);
		$('.cgu').fadeOut(200);
		$('.partenaires').fadeOut(200);
	});
	//on cache le cadre d'histoire et le fond noir transparent
	$('.bt_close_histo').on('click',function() { 
		$(".overlay").fadeOut(200);
		$('.histoire').fadeOut(200);
	});
	
	// On affiche le cadre de présentation avec son fond noir transparent
	$('a#presentation').on('click', function() {
		$(".overlay").fadeIn(200);
		$('.presentation').fadeIn(200);
		$('.images').fadeOut(200);
		$('.races').fadeOut(200);
		$('.histoire').fadeOut(200);
		$('.cgu').fadeOut(200);
		$('.partenaires').fadeOut(200);
	});
	//on cache le cadre de présentation et le fond noir transparent
	$('.bt_close_presentation').on('click',function() { 
		$(".overlay").fadeOut(200);
		$('.presentation').fadeOut(200);
	});
	
	// On affiche le cadre des images avec son fond noir transparent
	$('a#images').on('click', function() {
		$(".overlay").fadeIn(200);
		$('.images').fadeIn(200);
		$('.races').fadeOut(200);
		$('.histoire').fadeOut(200);
		$('.presentation').fadeOut(200);
		$('.cgu').fadeOut(200);
		$('.partenaires').fadeOut(200);
	});
	//on cache le cadre des images et le fond noir transparent
	$('.bt_close_images').on('click',function() { 
		$(".overlay").fadeOut(200);
		$('.images').fadeOut(200);
	});
	
	// On affiche le cadre des CGU avec son fond noir transparent
	$('a#cgu').on('click', function() {
		$(".overlay").fadeIn(200);
		$('.cgu').fadeIn(200);
		$('.races').fadeOut(200);
		$('.histoire').fadeOut(200);
		$('.presentation').fadeOut(200);
		$('.images').fadeOut(200);
		$('.partenaires').fadeOut(200);
	});
	//on cache le cadre des CGU et le fond noir transparent
	$('.bt_close_cgu').on('click',function() { 
		$(".overlay").fadeOut(200);
		$('.cgu').fadeOut(200);
	});
	
	// On affiche le cadre des CGU avec son fond noir transparent
	$('a#partenaires').on('click', function() {
		$(".overlay").fadeIn(200);
		$('.partenaires').fadeIn(200);
		$('.races').fadeOut(200);
		$('.histoire').fadeOut(200);
		$('.presentation').fadeOut(200);
		$('.images').fadeOut(200);
		$('.cgu').fadeOut(200);
	});
	//on cache le cadre des CGU et le fond noir transparent
	$('.bt_close_partenaires').on('click',function() { 
		$(".overlay").fadeOut(200);
		$('.partenaires').fadeOut(200);
	});
	
	//on affiche la cadre du mot de passe oublié
	$('a#oubli').on('click', function() {
		$('.oubli').fadeIn(200);
	});
	//On cache la cadre du mot de passe oublié
	$('.bt_close_oubli').on('click',function() { 
		$('.oubli').fadeOut(200);
	});
	
	// Animation des bouttons d'accueil 
	$('.envoyer').hover(function() {
		$('.lct_bt').css({'top' : "94px", 'left' : "6px"});
		$('.rct_bt').css({'top' : "94px", 'right' : "10px"});
		$('.rcb_bt').css({'bottom' : "-5px", 'right' : "10px"});
		$('.lcb_bt').css({'bottom' : "-5px", 'left' : "6px"});
	});
	$('input[type=submit].envoyer').mouseleave(function() {
		$('.lct_bt').css({'top' : "99px", 'left' : "11px"});
		$('.rct_bt').css({'top' : "99px", 'right' : "15px"});
		$('.rcb_bt').css({'bottom' : "0", 'right' : "15px"});
		$('.lcb_bt').css({'bottom' : "0", 'left' : "11px"});
	});
	
	$('.btMob').on('click', function() {
		$('.mMob').toggle(200);
	});
	
	$('a').on('click', function() {
		var id = $(this).attr('id');
		if ($(window).width() < 860) {
			if(id != 'oubli' && id != 'cgu' && id != 'partenaires') {
				$('div.'+id).fadeIn(200);
				$('.mMob').toggle();
			};
		};
	});
	
	$('.erreur').on('click', function() {
		$(this).fadeOut(200);
	});
	
	$('.valide').on('click', function() {
		$(this).fadeOut(200);
	});
	
	if ($(window).width() < 860) {
		// On modifie le texte de mot de passe oublié car trop long
		$('a#oubli').html('oubli ?');
		// On modifie le texte des placeholder pour l'inscription mobile
		$('input#pseudo').attr('placeholder', "Pseudo");
		$('input#mail').attr('placeholder', "Email");
		$('input#mail2').attr('placeholder', "Confirmer Email");
		$('input#mdp').attr('placeholder', "Mot de passe");
		$('input#mdp2').attr('placeholder', "resaisir passe");
		$('input#planete').attr('placeholder', "Nom planète");
		$('select#titre').attr('placeholder', "Votre titre");
		$('input#parrain').attr('placeholder', "Parrain (facultatif)");
		$('img#humain').attr('src', "static/img/accueil/humain_150.jpg");
		$('img#valharien').attr('src', "static/img/accueil/valharien_150.jpg");
		$('img#orak').attr('src', "static/img/accueil/orak_150.jpg");
		$('img#droid').attr('src', "static/img/accueil/droid_150.jpg");
	};
});





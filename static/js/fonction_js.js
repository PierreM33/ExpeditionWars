function allselect_checkboxes(form)
{
	if(!$('input:checkbox').attr('checked'))
		$('input:checkbox').attr('checked', true);
	else
		$('input:checkbox').attr('checked', false);
}

function compteARebours(a,b){
	if(0<a)
	{
	    var c=a-1,d=Math.floor(c/86400), /* 86400 = 24Heures / math.floor = arrondir*/
	    e,
	    f=Math.floor(a%86400/3600);
		e=a%3600;
		var g=Math.floor(e/60);
		e=Math.floor(e%60);
		d=0<d?d+"j ":"";
		f=0<f?f+"h ":"";
		g=0<g?g+"m ":"";
		e=0<e?e+"s ":"";
		$("#rebours_"+b).html('<div class="load"></div>'+d+f+g+e);
		setTimeout("compteARebours("+c+",'"+b+"')",1E3);
	}
	else {
		$("#rebours_"+b).html("Termin\u00e9!");
		location.reload(true);
	}
}

$(document).ready(function(){
	
	// Script pour fermer les messages d'error au bout d'un petit temps
	if($('p.green').css({'display' : 'block'})){
		setInterval(function(){ 
			$('p.green').hide(200); 
		}, 5000);
	}
	else {
		$('p.green').css({'display':'none'});
	}
	if($('p.red').css({'display' : 'block'})){
		setInterval(function(){ 
			$('p.red').hide(200); 
		}, 5000);
	}
	else {
		$('p.red').css({'display':'none'});
	}
	
	// Script pour afficher les options du select des races dans technologie / caserne etc avec effet de slide.
	$('.select').click(function(){
       $('.option').slideToggle(); 
    });
	
	// Script pour cacher le menu option du select si on enlève la souris de ce dernier
	$('.option').mouseleave(function(){
		$(this).slideUp();
	});
	
	// Script fermeture de fenêtre pour lire le message
	$('button.close').click(function(){
		window.location.href='messagerie.php';
	});
});


//FONCTION AFFICHAGE ( UTILISER DIRECTEMENT DES LES PAGES FACTIONS / MINES )

function toggle_div(bouton, id) { // On déclare la fonction toggle_div qui prend en param le bouton et un id
  var div = document.getElementById(id); // On récupère le div ciblé grâce à l'id
  if(div.style.display=="none") { // Si le div est masqué...
    div.style.display = "block"; // ... on l'affiche...
 // ... et on change le contenu du bouton.
  } else { // S'il est visible...
    div.style.display = "none"; // ... on le masque...
 // ... et on change le contenu du bouton.
  }
}

// On génère un refresh du header pour les ressources
// function loop()
// {
	// var redirect = '/game/header.php';
	// var cl1 = $('div.cl1');
	// var cl2 = $('div.cl2');
	// var cl3 = $('div.cl3');
	// var cl4 = $('div.cl4');
	// var cr1 = $('div.cr1');
	// var cr2 = $('div.cr2');
	// var cr3 = $('div.cr3');
	// var cr4 = $('div.cr4');
	
	// $.get('/include/production.php', function(){
		// window.location.href=redirect;
	// }, 'json');
// }

// var refresh = setInterval(function(){ loop() }, 10000)

/*
// - CLIGNOTANT EN FONDU
//<div  id="LblClignotant"><b><font style=" color:#F9C367; font-size:20px; text-shadow: black 0.2em 0.1em 0.2em"><?php echo htmlentities($in['texte'])?></font></b></div>
//<script type="text/javascript">
var signe = -1;
var clignotementFading = function(){
var obj = document.getElementById('LblClignotant');
if (obj.style.opacity >= 0.96){
signe = -1;
}
if (obj.style.opacity <= 0.04){
signe = 1;
}
obj.style.opacity = (obj.style.opacity * 1) + (signe * 0.04);
};

// mise en place de l appel de la fonction toutes les 0.085 secondes
// Pour arrêter le clignotement : clearInterval(periode);
periode = setInterval(clignotementFading, 105 );
//</script>*/
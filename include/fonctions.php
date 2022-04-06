<?php


/* 
 * (bool) Si l'utilisateur est connecté
 */
function isConnected()
{
	return (bool)(isset($_SESSION['id']) && !empty($_SESSION['id']) && is_numeric($_SESSION['id']));
}

function path($game = true)
{
	return ($game) ? '/game/' : '/';
}

function pathView()
{
	return (isConnected()) ? path(false) . 'game/' : path(false);
}

function pathSta()
{
	return path(false) . 'portail/';
}

function pathCss()
{
	return path(false) . 'static/css/';
}

function pathJs()
{
	return path(false) . 'static/js/';
}

function pathImg()
{
	return path(false) . 'static/img/';
}

function pathPhp()
{
	return path(false) . 'php/';
}

//convertion seconde en jour/heure/minute
function convertTime($val){
 $j=floor($val/86400);
 $r=$val%86400;
 $h=floor($r/3600);
 $reste=$r%3600;
 $m=floor($reste/60);
 $s=$reste%60;
 
 $jour=($j>0)?$j.'j ':'';
 $heure=($h>0)?$h.'h ':'';
 $minute=($m>0)?$m.'m ':'';
 $seconde=($s>0)?$s.'s ':'';

 $timeFormat=$jour.$heure.$minute.$seconde;
 return $timeFormat;
}



?>
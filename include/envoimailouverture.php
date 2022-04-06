
<?php
@ini_set('display_errors', 'on');

require_once '../../include/connexion_bdd.php';






$reqmail = $bdd->prepare("SELECT * FROM membre"); 
$reqmail->execute(array());  
while($mailexiste=$reqmail->fetch())
{
	
	$mail = $mailexiste['mail'];

// $mail = "eaglexiii@hotmail.fr";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// Expéditeur
$from = "Expedition-wars <noreply@expedition-wars.fr>";
$headers .= "From : " . $from . "\n";
// Adresse de retour en cas de non réception du mail
$headers .= "Return-path : " . $from . "\n";
// On modifie l'adresse de réponse du mail
$headers .= "Reply-to : " . $from . "\n";

$searchReplace = array('#titre_mail#' => 'Ouverture Expedition-wars 11.02.2021 à 19h00 ',
'#texte_mail#' => "<br /> <br />EXPEDITION WARS ouvre à nouveau ses portes, après une longue hésitation sur la date, je vous informe que le jeu ouvrira ses portes le 11 Février 2021 à 19h00.<br /><br /><br /><br />Accédez au jeu en passant par l'adresse suivante:<br /><a class=\"bt\" href=\"https://expedition-wars.fr/\">Accéder à ma base</a><br /><br />");

$search = array_keys($searchReplace);
$replace = array_values($searchReplace);

$templateFile = file_get_contents('../../include/mail.template.php');
$msg_html = str_replace($search, $replace, $templateFile);

mail($mail, 'Inscription sur Expedition-wars.fr', $msg_html, $headers);
}


?>
<?php

// PAGE QUI RECUPERE LE NUMERO DU COMBAT POUR ENVOYER LE BON RAPPORT
header('Location: '.pathView().'./flotte/rapport_combat.php?numero=' . $_GET['numero']);
//echo '<script>document.location.href="' .pathView(). 'flotte/rapport_combat.php?numero=' . $_GET['numero'] . '"</script>';

/*
monfichierphp?numero=12312312132
$_GET['numero'] @malibx(édité)
*/

?>


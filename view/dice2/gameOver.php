<?php

namespace Anax\View;

?>

<p>Matchen är över.</p>
<?php
$winner = "";
if ($_SESSION["game"]->getP2() > $_SESSION["game"]->getP1()) {
    $winner = "Datorn vann";
} else {
    $winner = "Spelaren";
}
?>
<p><?=$winner?> har vunnit matchen</p>

<a class="restart-button btn" href="init">Starta om</a>

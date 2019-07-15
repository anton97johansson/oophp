<?php
namespace Anax\View;

?>

<h4>Player 1 score: <?=$p1Score?></h4>
<h4>Computers score: <?=$p2Score?></h4>
<p>Latest throw: <?=implode(",", $throw)?></p>
<p>Hand: <?=$hand?></p>
<a class="save-button btn" href="save">Spara</a>
<a class="again-button btn" href="again">Kasta igen</a>
<a class="restart-button btn" href="init">Starta om</a>

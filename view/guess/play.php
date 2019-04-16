<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
?>
<h1>Gissa på ett tal mellan 1-100, du har <?=$tries?> försök kvar</h1>

<!-- <form method="post" action="index_process.php"> -->
<form method="post">
<input type="text" name="guess" required autocomplete="off">
<input type="hidden" name="number" value="<?=$number?>" >
<input type="hidden" name="tries" value="<?=$tries?>">
<?php if ($tries == "vunnit, så inga mer") : ?>
    <input type="submit" name="doGuess" disabled value="Gör gissning">

<?php else : ?>
    <input type="submit" name="doGuess" value="Gör gissning">
<?php endif; ?>
<a href="init">Börja om</a>
<a href="cheat">Fuska</a>
</form>

<p><b><?=$res?></b></p>

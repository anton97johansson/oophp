<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<h1>Gissa på ett tal mellan 1-100, du har <?=$tries?> försök kvar</h1>

<form method="post" action="index_process.php">
<input type="text" name="guess" required autocomplete="off">
<input type="hidden" name="number" value="<?=$number?>" >
<input type="hidden" name="tries" value="<?=$tries?>">
<?php if ($tries == "vunnit, så inga mer") : ?>
    <input type="submit" name="doGuess" disabled value="Gör gissning">

<?php else : ?>
    <input type="submit" name="doGuess" value="Gör gissning">
<?php endif; ?>
<input type="submit" name="doInit" value="Börja om" formnovalidate>
<?php if ($tries == "vunnit, så inga mer") : ?>
    <input type="submit" name="doCheat" disabled value="Fuska" formnovalidate>

<?php else : ?>
    <input type="submit" name="doCheat" value="Fuska" formnovalidate>
<?php endif; ?>
</form>

<p><b><?= $res?></b></p>

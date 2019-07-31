<?php
namespace Anax\View;

// include ("../../src/function.php");
// if (!$res) {
//     return;
// }
?>

<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $movie->title ?>" required/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $movie->year ?>" required/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $movie->image ?>" required/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="submit" name="doDelete" value="Delete">
    </p>
    <p>
        <a href="../movie">Show all</a>
    </p>
    </fieldset>
</form>

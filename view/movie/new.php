<?php
namespace Anax\View;

// include ("../../src/function.php");
// if (!$res) {
//     return;
// }
?>

<form method="post">
    <fieldset>
    <legend>New</legend>
    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle"  required/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear"  required/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" required/>
        </label>
    </p>

    <p>
        <input type="submit" name="doNew" value="Create new">
    </p>
    <p>
        <a href="../movie">Show all</a>
    </p>
    </fieldset>
</form>

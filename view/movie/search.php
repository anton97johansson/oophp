<?php
namespace Anax\View;

// include ("../../src/function.php");
// if (!$res) {
//     return;
// }
?>

<form method="get">
    <fieldset>
    <legend>Search</legend>
    <!-- <input type="hidden" name="movie" value="search"> -->
    <p>
        <label>Title or Year:
            <input type="search" name="searchMovie" value="<?= esc($searchMovie) ?>" required/>
        </label>

    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    <p><a href="../movie">Show all</a></p>
    </fieldset>
</form>
<?php
if ($res) : ?>
    <table>
        <tr class="first">
            <th>Rad</th>
            <th>Id</th>
            <th>Bild</th>
            <th>Titel</th>
            <th>År</th>
        </tr>
    <?php $id = -1; foreach ($res as $row) :
        $id++; ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $row->id ?></td>
            <td><img class="thumb" src="<?= "../../htdocs/".$row->image ?>"></td>
            <td><?= $row->title ?></td>
            <td><?= $row->year ?></td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif;

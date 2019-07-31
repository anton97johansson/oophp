<?php
namespace Anax\View;

if (!$res) {
    return;
}

?>
<p><a href="movie/search">Sök film</a> | <a href="movie/new">Lägg till film</a></p>
<p class="how">Här är alla filmer, tryck på länken 'Sök film' för att söka filmer.<br><br> Tryck 'Lägg till film' för att lägga till film.<br><br> Tryck på 'Ändra' som finns vid varje film för att ändra något med dem. (info eller ta bort dem)
<table>
    <tr class="first" "index">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
        <th></th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
        <td><a href="../htdocs/movie/edit?movieId=<?=$row->id?>">Ändra</a></td>
    </tr>
<?php endforeach; ?>
</table>

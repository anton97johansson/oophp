<?php
namespace Anax\View;

if (!$res) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td>
            <form action="../blogg/page">
                <!-- <fieldset> -->
                <p> <input type="text" class="link" hidden name="page" value=<?= $row->path ?>>
                    <input type="submit" class="link"  value=<?= $row->title ?>>
                </p>
                <!-- </fieldset> -->
            </form>
        </td>
        <td><?= $row->type ?></td>
        <td><?= $row->status ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>


<!-- <td><a href=../htdocs/blogg/<?= $row->path ?>><?= $row->title ?></a></td> -->

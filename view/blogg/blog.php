<?php
namespace Anax\View;

if (!$res) {
    return;
}
?>

<article>

<?php foreach ($res as $row) : ?>
<section>
    <header>
        <h1>
            <form action="../blogg/blogpost">
                <!-- <fieldset> -->
                    <input type="text" class="link" name="post" value="<?= esc($row->slug) ?>" hidden>
                    <input type="submit" class="link" value="<?= esc($row->title) ?>">

                <!-- </fieldset> -->
            </form>
        </h1>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?= $filter->parse($row->data, $row->filter); ?> 
</section>
<?php endforeach; ?>

</article>



<!--
<h1><a href="?route=blog/<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h1> -->

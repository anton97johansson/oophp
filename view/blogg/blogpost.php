<?php
namespace Anax\View;

?>

<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Published: <time datetime="<?= esc($content->published_iso8601) ?>" pubdate><?= esc($content->published) ?></time></i></p>
    </header>
    <?= $filter->parse($content->data, $content->filter); ?>
</article>

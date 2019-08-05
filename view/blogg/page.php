<?php
namespace Anax\View;

?>

<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= esc($content->modified_iso8601) ?>" pubdate><?= esc($content->modified) ?></time></i></p>
    </header>
    <?= $filter->parse($content->data, $content->filter); ?>
</article>

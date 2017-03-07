<?php foreach ($pages as $page): ?>
    <?php if ($page == $current_page): ?>
        . <b><?= $page; ?></b> .
    <?php else: ?>
        . <a href="index.php?main=<?= $page; ?>"><?= $page; ?></a> .
    <?php endif; ?>
<?php endforeach; ?>
<?php foreach ($articles as $article): ?>
    <p>
        <a href="index.php?view_article=<?= $article['id_article']; ?>"><?= $article['title']; ?></a><br>
        <?= $article['content']; ?>
    </p>
<?php endforeach; ?>
<a href='index.php?new_article'>Добавить статью</a>
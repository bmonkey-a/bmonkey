<?php foreach ($pages as $page): ?>
    <?php if ($page == $current_page): ?>
        . <b><?= $page; ?></b> .
    <?php else: ?>
        . <a href="index.php?moderate=<?= $page; ?>"><?= $page; ?></a> .
    <?php endif; ?>
<?php endforeach; ?>
<?php foreach ($articles as $article): ?>
    <p>
        <a href="index.php?delete_article=<?= $article['id_article'] ?>">удалить</a> |
        <a href="index.php?edit_article=<?= $article['id_article'] ?>"><?= $article['title']; ?></a><br>
        <?= $article['content']; ?>
    </p>
<?php endforeach; ?>
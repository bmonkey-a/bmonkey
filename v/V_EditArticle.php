<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
    Заголовок новости:<br/>
    <input type="text" name="title" value="<?= $article['title']; ?>"/><br/>
    Текст новости:<br/>
    <textarea name="content" cols="50" rows="5"><?= $article['content']; ?></textarea><br/>
    <input type="hidden" name="id_article" value="<?= $article['id_article']; ?>"/><br/>
    <input type="submit" value="Редактировать!"/>
</form>

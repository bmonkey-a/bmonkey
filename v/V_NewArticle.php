<form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
    Заголовок новости:<br/>
    <input type="text" name="title" value="<?= $title; ?>"/><br/>
    Текст новости:<br/>
    <textarea name="content" cols="50" rows="5"><?= $content; ?></textarea><br/>
    <input type="submit" value="Добавить!"/>
</form>
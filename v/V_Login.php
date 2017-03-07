<h1>Авторизация</h1>
<a href="index.php">Главная</a>
<form method="post">
    E-mail: <input type="text" name="login" value="<?= $login; ?>" /><br/>
    Пароль: <input type="password" name="password" /><br/>
    <input type="checkbox" name="remember" <?= $remember; ?>/> Запомить меня<br/>
    <input type="submit" />
</form>
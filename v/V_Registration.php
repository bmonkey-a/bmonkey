<h1><?= $title; ?></h1>
<form action="" method="post">
    <label for="name">Ваше имя</label>
    <input type="text" name="name" id="name" value="<?= $name;?>" /><br />
    <label for="email">Электронная почта</label>
    <input type="text" name="email" id="email" value="<?= $email;?>" /><br />
    <label for="password">Придумайте пароль</label>
    <input type="password" name="password" id="password" /><br />
    <p>Пароль должен быть от 6 до 16 символов, содержать цифры и заглавные буквы и не должен совпадать с именем и эл.почтой</p><br />
    <button type="submit">Зарегестрироваться</button>
</form>
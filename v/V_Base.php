<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title; ?></title>
</head>
<body>
<h1><? $title; ?></h1>
<nav>
    <?php foreach ($navigation as $item): ?>
    <?= "| " . $item . " |"; ?>
    <?php endforeach; ?>
    <a href="index.php">Главная</a> | <a href="index.php?moderate" >Модерка</a>
</nav><hr>
<?php if(!empty($error_message)): ?>
    <h3><?= $error_message; ?></h3><hr>
<?php endif; ?>
<?= $content; ?>
</body>
</html>
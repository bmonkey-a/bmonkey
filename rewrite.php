<?php

//$info_ = explode('/', $_SERVER['PATH_INFO']); // для index.php/$0				
$info_ = explode('/', $_GET['q']); // для index.php?q=$0		
$info = array();

foreach ($info_ as $v) {
    if ($v != '')
        $info[] = $v;
}

$n = count($info);

// Базовый URL.
$baseURL = '/url';

// Кодировка.
header('Content-type: text/html; charset=windows-1251');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title>URL Rewrite</title>
    <meta content="text/html; charset=Windows-1251" http-equiv="content-type">
    <link rel="stylesheet" type="text/css" media="screen" href="theme/style.css"/>
</head>
<body>
<a href="<?= $baseURL ?>/articles/123">articles/123</a>
<br/>
<a href="<?= $baseURL ?>/articles/58/edit">articles/58/edit</a>
<br/>
<br/>

<ul>
    <? foreach ($info as $v): ?>
        <li><?= $v ?></li>
    <? endforeach ?>
</ul>
</body>
</html>

<?php
include "M_SQLite3.class.php";
include "M_Articles.class.php";

$ma = new M_Articles();
$aa = $ma->getAll();

print_r($aa);
/*$a = $sqlite->getAll();
print_r($a);
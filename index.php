<?php
spl_autoload_register(function ($class) {
    $class_type = explode("_", $class);
    $dir = "";
    switch ($class_type[0]) {
        case 'M':
            $dir = "m/";
            break;
        case 'C':
            $dir = "c/";
            break;
    }
    $path = $dir . $class . '.class.php';
    if (!file_exists($path))
        die("Попытка вызвать несуществующий класс");

    include_once($path);
});

if(empty($_REQUEST)){
    header("Location: index.php?main");
    exit;
}

$action = array_shift(array_keys($_REQUEST));

switch ($action) {
    case "login":
        $controller = new C_Login();
        break;
    case "moderate":
        $controller = new C_ModerateArticle();
        break;
    case "edit_article":
        $controller = new C_EditArticle();
        break;
    case "view_article":
        $controller = new C_ViewArticle();
        break;
    case "new_article":
        $controller = new C_NewArticle();
        break;
    case "delete_article":
        $controller = new C_DeleteArticle();
        break;
    default:
        $controller = new C_Main();
}
session_start();
$controller->Execute();


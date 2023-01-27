<?php
include_once("./vendor/autoload.php");

$config = include ('./.env.php');

if (isset($_GET['export'])){
    $page = new \Extrovert\TestTask1\Pages\ExportAllSmartProcessItems($config['auth'], $config['api'], $config['doc']);
}else{
    $page = new \Extrovert\TestTask1\Pages\Main($config['auth']);
}

$page->view();

?>
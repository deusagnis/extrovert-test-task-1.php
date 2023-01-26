<?php
include_once("./vendor/autoload.php");

$config = include ('./.env.php');

$page = new \Extrovert\TestTask1\Pages\Main($config);

$page->view();

?>
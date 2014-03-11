<?php
$lang = $_GET['l'];
session_start();
$_SESSION['lang'] = $lang;
unset($lang);
header('Location: '.$_SERVER['HTTP_REFERER']);
?>
<?php
require_once"../model/read.php";
session_start();
$loja = isset($_POST['loja'])?$_POST['loja']:'';

$read = new \Admin\Read();
$read->getNewLoja($loja);
?>
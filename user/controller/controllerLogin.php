<?php
require_once"../../model/read.php";
$email = isset($_POST['email'])?$_POST['email']:'';
$senha = isset($_POST['senha'])?$_POST['senha']:'';
$read = new \User\Read();
$read->getLoginUser($email,$senha);
?>
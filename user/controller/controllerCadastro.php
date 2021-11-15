<?php
require_once"../../root/model/create.php";
$nome = isset($_POST['nome'])?$_POST['nome']:'';
$email = isset($_POST['email'])?$_POST['email']:'';
$senha = isset($_POST['senha'])?$_POST['senha']:'';
$celular = isset($_POST['celular'])?$_POST['celular']:'';
$link = "http://www.primordium.com.br/user";
$create = new \Root\Create();
$create->insertTableUsuario($nome,$email,$senha,$celular,$link);
?>
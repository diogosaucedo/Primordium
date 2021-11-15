<?php
ob_start();
$endereco = isset($_POST['endereco'])?$_POST['endereco']:'';
$bairro = isset($_POST['bairro'])?$_POST['bairro']:'';
$complemento = isset($_POST['complemento'])?$_POST['complemento']:'';
$numero = isset($_POST['numero'])?$_POST['numero']:'';
$extras = isset($_POST['extras'])?$_POST['extras']:'';
require_once"../model/create.php";
$create = new \User\Create();
$create->setPedidoLoja($endereco,$bairro,$complemento,$numero,$extras);
ob_end_flush();
?>
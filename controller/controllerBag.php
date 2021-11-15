<?php
ob_start();
$nome = isset($_POST['nome'])?$_POST['nome']:'';
$quantidade = isset($_POST['quantidade'])?$_POST['quantidade']:'';
$idProduto = isset($_POST['idProduto'])?$_POST['idProduto']:'';
$idLoja = isset($_POST['idLoja'])?$_POST['idLoja']:'';
$preco = isset($_POST['preco'])?$_POST['preco']:'';
$idCategoria = isset($_POST['idCategoria'])?$_POST['idCategoria']:'';
$produto = array($nome,$quantidade,$idProduto,$idLoja,$preco,$idCategoria);

require_once"../model/create.php";
$create = new \User\Create();
if($create->setCarrinho($produto)){
    header("location:http://www.primordium.com.br/view/carrinho.php");
}
ob_end_flush();
?>
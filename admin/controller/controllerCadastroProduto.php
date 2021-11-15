<?php
require_once"../model/create.php";
session_start();
$post = isset($_POST['post'])?$_POST['post']:'';
$categoria = isset($_POST['categoria'])?$_POST['categoria']:'';
$nome = isset($_POST['nome'])?$_POST['nome']:'';
$img1 = isset($_FILES['img-1'])?$_FILES['img-1']:'';
$img2 = isset($_FILES['img-2'])?$_FILES['img-2']:'';
$img3 = isset($_FILES['img-3'])?$_FILES['img-3']:'';
$descricao = isset($_POST['descricao'])?$_POST['descricao']:'';
$identificador = isset($_POST['identificador'])?$_POST['identificador']:'';
$peso = isset($_POST['peso'])?$_POST['peso']:'';
$preco = isset($_POST['preco'])?$_POST['preco']:'';
$quantidade = isset($_POST['quantidade'])?$_POST['quantidade']:'';
$maximo = isset($_POST['maximo'])?$_POST['maximo']:'';
if($post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
    $create = new \Admin\Create();
    $create->insertTableProdutos($_SESSION['idAtual'], $categoria, $nome, $img1, $img2, $img3, $descricao, $identificador, $peso,$preco,$quantidade,$maximo);
}else{
    header("Location:../");
}
?>
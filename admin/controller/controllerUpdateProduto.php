<?php
require_once"../model/update.php";
require_once"../model/delete.php";
session_start();
$post = isset($_POST['post'])?$_POST['post']:'';
$id = isset($_POST['id'])?$_POST['id']:'';
$idCategoria = isset($_POST['categoria'])?$_POST['categoria']:'';
$nome = isset($_POST['nome'])?$_POST['nome']:'';
$img1 = isset($_FILES['img1'])?$_FILES['img1']:'';
$img2 = isset($_FILES['img2'])?$_FILES['img2']:'';
$img3 = isset($_FILES['img3'])?$_FILES['img3']:'';
$descricao = isset($_POST['descricao'])?$_POST['descricao']:'';
$identificador = isset($_POST['identificador'])?$_POST['identificador']:'';
$peso = isset($_POST['peso'])?$_POST['peso']:'';
$preco = isset($_POST['preco'])?$_POST['preco']:'';
$quantidade = isset($_POST['quantidade'])?$_POST['quantidade']:'';
$delete = isset($_POST['delete'])?$_POST['delete']:"";
$maximo = isset($_POST['maximo'])?$_POST['maximo']:'';
if($post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
    if (!empty($delete)) {
        $del = new \Admin\Delete();
        $del->deleteProdutos($_SESSION['idAtual'], $id);
    } else {
        $update = new \Admin\Update();
        $update->updateProduto($_SESSION['idAtual'],$id,$idCategoria,$nome,$img1,$img2,$img3,$descricao,$identificador,$peso,$preco,$quantidade,$maximo);
    }
}else{
    header("location:../");
}
?>
<?php
require_once"../model/update.php";
require_once"../model/delete.php";
session_start();
$post = isset($_POST['post'])?$_POST['post']:'';
$id = isset($_POST['id'])?$_POST['id']:'';
$nome = isset($_POST['nome'])?$_POST['nome']:'';
$delete = isset($_POST['delete'])?$_POST['delete']:'';
if($post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
    if (!empty($delete)) {
        $delete = new \Admin\Delete();
        $delete->deleteCategoria($_SESSION['idAtual'], $id);
    } else {
        $update = new \Admin\Update();
        $update->updateCategoria($_SESSION['idAtual'], $id, $nome);
    }
}else{
    header("location:../");
}
?>
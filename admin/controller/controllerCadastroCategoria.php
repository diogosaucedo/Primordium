<?php
session_start();
require_once"../model/create.php";

$nome = isset($_POST['nome'])?$_POST['nome']:'';
$post = isset($_POST['post'])?$_POST['post']:'';
if($post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
    /**
     * A variavel $nome n�o deve ser vazia
     */
    if(!empty($nome)){
        $insert = new \Admin\Create();
        $insert->insertTableCategoriaLoja($_SESSION['idAtual'],$nome);
    }
    /**
     * caso a variavel seja vazia, o usu�rio sera redirecionado para o index.php
     */
    else{
        header("Location:../");
    }
}
/**
 * caso os valores criptografados n�o sejam id�nticos, a postagem e inv�lida(tentativa de spoofing ou similar). Sendo assim o usu�rio e redirecionado para a index.php
 */
else{
    header("Location:../");
}
?>
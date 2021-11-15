<?php
/**
 * Incluindo arquivo que contém a classe create.
 */
require_once"../model/create.php";
/**
 * Esta variável recebe por METHOD POST o nome da categoria a ser inserida no sistema.
 * @access public
 * @name $nome
 */
$nome = isset($_POST['nome'])?$_POST['nome']:'';
/**
 * Esta variável recebe por METHOD POST um token, com dados criptografados. Estes dados são criptografados no momento em
 * que usuário acessa o formulario de cadastro de categoria, sendo assim possivel validar a origem dos dados e evitar
 * Spoofing de formularios.
 * @access public
 * @name $post
 */
$post = isset($_POST['post'])?$_POST['post']:'';
/**
 * O conteúdo da variavel $post, que são dados criptografados, deve ser idêntico a nova criptografia. Se for idêntico, significa
 * que o usuario que está a acessar este controlador, acessou anteriomente o formulario de cadastro, sendo assim a postagem é valida.
 */
if($post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
    /**
     * A variavel $nome não deve ser vazia
     */
    if(!empty($nome)){
        $insert = new \Root\Create();
        $insert->insertTableCategoria($nome);
    }
    /**
     * caso a variavel seja vazia, o usuário sera redirecionado para o index.php
     */
    else{
        header("Location:../");
    }
}
/**
 * caso os valores criptografados não sejam idênticos, a postagem e inválida(tentativa de spoofing ou similar). Sendo assim o usuário e redirecionado para a index.php
 */
else{
    header("Location:../");
}
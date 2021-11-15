<?php
/**
 * Incluindo arquivo que contém a classe read.
 */
require_once"../model/read.php";
/**
 * Esta variável recebe por METHOD POST o email do administrador para poder realizar o login.
 * @access public
 * @name $email
 */
$email = isset($_POST['email'])?$_POST['email']:'';
/**
 * Esta variável recebe por METHOD POST a senha do administrador para poder realizar o login.
 * @access public
 * @name $senha
 */
$senha = isset($_POST['senha'])?$_POST['senha']:'';
/**
 * Esta variável recebe por METHOD POST um token, com dados criptografados. Estes dados são criptografados no momento em
 * que usuário acessa o formulario de login de administradores, sendo assim possivel validar a origem dos dados e evitar
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
$read = new \Root\Read();
$read->getLoginAdmin($email,$senha);
}
/**
 * caso os valores criptografados não sejam idênticos, a postagem e inválida(tentativa de spoofing ou similar). Sendo assim o usuário e redirecionado para a index.php
 */
else{
    header("Location:../");
}
?>
<?php
/**
 * Incluindo arquivo que contém a classe create.
 */
require_once"../model/create.php";
/**
 * Esta variável recebe por METHOD POST o nome do cliente a ser inserido no sistema.
 * @access public
 * @name $nome
 */
$nome = isset($_POST["nome"])?$_POST["nome"]:'';
/**
 * Esta variável recebe por METHOD POST o email do cliente a ser inserido no sistema.
 * @access public
 * @name $email
 */
$email = isset($_POST["email"])?$_POST["email"]:'';
/**
 * Esta variável recebe por METHOD POST a senha do cliente a ser inserido no sistema.
 * @access public
 * @name $senha
 */
$senha = isset($_POST["senha"])?$_POST["senha"]:'';
/**
 * Esta variável recebe por METHOD POST o numero de telefone celular do cliente a ser inserido no sistema.
 * @access public
 * @name $celular
 */
$celular = isset($_POST["celular"])?$_POST["celular"]:'';
/**
 * Esta variável recebe por METHOD POST o CNPJ/CPF do cliente a ser inserido no sistema.
 * @access public
 * @name $cpf
 */
$cpf = isset($_POST["cpf"])?$_POST["cpf"]:'';
/**
 * Esta variável recebe por METHOD POST um token, com dados criptografados. Estes dados são criptografados no momento em
 * que usuário acessa o formulario de cadastro de cliente, sendo assim possivel validar a origem dos dados e evitar
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
     * As variaveis $nome, $email, $senha, $celular e $cpf não podem estar vazias.
     */
    if(!empty($nome) && !empty($email) && !empty($senha) && !empty($celular) && !empty($cpf)){
        $create = new \Root\Create();
        $create->insertTableClientes($nome,$email,$senha,$celular,$cpf);
    }
    /**
     * caso uma ou mais variáveis estejam vazias, o usuario será redirecionado a index.php
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

?>
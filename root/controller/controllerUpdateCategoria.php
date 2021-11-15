<?php
/**
 * Incluindo arquivos que contém as classes update e delete.
 */
require_once"../model/update.php";
require_once"../model/delete.php";
/**
 * Esta variável recebe por METHOD POST o id da categoria para que possa ser realizado a exclusão ou atualização dos dados.
 * @access public
 * @name $id
 */
$id = isset($_POST['id'])?$_POST['id']:'';
/**
 * Esta variável recebe por METHOD POST o nome da categoria para que a mesma possa ser atualizada.
 * @access public
 * @name $nome
 */
$nome = isset($_POST['nome'])?$_POST['nome']:'';
/**
 * Esta variável recebe por METHOD POST o valor 'excluir', caso esse valor venha do formulario de atualização, os dados não serão
 * atualizados, e sim excluidos do banco de dados.
 * @access public
 * @name $excluir
 */
$excluir = isset($_POST['excluir'])?$_POST['excluir']:'';
/**
 * Esta variável recebe por METHOD POST um token, com dados criptografados. Estes dados são criptografados no momento em
 * que usuário acessa o formulario de update de categoria, sendo assim possivel validar a origem dos dados e evitar
 * Spoofing de formularios.
 * @access public
 * @name $post
 */
$post = isset($_POST['post'])?$_POST['post']:'';
/**
 * O conteúdo da variavel $post, que são dados criptografados, deve ser idêntico a nova criptografia. Se for idêntico, significa
 * que o usuario que está a acessar este controlador, acessou anteriomente o formulario de cadastro, sendo assim a postagem é valida.
 */
if($post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
    /**
     * se o conteudo da variavel $excluir for igual a 'excluir', sera passado o $id do administrador para o sistema realizar a exclusão
     */
    if ($excluir === 'excluir') {
        $drop = new \Root\Delete();
        $drop->deleteTableCategoria($id);

    }
    /**
     * caso a variavel $excluir tenha recebido nenhum valor, isso significa que sera realizado uma atualização  de dados ao inves
     * de exclusão
     */
    else {
        $update = new \Root\Update();
        $update->updateTableCategoria($id, $nome);
    }
}
/**
 * caso os valores criptografados não sejam idênticos, a postagem e inválida(tentativa de spoofing ou similar). Sendo assim o usuário e redirecionado para a index.php
 */
else{
    header("Location:../");
}
?>
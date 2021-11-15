<?php
/**
 * Incluindo arquivos que contém as classes update e delete.
 */
require_once"../model/update.php";
require_once"../model/delete.php";
/**
 * Esta variável recebe por METHOD POST o id da loja para que possa ser realizada a exclusão ou atualização dos dados.
 * @access public
 * @name $id_loja
 */
$id_loja = isset($_POST['id_loja'])?$_POST['id_loja']:'';
/**
 * Esta variável recebe por METHOD POST o id da categoria, para que possa ser realizada a atualização da mesma.
 * @access public
 * @name $id_categoria
 */
$id_categoria = isset($_POST['categoria'])?$_POST['categoria']:'';
/**
 * Esta variável recebe por METHOD POST o id do dono, para que possa ser realizado a atualização do mesmo.
 * @access public
 * @name $id_categoria
 */
$id_dono = isset($_POST['dono'])?$_POST['dono']:'';
/**
 * Esta variável recebe por METHOD POST a razão social da loja, para que possa ser realizada a atualização da mesma.
 * @access public
 * @name $razao
 */
$razao = isset($_POST['razao'])?$_POST['razao']:'';
/**
 * Esta variável recebe por METHOD POST o nome fantasia da loja, para que possa ser realizada a atualização do mesmo.
 * @access public
 * @name $fantasia
 */
$fantasia = isset($_POST['fantasia'])?$_POST['fantasia']:'';
/**
 * Esta variável recebe por METHOD POST a incrição estadual da loja, para que possa ser realizada a atualização do mesmo.
 * @access public
 * @name $inscricao
 */
$inscricao = isset($_POST['inscricao'])?$_POST['inscricao']:'';
/**
 * Esta variável recebe por METHOD POST o valor 'isento', para que possa ser realizada a atualização do mesmo e indicar
 * que é isento de inscrição estadual.
 * @access public
 * @name $isento
 */
$isento = isset($_POST['isento'])?$_POST['isento']:'';
/**
 * Esta variável recebe por METHOD POST o valor 'optante', para que possa ser realizada a atualização do mesmo e indicar
 * que é optante pelo simples.
 * @access public
 * @name $optante
 */
$optante = isset($_POST['optante'])?$_POST['optante']:'';
/**
 * Esta variável recebe por METHOD POST o valor excluir, caso esse valor venha do formulario de atualização, os dados não serão
 * atualizados, e sim excluidos do banco de dados.
 * @access public
 * @name $excluir
 */
$excluir = isset($_POST['excluir'])?$_POST['excluir']:'';
/**
 * Esta variável recebe por METHOD POST um token, com dados criptografados. Estes dados são criptografados no momento em
 * que usuário acessa o formulario de update de lojas, sendo assim possivel validar a origem dos dados e evitar
 * Spoofing de formularios.
 * @access public
 * @name $post
 */
$post = isset($_POST['post'])?$_POST['post']:'';
/**
 * O conteúdo da variavel $post, que são dados criptografados, deve ser idêntico a nova criptografia. Se for idêntico, significa
 * que o usuario que está a acessar este controlador, acessou anteriomente o formulario de cadastro, sendo assim a postagem é valida.
 */
$status =  isset($_POST['status'])?$_POST['status']:'';
$inicio = isset($_POST['inicio'])?$_POST['inicio']:'';
$fim = isset($_POST['fim'])?$_POST['fim']:'';
if($post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
    /**
     * se o conteudo da variavel $excluir for igual a 'excluir', sera passado o $id do administrador para o sistema realizar a exclusão
     */
    if ($excluir === 'excluir') {
        $drop = new \Root\Delete();
        $drop->deleteTableLoja($id_loja);

    }
    /**
     * caso a variavel $excluir tenha recebido nenhum valor, isso significa que sera realizado uma atualização  de dados ao inves
     * de exclusão
     */
    else {
        $update = new \Root\Update();
        $update->updateTableLojas($id_loja, $id_categoria, $id_dono, $razao, $fantasia, $inscricao, $isento, $optante,$status,$inicio,$fim);
    }
}
/**
 * caso os valores criptografados não sejam idênticos, a postagem e inválida(tentativa de spoofing ou similar). Sendo assim o usuário e redirecionado para a index.php
 */
else{
    header("location:../");
}
?>
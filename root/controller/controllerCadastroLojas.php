<?php
/**
 * Incluindo arquivo que contém a classe create.
 */
require_once"../model/create.php";
/**
 * Esta variável recebe por METHOD POST o id do dono(cliente,sendo que o mesmo ja deve esta cadastrado no banco de dados)
 * para poder usar a foreign key, entre a tabela cliente e a tabela lojas
 * @access public
 * @name $id
 */
$id = isset($_POST['id'])?$_POST['id']:'';
/**
 * Esta variável recebe por METHOD POST o id da categoria a qual ira pertencer,sendo que ela sera usada como chave(foreign key)
 * que ligara a tabela lojas e a tabela categoria
 * @access public
 * @name $categoria
 */
$categoria = isset($_POST['categoria'])?$_POST['categoria']:'';
/**
 * Esta variável recebe por METHOD POST a razão social da loja a ser inserida no sistema.
 * @access public
 * @name $razao
 */
$razao = isset($_POST['razao'])?$_POST['razao']:'';
/**
 * Esta variável recebe por METHOD POST o nome fantasia da loja a ser inseridano sistema.
 * @access public
 * @name $fantasia
 */
$fantasia = isset($_POST['fantasia'])?$_POST['fantasia']:'';
/**
 * Esta variável recebe por METHOD POST a inscrição estadual da loja, caso ela possua uma.
 * @access public
 * @name $inscricao
 */
$inscricao = isset($_POST['inscricao'])?$_POST['inscricao']:'';
/**
 * Esta variável recebe por METHOD POST a informação se a loja e optante pelo simples, ou não.
 * @access public
 * @name $optante
 */
$optante = isset($_POST['optante'])?$_POST['optante']:'';
/**
 * Esta variável recebe por METHOD POST a informação se a loja e isenta de inscrição estadual, ou não.
 * @access public
 * @name $isento
 */
$isento = isset($_POST['isento'])?$_POST['isento']:'';
/**
 * Esta variável recebe por METHOD POST um token, com dados criptografados. Estes dados são criptografados no momento em
 * que usuário acessa o formulario de cadastro de lojas, sendo assim possivel validar a origem dos dados e evitar
 * Spoofing de formularios.
 * @access public
 * @name $post
 */
$post = isset($_POST['post'])?$_POST['post']:'';
/**
 * O conteúdo da variavel $post, que são dados criptografados, deve ser idêntico a nova criptografia. Se for idêntico, significa
 * que o usuario que está a acessar este controlador, acessou anteriomente o formulario de cadastro, sendo assim a postagem é valida.
 */
$status = isset($_POST['status'])?$_POST['status']:'';
$duracao = isset($_POST['duracao'])?$_POST['duracao']:'';
$inicio = isset($_POST['inicio'])?$_POST['inicio']:'';
$fim = isset($_POST['fim'])?$_POST['fim']:'';
if($post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
    /**
     * As variaveis $razao, $fantasia, e $id não podem estar vazias.
     */
    if(!empty($razao) && !empty($fantasia)&& !empty($id)){
        /**
         * Uma das variaveis deve estar preenchida
         */
        if(!empty($inscricao) || !empty($optante) || !empty($razao)){
            $insert = new \Root\Create();
            $insert->insertTableLojas($id,$categoria,$razao,$fantasia,$inscricao,$isento,$optante,$status,$duracao,$inicio,$fim);
        }
        /**
         * caso nenhuma das variaveis esteja preenchida, o usuario será redirecionado a index.php
         */
        else{
            header("Location:../");
        }
    }
    /**
     * caso uma ou mais variaveis estejam vazias, o usuario será redirecionado a index.php
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
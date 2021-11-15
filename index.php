<?php
namespace User;
require_once"model/read.php";
require_once"view/cabecalho.php";
ob_start();
$atual = isset($_GET['pg'])?$_GET['pg']:'';
$atual = explode("-",$atual);
if(empty($_GET['pg'])){

    $read = new Read();
    $read->readCategoria();

}
else{
    $read = new Read();
    if(!empty($atual[3]) && is_numeric($atual[3])){

    }
    else{
        if(!empty($atual[2]) && is_numeric($atual[2])){
            $read->readProdutos($atual[1],$atual[2]);
        }
        else{
            if(!empty($atual[1]) && is_numeric($atual[1])){
                $read->readCategoriaLoja($atual[1]);
            }
            else{
                $read->readLojas($atual[0]);
            }
        }
    }




}
require_once"view/rodape.php";
ob_end_flush();
?>
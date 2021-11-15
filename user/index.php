<?php
ob_start();
session_start();
require_once"view/cabecalho.php";
if(isset($_SESSION['user'])){
    if(!empty($_GET['pg'])) {
        $atual = explode("-",$_GET['pg']);
        switch ($atual[0]){
            case "update";
                require_once"view/formUpdate.php";
                break;
            case "pedidos";
                require_once"view/formPedidos.php";
        }
    }
    else{
        require_once"view/formUpdate.php";
    }
}
else{
    if(!empty($_GET['pg'])) {
        $atual = explode("-",$_GET['pg']);
        switch ($atual[0]){
            case "insert";
                require_once"view/formCadastro.php";
                break;
            case "login";
                require_once"view/formLogin.php";
                break;
        }
    }
    else{
        require_once"view/formLogin.php";
    }
}
ob_end_flush()
?>
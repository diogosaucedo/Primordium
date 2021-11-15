<?php
ob_start();
session_start();
?>
<html lang="pt-br">
<head>
    <title>Primordium</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
          rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
          rel="stylesheet" type="text/css">
</head>
<?php
require_once"view/cabecalho.php";
$atual = isset($_GET['pg'])?$_GET['pg']:'';
$atual = explode("_",$atual);
if(isset($_SESSION['login']) && $_SESSION['login'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
    if(file_exists("view/$atual[0].php")){
        require_once("view/$atual[0].php");
        if(isset($atual[1])){
            if($atual[1] == "inserir"){
                if($atual['0'] == "admin"){require_once"view/formCadastroAdmin.php";};
                if($atual['0'] == "clientes"){require_once"view/formCadastroCliente.php";};
                if($atual['0'] == "lojas"){require_once"view/formCadastroLojas.php";};
                if($atual['0'] == "usuarios"){require_once"view/formCadastroUsuario.php";};
                if($atual['0'] == "categoria"){require_once"view/formCadastroCategoria.php";};


            }
        }
    }
}
else{
    require_once"view/formLogin.php";
}
ob_end_flush();
?>

</html>
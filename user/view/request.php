<?php
header('Content-type: text/html; charset=ISO-8859-1');
session_start();
$post = isset($_POST['post'])?$_POST['post']:'';
$id = isset($_POST['id'])?$_POST['id']:'';
$pedido = isset($_POST['pedido'])?$_POST['pedido']:'';
$loja = isset($_POST['loja'])?$_POST['loja']:'';
$status = isset($_POST['status'])?$_POST['status']:'';
$andamento = '';
$pedido = base64_decode($pedido);
$pedido = str_replace('||',"<br>",$pedido);
switch($status){
    case 0;
        $andamento = "Solicitação realizada com sucesso!";
}
echo'
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
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
';
echo"

    <div class='section'>
        <div class='container'>
        <h1>Loja :$loja</h1>
        <h2>Status : $andamento</h2>
        <p>$pedido</p>
        </div>
     </div>
     <div class='section'>
        <div class='container'>
                <div class='col-md-8'>
                    <a href='http://www.primordium.com.br/user/pedidos-enviados'><button id='button1id' name='button1id' class='btn btn-success'>Voltar! <span class='glyphicon glyphicon-menu-left'></span></button></a>
                </div>
        </div>
     </div>   ";

?>
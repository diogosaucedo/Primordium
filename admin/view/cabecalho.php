<?php
header('Content-type: text/html; charset=ISO-8859-1');
session_start();
?>
<head>
    <html lang="pt-br">
    <head>
        <title><?php if($_SESSION['news'] > 0){echo "(".$_SESSION['news'].") ";} ?>Primordium</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css"
              rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css"
              rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href="css/pingendo.css" rel="stylesheet" type="text/css">
        <Meta http-equiv="refresh" content="120" />

    </head>
</head>

<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="change"><span>Primordium<?php if(isset($_SESSION['lAtual'])){echo" | ". $_SESSION['lAtual']; } ?></span></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                 <?php
                if(isset($_SESSION['check']) && $_SESSION['check'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])&& $_SESSION['edit']) {

                    echo '
                <li>
                    <a href="home">Home</a>
                </li>
                <li>
                    <a href="categoria">Categorias</a>
                </li>
                <li>
                    <a href="produto">Produtos</a>
                </li>
                <li>
                    <a href="venda-new">Vendas</a>
                </li>
                <li>
                    <a href="mensagem">Mensagens</a>
                </li>
                ';
                }
?>
            </ul>
        </div>
    </div>
</div>


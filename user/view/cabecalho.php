<?php
header('Content-type: text/html; charset=ISO-8859-1');

echo '
<html>
    <head>
        <meta charset = "utf-8" >
        <meta name = "viewport" content = "width=device-width, initial-scale=1" >
        <script type = "text/javascript" src = "http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" ></script >
        <script type = "text/javascript" src = "http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" ></script >
        <link href = "http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel = "stylesheet" type = "text/css" >
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href = "css/Untitled.css" rel = "stylesheet" type = "text/css" >
    </head >
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>
            <a class="navbar-brand" href="http://www.primordium.com.br"><span>Primordium</span></a>
</div>

<div class="collapse navbar-collapse" id="navbar-ex-collapse">
    <ul class="nav navbar-nav navbar-right">

';
if(isset($_SESSION['user'])){
    echo'       <li>
                    <a href="update">Perfil</a>
                </li>
                <li>
                    <a href="pedidos-enviados">Meus Pedidos</a>
                </li>
                <li>
                    <a href="http://www.primordium.com.br/view/carrinho.php"><span class="glyphicon glyphicon-shopping-cart"></span></a>
                </li>


    ';
}else{
    echo'
                <li>
                    <a href="login">Login</a>
                </li>
                <li>
                    <a href="insert">Cadastrar-se</a>
                </li>
    ';
}
echo'

    </ul>
</div>
</div>
</div>
</html>
';

?>
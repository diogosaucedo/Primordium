<?php
header ('Content-type: text/html; charset=UTF-8');
require_once"model/read.php";
$pg = isset($_GET['pg'])?$_GET['pg']:'';
session_start();
if(empty($pg)) {
    echo'
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <meta name = "viewport" content = "width=device-width, initial-scale=1" >
        <script type = "text/javascript" src = "http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" ></script >
        <script type = "text/javascript" src = "http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" ></script >
        <link href = "http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel = "stylesheet" type = "text/css" >
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href = "css/Untitled.css" rel = "stylesheet" type = "text/css" >
        <title>Primordium</title>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head >
    <body >
        <div class="cover" ><div class="navbar navbar-inverse" >
         <div class="container" >
         <div class="navbar-header" >
         <button type = "button" class="navbar-toggle" data-toggle = "collapse" data-target = ".navbar-collapse" >
         <span class="sr-only" > Toggle navigation </span >
         <span class="icon-bar" ></span >
         <span class="icon-bar" ></span >
         <span class="icon-bar" ></span >
         </button >
         <a class="navbar-brand" href="#" >
         <span > Primordium</span ></a>
         </a >
          </div >
          <div class="collapse navbar-collapse navbar-ex1-collapse" >
          <ul class="nav navbar-nav navbar-right" >
';
    $read = new \User\Read();
    $read->readMenuUser();

echo'
          </ul >
          </div >
          </div >
          </div >

        <div class="background-image-fixed cover-image" style = "background-image: url(imagem/11863042_845077325589155_1027112684_o.jpg);" ></div >
        <div class="container" >
            <div class="row" >
                <div class="col-md-12 text-center" >
                    <h1> Bem Vindo à Primordium!</h1>
                    <h3>Por um mundo mais acessível! </h3 >
                    <br >
                    <br >
                </div >
            </div >
        </div >
        </div >
    </body>
';
}
else {
    echo '
<html>
    <head>
        <meta charset = "ISO-8859-1" >
        <meta name = "viewport" content = "width=device-width, initial-scale=1" >
        <script type = "text/javascript" src = "http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js" ></script >
        <script type = "text/javascript" src = "http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" ></script >
        <link href = "http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel = "stylesheet" type = "text/css" >
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link href = "css/Untitled.css" rel = "stylesheet" type = "text/css" >
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head >
    <body>
<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>
            <a class="navbar-brand" href="user"><span>Primordium</span></a>
</div>

<div class="collapse navbar-collapse" id="navbar-ex-collapse">
    <ul class="nav navbar-nav navbar-right">

';
    $read = new \User\Read();
    $read->readCategoriaMenu();
echo'
                <li>
                    <a href="http://www.primordium.com.br/view/carrinho.php"><span class="glyphicon glyphicon-shopping-cart"></span></a>
                </li>
    </ul>
</div>
</div>
</div>
</body>
</html>
';
}

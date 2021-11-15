<?php
header('Content-type: text/html; charset=ISO-8859-1');
session_start();
$post = isset($_POST['post'])?$_POST['post']:'';
$id = isset($_POST['id'])?$_POST['id']:'';
$pedido = isset($_POST['pedido'])?$_POST['pedido']:'';
$nome = isset($_POST['nome'])?$_POST['nome']:'';
$celular = isset($_POST['celular'])?$_POST['celular']:'';
$endereco = isset($_POST['endereco'])?$_POST['endereco']:'';
$status = isset($_POST['status'])?$_POST['status']:'';
$change = isset($_POST['change'])?$_POST['change']:'';
if(!empty($_POST["change"])){
    require_once"../model/update.php";
    $update = new \Admin\Update();
    if($update->saleChange($_SESSION['idAtual'],$change)){
        header("Location: http://www.primordium.com.br/admin/venda-new");
    }
}
$andamento = '';
$pedido = base64_decode($pedido);
$pedido = str_replace('||',"<br>",$pedido);
$endereco = base64_decode($endereco);
$endereco = str_replace('||',"<br>",$endereco);
switch($status){
    case 0;
        $andamento = "Não antendido.";
        break;
    case 1;
        $andamento = "Atendido.";
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
        <h1>Nome :$nome</h1>
        <h2>Celular : $celular</h2>
        <h3>Status : $andamento</h3>
        <p>$endereco</p>
        <hr><hr>
        <p>$pedido</p>
        </div>
     </div>   ";
if($status == 0) {
    echo "
    <div class='section'>
        <div class='container'>
             <form class='form-horizontal' method='post' action=''>
                <input type='hidden' name='change' value='$id' >
                <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-success'>Atendido! <span class='glyphicon glyphicon-ok-sign'></span></button>
                </div>
             </form>
        </div>
     </div>
    ";
}
?>
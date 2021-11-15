<?php
header ('Content-type: text/html; charset=UTF-8');
$id = isset($_POST['id']) ? $_POST['id'] : '';
$loja = isset($_POST['loja']) ? $_POST['loja'] : '';
$idCategoria = isset($_POST['idCategoria']) ? $_POST['idCategoria'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$img1 = isset($_POST['img1']) ? $_POST['img1'] : '';
$img2 = isset($_POST['img2']) ? $_POST['img2'] : '';
$img3 = isset($_POST['img3']) ? $_POST['img3'] : '';
$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
$identificador = isset($_POST['identificador']) ? $_POST['identificador'] : '';
$peso = isset($_POST['peso']) ? $_POST['peso'] : '';
$preco = isset($_POST['preco']) ? $_POST['preco'] : '';
$quantidade = isset($_POST['quantidade']) ? $_POST['quantidade'] : '';
$maximo= isset($_POST['maximo']) ? $_POST['maximo'] : '';
$file[] =$img1;
$file[] =$img2;
$file[] =$img3;
$url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
echo "
<html><head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
        <script type='text/javascript' src='http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
        <link href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <link href='http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css' rel='stylesheet' type='text/css'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    </head>
<body>

<div class='section'>
        <div class='container'>
                <div class='row'>
                        <div class='col-md-8'>
                                <div id='carousel-example' data-interval='false' class='carousel slide' data-ride='carousel'>
                                        <div class='carousel-inner'>
";
$count = 0;
foreach($file as $img){
    if(!empty($img)){
        if($count == 0) {
            echo "
                                                <div class='item active'>
                                                        <img src='../lojas/$loja/$img'>
                                                        <div class='carousel-caption'>
                                                                <h2>$nome</h2>
                                                        </div>
                                                </div>
            ";
        }
        else{
            echo "
                                                <div class='item'>
                                                        <img src='../lojas/$loja/$img'>
                                                        <div class='carousel-caption'>
                                                                <h2>$nome</h2>
                                                        </div>
                                                </div>
            ";
        }
        $count++;
    }
}

echo "
                                        </div>
                                        <a class='left carousel-control' href='#carousel-example' data-slide='prev'>
                                                <i class='icon-prev  fa fa-angle-left'></i>
                                        </a>
                                        <a class='right carousel-control' href='#carousel-example' data-slide='next'>
                                                <i class='icon-next fa fa-angle-right'></i>
                                        </a>
                                </div>
                        </div>
                        <div class='col-md-4'>
                                <h1>$nome</h1>
                                <h2>R$ $preco</h2>
                                <p>$descricao</p><br>
                                <p>Peso: $peso</p>
                        </div>
                </div>
        </div>
</div>

<form class='form-horizontal' method='post' action='../controller/controllerBag.php'>
    <fieldset>

        <!-- Form Name -->
        <legend>Detalhes do Pedido</legend>

<!-- Text input-->
<div class='form-group'>
    <label class='col-md-4 control-label' for='nome'>Nome do Produto</label>
    <div class='col-md-6'>
        <input id='nome' name='nome' type='text' placeholder='' value='$nome' disabled='' class='form-control input-md' required=''>

    </div>
</div>

<!-- Password input-->
<div class='form-group'>
    <label class='col-md-4 control-label' for='quantidade'>Quantidade</label>
    <div class='col-md-6'>
        <input id='quantidade' name='quantidade' type='number' placeholder='' min='1' max='$maximo' class='form-control input-md' required=''>

    </div>
</div>

<!-- Button (Double) -->
<div class='form-group'>
    <label class='col-md-4 control-label' for=''></label>
    <div class='col-md-8'>
        <button id='' name='' type='submit' class='btn btn-success'>Adicionar ao Carrinho <span class='glyphicon glyphicon-plus'></span></button>
        <button id='' name='' type='reset' class='btn btn-info'>Limpar <span class='glyphicon glyphicon-trash'></span></button>
    </div>
</div>
<!-- Hidden input -->
<input type='hidden' name='nome' value='$nome'>
<input type='hidden' name='idProduto' value='$id'>
<input type='hidden' name='idLoja' value='$loja'>
<input type='hidden' name='preco' value='$preco'>
<input type='hidden' name='idCategoria' value='$idCategoria'>

</fieldset>
</form>

</body>
</html>
";
?>

<?php
session_start();
$post = isset($_POST['post'])?$_POST['post']:'';
$id = isset($_POST['id'])?$_POST['id']:'';
$idCategoria = isset($_POST['idCategoria'])?$_POST['idCategoria']:'';
$nome = isset($_POST['nome'])?$_POST['nome']:'';
$img1 = isset($_POST['img1'])?$_POST['img1']:'';
$img2 = isset($_POST['img2'])?$_POST['img2']:'';
$img3 = isset($_POST['img3'])?$_POST['img3']:'';
$descricao = isset($_POST['descricao'])?$_POST['descricao']:'';
$identificador = isset($_POST['identificador'])?$_POST['identificador']:'';
$peso = isset($_POST['peso'])?$_POST['peso']:'';
$preco = isset($_POST['preco'])?$_POST['preco']:'';
$quantidade = isset($_POST['quantidade'])?$_POST['quantidade']:'';
$maximo = isset($_POST['maximo'])?$_POST['maximo']:'';
if(!$post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
    header("../");
}

?>
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
<form class="form-horizontal" enctype="multipart/form-data" method="post" action="../controller/controllerUpdateProduto.php">
    <fieldset>

        <!-- Form Name -->
        <legend>Atualização de Produto</legend>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="categoria">Categoria</label>
            <div class="col-md-6">
                <select id="categoria" name="categoria" class="form-control">
                    <?php
                    require_once"../model/read.php";
                    $read = new \Admin\Read();
                    $read->getOptionCategoriaUpdate($_SESSION['idAtual'],$idCategoria);
                    $src = $read->getImageFormUpdate($_SESSION['idAtual'],$id);
                    ?>
                </select>
            </div>
        </div>
        <input type="hidden" value="<?php echo $post ?>" name="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="nome">Nome do Produto</label>
            <div class="col-md-6">
                <input id="nome" name="nome" type="text" placeholder="" value="<?php echo $nome ?>" class="form-control input-md" required="">
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="img1">Imagem 1</label>

            <div class="col-md-4">
                <input id="img1" name="img1" class="input-file" type="file">
                <?php echo $src[0] ?>
            </div>

        </div>
        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="img2">Imagem 2</label>
            <div class="col-md-4">
                <input id="img2" name="img2" class="input-file" type="file">
                <?php echo $src[1] ?>
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="img3">Imagem 3</label>
            <div class="col-md-4">
                <input id="img3" name="img3" class="input-file" type="file">
                <?php echo $src[2] ?>
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="descricao">Descrição do produto</label>
            <div class="col-md-4">
                <textarea class="form-control"  id="descricao" name="descricao"><?php echo $descricao ?></textarea>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="identificador">Identificador</label>
            <div class="col-md-6">
                <input id="identificador" name="identificador" type="text" value="<?php echo $identificador ?>" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="peso">Peso</label>
            <div class="col-md-6">
                <input id="peso" name="peso" type="text" placeholder="kg" value="<?php echo $peso ?>" class="form-control input-md">
                <span class="help-block">1kg = 1 | 100g = 0.1kg | 25g = 0.025kg</span>
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="preco">Preco</label>
            <div class="col-md-6">
                <input id="preco" name="preco" type="text" placeholder="R$" value="<?php echo $preco ?>" class="form-control input-md">
                <span class="help-block">1R$ = 1,00 </span>
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="quantidade">Quantidade</label>
            <div class="col-md-6">
                <input id="quantidade" name="quantidade" type="number" placeholder="" value="<?php echo $quantidade ?>" class="form-control input-md">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="maximo">Quantidade maxima por pedido</label>
            <div class="col-md-6">
                <input id="maximo" name="maximo" type="number" placeholder="" value="<?php echo $maximo ?>" class="form-control input-md">
            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success">Atualizar</button>
                <button type="reset" class="btn btn-info">Limpar</button>
                <button value="delete" name="delete" class="btn btn-danger" type="submit">Deletar</button>
            </div>
        </div>

    </fieldset>
</form>


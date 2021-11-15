<?php
$post = isset($_POST['post'])?$_POST['post']:'';
$id = isset($_POST['id'])?$_POST['id']:'';
$nome = isset($_POST['nome'])?$_POST['nome']:'';
if(!$post === md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
    header("../");
}
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
<form class="form-horizontal" method="post" action="../controller/controllerUpdateCategoria.php">
    <fieldset>

        <!-- Form Name -->
        <legend>Atualização de Categoria</legend>
        <input type="hidden" value="<?php echo $post ?>" name="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="nome">Categoria</label>
            <div class="col-md-6">
                <input id="nome" name="nome" type="text" value="<?php echo $nome ?>" placeholder="" class="form-control input-md" required="">
            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-8">
                <button class="btn btn-success" type="submit">Atualizar</button>
                <button id="" name="" class="btn btn-info" type="reset">Limpar</button>
                <button value="delete" name="delete" class="btn btn-danger" type="submit">Deletar</button>
            </div>
        </div>

    </fieldset>
</form>

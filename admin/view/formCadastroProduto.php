<?php
$_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if(!(isset($_SESSION['check']) && $_SESSION['check'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))){
    header("Location:../");
}
?>
<head>
    <meta charset="UTF-8">
</head>
<form class="form-horizontal" enctype="multipart/form-data" method="post" action="controller/controllerCadastroProduto.php">
    <fieldset>

        <!-- Form Name -->
        <legend>Cadastro de Produto</legend>
        <input type="hidden" value="<?php echo $_SESSION['post'] ?>" name="post">

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="categoria">Categoria</label>
            <div class="col-md-6">
                <select id="categoria" name="categoria" class="form-control">
                    <?php
                    require_once"model/read.php";
                    $read = new \Admin\Read();
                    $read->getCategoriaForm($_SESSION['idAtual']);
                    ?>
                </select>
            </div>
        </div>

             <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="nome">Nome do Produto</label>
            <div class="col-md-6">
                <input id="nome" name="nome" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="img-1">Imagem 1</label>
            <div class="col-md-4">
                <input id="img-1" name="img-1" class="input-file" type="file">
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="img-2">Imagem 2</label>
            <div class="col-md-4">
                <input id="img-2" name="img-2" class="input-file" type="file">
            </div>
        </div>

        <!-- File Button -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="img-3">Imagem 3</label>
            <div class="col-md-4">
                <input id="img-3" name="img-3" class="input-file" type="file">
            </div>
        </div>

        <!-- Textarea -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="descricao">Descrição do produto</label>
            <div class="col-md-4">
                <textarea class="form-control" id="descricao" name="descricao"></textarea>
            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="identificador">Identificador</label>
            <div class="col-md-6">
                <input id="identificador" name="identificador" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="peso">Peso</label>
            <div class="col-md-6">
                <input id="peso" name="peso" type="text" placeholder="kg" class="form-control input-md">
                <span class="help-block">1kg = 1 | 100g = 0.1kg | 25g = 0.025kg</span>
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="preco">Preço</label>
            <div class="col-md-6">
                <input id="preco" name="preco" type="text" placeholder="R$" class="form-control input-md">
                <span class="help-block">1R$ = 1,00</span>
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="quantidade">Quantidade</label>
            <div class="col-md-6">
                <input id="quantidade" name="quantidade" type="number" placeholder="" class="form-control input-md">
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="maximo">Quantidade maxima por pedido</label>
            <div class="col-md-6">
                <input id="maximo" name="maximo" type="number" placeholder="" class="form-control input-md">
            </div>
        </div>
        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success">Cadastrar</button>
                <button type="reset" class="btn btn-info">Limpar</button>
            </div>
        </div>

    </fieldset>
</form>

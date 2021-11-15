<?php
$_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if(!(isset($_SESSION['login']) && $_SESSION['login'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))){
    header("Location:../");
}
?>
<form class="form-horizontal" method="post" action="controller/controllerCadastroCategoria.php">
    <fieldset>

        <!-- Form Name -->
        <legend>Cadastro de Categoria</legend>
        <input type="hidden" value="<?php echo $_SESSION['post'] ?>" name="post">

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="nome">Categoria</label>
            <div class="col-md-6">
                <input id="nome" name="nome" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-8">
                <button id="" name="" class="btn btn-success" type="submit">Cadastrar</button>
                <button id="" name="" class="btn btn-info" type="reset">Limpar</button>
            </div>
        </div>

    </fieldset>
</form>

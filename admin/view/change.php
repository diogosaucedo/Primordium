<?php
if(!(isset($_SESSION['check']) && $_SESSION['check'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))){
    header("Location:../");
}
?>
<form class="form-horizontal" method="post" action="controller/controllerChange.php">
    <fieldset>

        <!-- Form Name -->
        <legend>Selecione a Loja</legend>

        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="loja">Lojas <span class="glyphicon glyphicon-briefcase"></span></label>
            <div class="col-md-6">
                <select id="loja" name="loja" class="form-control">
                    <?php
                    require_once'model/read.php';
                    $read = new \Admin\Read();
                    $read->getLojaForm($_SESSION['idCliente']);
                    ?>
                </select>
            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success">Selecionar</button>
                <button type="reset" class="btn btn-info">Limpar</button>
            </div>
        </div>

    </fieldset>
</form>

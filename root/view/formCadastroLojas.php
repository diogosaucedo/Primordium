<?php
require_once"model/read.php";
$_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if(!(isset($_SESSION['login']) && $_SESSION['login'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))){
    header("Location:../");
}
?>
<form class="form-horizontal" action="controller/controllerCadastroLojas.php" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>Cadastro Empresa</legend>
        <input type="hidden" value="<?php echo $_SESSION['post'] ?>" name="post">
        <!-- Text input-->
        <!-- Select Basic -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Categoria</label>
            <div class="col-md-6">
                <select id="categoria" name="categoria" class="form-control">
                    <?php
                    $op = new \Root\Read();
                    $op->readOptionCategoria();
                    ?>

                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Cliente</label>
            <div class="col-md-6">
                <select id="id" name="id" class="form-control">
                    <?php
                    $op = new \Root\Read();
                    $op->readOptionCliente();
                    ?>

                </select>
            </div>
         </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Razão social</label>
            <div class="col-md-6">
                <input id="textinput" name="razao" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nome Fantasia</label>
            <div class="col-md-6">
                <input id="textinput" name="fantasia" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Inscrição estadual</label>
            <div class="col-md-6">
                <input id="textinput" name="inscricao" type="text" placeholder="" class="form-control input-md">

            </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="checkboxes"></label>
            <div class="col-md-4">
                <div class="checkbox">
                    <label for="checkboxes-0">
                        <input type="checkbox" name="optante" value="sim">
                        Optante pelo Simples
                    </label>
                </div>
                <div class="checkbox">
                    <label for="checkboxes-1">
                        <input type="checkbox" name="isento" value="sim">
                        ISENTO
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Status</label>
            <div class="col-md-6">
                <select id="id" name="status" class="form-control">
                    <option value="1">Online</option>
                    <option value="0">Offline</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Duração</label>
            <div class="col-md-6">
                <select id="duracao" name="duracao" class="form-control">
                    <option value='1'>Permanente</option>
                    <option value='0'>Temporario</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Inicio de Expediente</label>
            <div class="col-md-6">
                <select id="inicio" name="inicio" class="form-control">
                    <?php
                    $op = new \Root\Read();
                    $op->readHoursOptions();
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Fim de Expediente</label>
            <div class="col-md-6">
                <select id="fim" name="fim" class="form-control">
                    <?php
                    $op = new \Root\Read();
                    $op->readHoursOptions();
                    ?>
                </select>
            </div>
        </div>


        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success">Cadastrar</button>
                <button type="reset" name="button2id" class="btn btn-info">Limpar</button>
            </div>
        </div>

    </fieldset>
</form>

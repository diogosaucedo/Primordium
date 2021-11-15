<?php
$_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
?>
<form class="form-horizontal" method="post" action="controller/controllerCadastro.php">
    <fieldset>

        <!-- Form Name -->
        <legend>Cadastro de Usuario</legend>
        <input type="hidden" value="<?php echo $_SESSION['post'] ?>" name="post">

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nome Completo  <span class="glyphicon glyphicon-user"></span></label>
            <div class="col-md-6">
                <input id="textinput" name="nome" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Email  <span class="glyphicon glyphicon-envelope"></span></label>
            <div class="col-md-6">
                <input id="textinput" name="email" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="passwordinput">Senha  <span class="glyphicon glyphicon-lock"></span></label>
            <div class="col-md-6">
                <input id="passwordinput" name="senha" type="password" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Celular  <span class="glyphicon glyphicon-phone"></span></span></label>
            <div class="col-md-6">
                <input id="textinput" name="celular" type="text" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success">Cadastrar</button>
                <button type="reset" class="btn btn-info">Limpar</button>
            </div>
        </div>

    </fieldset>
</form>

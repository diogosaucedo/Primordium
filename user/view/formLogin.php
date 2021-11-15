<?php
$_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
?>
<form class="form-horizontal" method="post" action="controller/controllerLogin.php">
    <fieldset>

        <!-- Form Name -->
        <legend>Login</legend>
        <input type="hidden" value="<?php echo $_SESSION['post'] ?>" name="post">

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="email">Email <span class="glyphicon glyphicon-envelope"></span></label>
            <div class="col-md-6">
                <input id="email" name="email" type="email" placeholder="exemplo@email.com" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="senha">Senha <span class="glyphicon glyphicon-lock"></span></label>
            <div class="col-md-6">
                <input id="senha" name="senha" type="password" placeholder="" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for=""></label>
            <div class="col-md-8">
                <button id="" name="" type="submit" class="btn btn-success">Entrar</button>
                <button id="" name="" type="reset" class="btn btn-info">Limpar</button>
            </div>
        </div>

    </fieldset>
</form>

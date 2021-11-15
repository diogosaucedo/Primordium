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
<form class="form-horizontal" method="post" action="controller/controllerUpdate.php">
    <fieldset>

        <!-- Form Name -->
        <legend>Atualização de Usuario</legend>

        <!-- Text input-->
        <input type="hidden" name="id" value="<?php echo $_SESSION['id_user'] ?>">
        <input type="hidden" name="post" value="<?php echo $post ?>">
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nome Completo <span class="glyphicon glyphicon-user"></span></label>
            <div class="col-md-6">
                <input id="textinput" name="nome" type="text" placeholder="" value="<?php echo $_SESSION['user_name'] ?>" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Email <span class="glyphicon glyphicon-envelope"></label>
            <div class="col-md-6">
                <input id="textinput" name="email" type="text" placeholder="" value="<?php echo $_SESSION['email'] ?>" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="passwordinput">Senha <span class="glyphicon glyphicon-lock"></span></label>
            <div class="col-md-6">
                <input id="passwordinput" name="senha" type="password" placeholder="" value="<?php echo $_SESSION['password'] ?>" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Celular <span class="glyphicon glyphicon-phone"></span></label>
            <div class="col-md-6">
                <input id="textinput" name="celular" type="text" placeholder="" value="<?php echo $_SESSION['cell'] ?>" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success">Atualizar</button>
                <button type="reset" class="btn btn-info">Limpar</button>
            </div>
        </div>

    </fieldset>
</form>
</html>



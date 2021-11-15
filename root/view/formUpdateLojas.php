<?php
require_once"../model/read.php";
$id_loja = isset($_POST['id_loja'])?$_POST['id_loja']:'';
$id_categoria = isset($_POST['id_categoria'])?$_POST['id_categoria']:'';
$id_dono = isset($_POST['id_dono'])?$_POST['id_dono']:'';
$razao = isset($_POST['razao'])?$_POST['razao']:'';
$fantasia = isset($_POST['fantasia'])?$_POST['fantasia']:'';
$inscricao = isset($_POST['inscricao'])?$_POST['inscricao']:'';
$isento = isset($_POST['isento'])?$_POST['isento']:'';
$optante = isset($_POST['optante'])?$_POST['optante']:'';
$post = isset($_POST['post'])?$_POST['post']:'';
$status = isset($_POST['status'])?$_POST['status']:'';
$inicio = isset($_POST['inicio'])?$_POST['inicio']:'';
$fim = isset($_POST['fim'])?$_POST['fim']:'';

if($post != md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
    header("Location: ../");
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
<form class="form-horizontal" action="../controller/controllerUpdateLojas.php" method="post">
    <fieldset>

        <!-- Form Name -->
        <legend>Atualização de Empresa</legend>
        <!-- Text input-->
        <input type="hidden" value="<?php echo $id_loja ?>" name="id_loja">
        <input type="hidden" name="post" value="<?php echo $post ?>">
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Categoria</label>
            <div class="col-md-6">
                <select id="categoria" name="categoria" class="form-control">
                    <?php
                    $op = new \Root\Read();
                    $op->readOptionCategoriaUpdate($id_categoria);
                    ?>

                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Cliente</label>
            <div class="col-md-6">
                <select id="dono" name="dono" class="form-control">
                    <?php
                    $op = new \Root\Read();
                    $op->readOptionClienteUpdade($id_dono);
                    ?>

                </select>
            </div>
        </div>
        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Razão social</label>
            <div class="col-md-6">
                <input id="textinput" name="razao" type="text" placeholder="" value="<?php echo $razao ?>" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Nome Fantasia</label>
            <div class="col-md-6">
                <input id="textinput" name="fantasia" type="text" placeholder="" value="<?php echo $fantasia ?>" class="form-control input-md" required="">

            </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="textinput">Inscrição estadual</label>
            <div class="col-md-6">
                <input id="textinput" name="inscricao" type="text" placeholder="" value="<?php echo $inscricao ?>" class="form-control input-md">

            </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="checkboxes"></label>
            <div class="col-md-4">
                <div class="checkbox">
                    <label for="checkboxes-0">
                        <input type="checkbox" name="optante" value="sim" <?php if($optante == 'sim'){echo "checked";} ?>>
                        Optante pelo Simples
                    </label>
                </div>
                <div class="checkbox">
                    <label for="checkboxes-1">
                        <input type="checkbox" name="isento" value="sim"<?php if($isento == 'sim'){echo "checked";} ?>>
                        ISENTO
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Status</label>
            <div class="col-md-6">
                <select id="status" name="status" class="form-control">
                    <?php
                    $op = new \Root\Read();
                    $op->readOptionStatusUpdate($status);
                    ?>

                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label" for="selectbasic">Inicio de Expediente</label>
            <div class="col-md-6">
                <select id="inicio" name="inicio" class="form-control">
                    <?php
                    $op = new \Root\Read();
                    $op->readHoursOptionsUpdate($inicio);
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
                    $op->readHoursOptionsUpdate($fim);
                    ?>
                </select>
            </div>
        </div>
        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="button1id"></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success">Atualizar</button>
                <button type="reset" name="button2id" class="btn btn-info">Limpar</button>
                <button type="submit" class="btn btn-danger" name="excluir" value="excluir">Excluir</button>
            </div>
        </div>

    </fieldset>
</form>
</html>

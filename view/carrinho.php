<?php
header('Content-type: text/html; charset=ISO-8859-1');
ob_start();
session_start();
$indice = isset($_POST['indice'])?$_POST['indice']:'';
$quantidade = isset($_POST['quantidade'])?$_POST['quantidade']:'';
$atualizar = isset($_POST['refresh'])?$_POST['refresh']:'';
$delete = isset($_POST['delete'])?$_POST['delete']:'';
if($atualizar){
    $_SESSION['car'][$indice][1] = $quantidade;
}
if($delete){
    unset($_SESSION['car'][$indice]);
}
echo"
<html>
<head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
        <script type='text/javascript' src='http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
        <link href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css' rel='stylesheet' type='text/css' media='all'>
        <link href='http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css' rel='stylesheet' type='text/css' media='all'>
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>

        <!-- Optional theme -->
        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css'>

        <!-- Latest compiled and minified JavaScript -->
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
    </head><body>";
if(!empty($_SESSION['car'])){
    echo"

<div class='section'>
        <div class='container'>
                <div class='row'>
                        <div class='col-md-12'>
                                <h1>Carrinho</h1>
                        </div>
                </div>
                <div class='row'>
                        <div class='col-md-6'>
                                <table class='table'>
                                        <thead>
                                        <tr>
                                                <th>Produto</th>
                                                <th>Quantidade</th>
                                                <th><span class='glyphicon glyphicon-refresh'></span></th>
                                                <th>Preço</th>
                                                <th>Preço conjunto</th>
                                                <th><span class='glyphicon glyphicon-remove'></span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
";
$tPreco = 0;
$i = 0;
$tLojas[]=0;
foreach($_SESSION['car'] as $carrinho){
$tProduto = $carrinho[1] * $carrinho[4];
$tPreco += $tProduto;
    if(!in_array($carrinho[3], $tLojas)){
        $tLojas[] = $carrinho[3];
    }
echo"                            <form method='post' action='".$_SERVER['php_self']."'>
                                        <tr>
                                                <td>$carrinho[0]</td>
                                                <td><div class='form-group'><div class='col-md-6'><input id='quantidade' name='quantidade' type='number' min='1' placeholder='$carrinho[1]' class='form-control'></div></div></td>
                                                <td><button id='' name='refresh' value='true' type='submit' class='btn btn-success'><span class='glyphicon glyphicon-refresh'></span></button></td>
                                                <td>$carrinho[4]</td>
                                                <td>$tProduto</td>
                                                <td><button id='' name='delete' value='true' type='submit' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span></button></td>

                                        </tr>
                                        <input type='hidden' name='indice' value='$i'>
                                 </form>
";
    $i++;
}
$result = count($tLojas) - 1;
echo"
                                        </tbody>
                                </table>
                        </div>
                        <div class='col-md-6'>
                                <h1>Total: R$ $tPreco</h1>
                                <h2>Seu pedido sera enviado a $result loja(s)</h2>
                                <br>
                                <a href='http://www.primordium.com.br'><button class='btn btn-primary'> Continuar comprando! <span class='glyphicon glyphicon-home'></span></button></a>
                        </div>
                </div>
        </div>
</div>
";
if(isset($_SESSION['user'])){
    echo"
<div class='section'>
        <div class='container'>
    <form class='form-horizontal' method='post' action='../controller/controllerCarrinho.php'>
<fieldset>

<!-- Form Name -->
<legend>Dados da Entrega</legend>

<!-- Text input-->
<div class='form-group'>
  <label class='col-md-4 control-label' for='endereco'>Endereço</label>  
  <div class='col-md-6'>
  <input id='endereco' name='endereco' type='text' placeholder='Av. Marechal Rondon' class='form-control input-md' required=''>
    
  </div>
</div>

<!-- Text input-->
<div class='form-group'>
  <label class='col-md-4 control-label' for='bairro'>Bairro</label>  
  <div class='col-md-6'>
  <input id='bairro' name='bairro' type='text' placeholder='' class='form-control input-md' required=''>
    
  </div>
</div>

<!-- Text input-->
<div class='form-group'>
  <label class='col-md-4 control-label' for='complemento'>Complemento</label>  
  <div class='col-md-6'>
  <input id='complemento' name='complemento' type='text' placeholder='Casa/Apartamento/Kitnet' class='form-control input-md' required=''>
    
  </div>
</div>

<!-- Text input-->
<div class='form-group'>
  <label class='col-md-4 control-label' for='numero'>Nº</label>  
  <div class='col-md-6'>
  <input id='numero' name='numero' type='text' placeholder='1234' class='form-control input-md' required=''>
    
  </div>
</div>

<!-- Textarea -->
<div class='form-group'>
  <label class='col-md-4 control-label' for='extras'>Informações extras</label>
  <div class='col-md-4'>                     
    <textarea class='form-control' id='extras' name='extras'></textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class='form-group'>
  <label class='col-md-4 control-label' for='enviar'></label>
  <div class='col-md-8'>
    <button id='enviar' name='enviar' class='btn btn-success' type='submit'>Enviar Pedido <span class='glyphicon glyphicon-send'></span></button>
    <button id='reset' name='reset' class='btn btn-info' type='reset'>Limpar <span class='glyphicon glyphicon-trash'></span></button>
  </div>
</div>

</fieldset>
</form>
</div>
</div>
</body>
</html>
    ";
}
else{
    echo"
    <div class='container-fluid'>
	<div class='row'>
		<div class='col-md-12'>
			<div class='alert alert-danger alert-dismissable'>
				<h4>
					Ops <span class='glyphicon glyphicon-exclamation-sign'></span>
				</h4> <strong>Você não está registrado em nosso sistema!</strong> Para que possa concluir o envio do pedido, <a href='http://www.primordium.com.br/user/insert'><button class='btn btn-default'> Cadastre-se </button></a> ou faça <a href='http://www.primordium.com.br/user/login'><button class='btn btn-default'> Login </button></a>
            </div>
		</div>
	</div>
</div>
    ";
}
}
else{
    echo"<div class='section'><div class='container'><h1>O seu carrinho está vazio! <a href='http://www.primordium.com.br'><button class='btn btn-default'> Voltar a home <span class='glyphicon glyphicon-home'></span></button></a></h1></div></div>";
}

ob_end_flush();
?>
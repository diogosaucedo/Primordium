<?php
$delete = isset($_POST['delete'])?$_POST['delete']:'';
session_start();
if(!empty($delete)){
    require_once"model/delete.php";
    $delete = new \Admin\Delete();
    if($delete->clearSales($_SESSION['idAtual'])){
        header("location:http://www.primordium.com.br/admin/venda-new");
    }
}

echo"
<div class='col-md-8'>
        <form class='form-horizontal' method='post' action=''>
                <h1>Deseja limpar historico?</h1>
                <p>Se você clicar em 'limpar' todos os pedidos atendidos serão apagados.</p>
                <div class='col-md-8'>
                    <button value='true' name='delete' class='btn btn-success'>Limpar! <span class='glyphicon glyphicon-trash'></span></button>
                </div>
             </form>
</div>
"
?>
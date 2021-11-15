<?php
$delete = isset($_POST['delete'])?$_POST['delete']:'';
if(!empty($delete)){
    require_once"../model/delete.php";
    $delete = new \User\Delete();
    session_start();
    if($delete->deletePedidos($_SESSION['id_user'])){
        header("location:http://www.primordium.com.br/user/pedidos-enviados");
    }
}

echo"
<div class='col-md-8'>
        <form class='form-horizontal' method='post' action=''>
                <h1>Deseja limpar historico?</h1>
                <p>Se você clicar em 'limpar' todas suas solicitações serão apagadas.</p>
                <div class='col-md-8'>
                    <button value='true' name='delete' class='btn btn-success'>Limpar! <span class='glyphicon glyphicon-trash'></span></button>
                </div>
             </form>
</div>
"
?>
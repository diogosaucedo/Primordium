<?php
if(!(isset($_SESSION['check']) && $_SESSION['check'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))){
    header("Location:../");
}else{
    if(!$_SESSION['edit']){
        header("Location:change");
    }
}
?>
<body>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="categoria-inserir">Inserir dados</a>
                    </li>

                </ul>
            </div>
            <div class="col-md-8">
                <?php
                if(isset($atual[1]) && $atual[1] == "inserir") {
                    require_once "formCadastroCategoria.php";
                }
                else{
                   require_once"model/read.php";
                   $read = new \Admin\Read();
                   $read->getCategoriaLojas($_SESSION['idAtual']);
                }
                ?>


            </div>
        </div>
    </div>
</div>
</body>
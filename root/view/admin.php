<?php
if(!(isset($_SESSION['login']) && $_SESSION['login'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']))){
    header("Location:../");
}
?>
<body>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="admin_inserir">Inserir dados</a>
                    </li>

                </ul>
            </div>
            <div class="col-md-8">
                <?php
                if(isset($atual[1])) {
                    if ($atual[1] == "inserir") {
                        if ($atual['0'] == "admin") {
                            require_once "formCadastroAdmin.php";
                        };
                        if ($atual['0'] == "clientes") {
                            require_once "formCadastroCliente.php";
                        };
                        if ($atual['0'] == "lojas") {
                            require_once "formCadastroLojas.php";
                        };
                        if ($atual['0'] == "usuarios") {
                            require_once "formCadastroUsuario.php";
                        };
                    }
                }
                else{
                    require_once"model/read.php";
                    $read = new \Root\Read();
                    $read->readTableAdmin();
                }
                ?>


            </div>
        </div>
    </div>
</div>
</body>
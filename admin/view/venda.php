<?php
header('Content-type: text/html; charset=ISO-8859-1');

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
                        <a href="venda-new">Novas solicitações <span class="glyphicon glyphicon-bell"></span> <?php if($_SESSION['news'] > 0){echo " (".$_SESSION['news'].")";} ?></a>
                    </li>
                    <li class="list-group-item">
                        <a href="venda-old">Já atendidas <span class="glyphicon glyphicon-ok"></span></a>
                    </li>
                    <li class="list-group-item">
                        <a href="venda-clear">Limpar historico <span class="glyphicon glyphicon-trash"></span></a>
                    </li>


                </ul>
            </div>
            <div class="col-md-8">
                <?php

                if(isset($atual[1])){
                    switch($atual[1]){
                        case "new";
                            require_once "formNewSales.php";
                            break;
                        case "old";
                            require_once "formOldSales.php";
                            break;
                        case "clear";
                            require_once "formClearSales.php";
                            break;
                        case "query";
                            require_once "formSearch.php";

                    }
                    if($atual[1] == "expired" && $_SESSION['temp'] == 0){
                        require_once "ExpiredSales.php";
                    }
                }

                if(isset($atual[1]) && $atual[1] == "new") {
                    require_once "formNewSales.php";
                }
                elseif(isset($atual[1]) && $atual[1] == "old"){
                    require_once "formOldSales.php";
                }
                ?>


            </div>
        </div>
    </div>
</div>
</body>

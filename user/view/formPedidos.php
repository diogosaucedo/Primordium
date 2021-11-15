<body>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="pedidos-enviados">Pedidos  <span class="glyphicon glyphicon-send"></span></a>
                    </li>
                    <li class="list-group-item">
                        <a href="pedidos-clear">Limpar historico <span class="glyphicon glyphicon-trash"></span></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8">
                <?php
                if(isset($atual[1])){
                    switch($atual[1]){
                        case "enviados";
                            require_once "formPedidosEnviados.php";
                            break;
                        case "clear";
                            require_once "formLimpaPedidos.php";

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
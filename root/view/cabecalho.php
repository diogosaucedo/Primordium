<body>
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="home"><span>Primordium</span></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                session_start();
                if(isset($_SESSION['login']) && $_SESSION['login'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){

                    echo'<li>
                    <a href="home">Home</a>
                </li>
                <li>
                    <a href="lojas">Lojas</a>
                </li>
                <li>
                    <a href="usuarios">Usuarios</a>
                </li>
                <li>
                    <a href="clientes">Clientes</a>
                </li>
                <li>
                    <a href="admin">Administradores</a>
                </li>
                <li>
                    <a href="categoria">Categorias</a>
                </li>
                ';
                }
                ?>
            </ul>
        </div>
    </div>
</div>
</body>
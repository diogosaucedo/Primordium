<?php
namespace User;
require_once"connection.php";
require_once"success.php";
require_once"error.php";

class Read{
    protected $sql;
    protected $connection;
    protected $message;
    protected $link;
    protected $line;
    protected $count;

    function readCategoria(){
        $this->sql ="
        SELECT * FROM categorias
        ";
        $this->connection = new Connection();
        $read = $this->connection->connection();
        $result = $read->query($this->sql);
        echo '
         <div class="section">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group">
        ';
        while($this->line = $result->fetch(\PDO::FETCH_ASSOC)){
            echo "<li class='list-group-item'><a href='".base64_decode($this->line['nome_categoria'])."'><button class='btn btn-large btn-block btn-primary'>".base64_decode($this->line['nome_categoria'])."</button></a></li><hr>";

        }
        echo '
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
    function readLojas($categoria){
        $categoria = base64_encode($categoria);
        $this->sql ="
        SELECT id_categoria FROM categorias WHERE nome_categoria = :nome
        ";
        $this->connection = new Connection();
        $read = $this->connection->connection();
        $result = $read->prepare($this->sql);
        $result->bindValue(":nome",$categoria,\PDO::PARAM_STR);
        $result->execute();
        $this->count = $result->rowCount();
        if($this->count === 1){
            $this->line = $result->fetch(\PDO::FETCH_ASSOC);
            $id = $this->line['id_categoria'];
            $this->sql ="
            SELECT * FROM lojas WHERE id_categoria = :id and status = 1
            ";
            $result = $read->prepare($this->sql);
            $result->bindValue(":id",$id,\PDO::PARAM_INT);
            $result->execute();
            echo '
                 <div class="section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
            ';
            while($this->line = $result->fetch(\PDO::FETCH_ASSOC)){
                echo "<li class='list-group-item'><a href='".$_SERVER['REQUEST_URI']."-".strtolower($this->line['id_loja'])."'><button class='btn btn-large btn-block btn-primary'>".base64_decode($this->line['razao_social'])."</button></a></li><hr>";
            }
            echo '
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
             ';
        }


    }
    function readCategoriaLoja($loja){
        if(is_numeric($loja)){
            $this->sql ="
            SELECT * FROM categorias_$loja
            ";
            $this->connection = new Connection();
            $read = $this->connection->connection();
            $result = $read->query($this->sql);
            echo '
                 <div class="section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="list-group">
            ';
            while($this->line = $result->fetch(\PDO::FETCH_ASSOC)){
                echo "<li class='list-group-item'><a href='".$_SERVER['REQUEST_URI']."-".strtolower($this->line['id'])."'><button class='btn btn-large btn-block btn-primary'>".base64_decode($this->line['nome_categoria'])."</button></a></li><hr>";
            }
            echo '
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
             ';

        }
    }
    function readProdutos($loja,$categoria){
        if(is_numeric($loja)){
            if(is_numeric($categoria)){
                $this->sql ="
                SELECT * FROM produtos_$loja where id_categoria = :id AND quantidade >= :quantidade
                ";
                $this->connection = new Connection();
                $read = $this->connection->connection();
                $result = $read->prepare($this->sql);
                $result->bindValue(':id',$categoria,\PDO::PARAM_INT);
                $result->bindValue(':quantidade',1,\PDO::PARAM_INT);
                $result->execute();
                while($this->line = $result->fetch(\PDO::FETCH_ASSOC)){
                    echo "
                        <form class='form-horizontal' method='post' action='view/addBag.php'>
                            <!-- Form Name -->
                            <!-- Button (Double) -->
                            <input type='hidden' name='id' value='" . htmlspecialchars($this->line['id']) . "'>
                            <input type='hidden' name='loja' value='" . htmlspecialchars($loja) . "'>
                            <input type='hidden' name='idCategoria' value='" . htmlspecialchars($this->line['id_categoria']) . "'>
                            <input type='hidden' name='nome' value='" . htmlspecialchars(base64_decode($this->line['nome_produto'])) . "'>
                            <input type='hidden' name='img1' value='" . htmlspecialchars($this->line['img_1']) . "'>
                            <input type='hidden' name='img2' value='" . htmlspecialchars($this->line['img_2']) . "'>
                            <input type='hidden' name='img3' value='" . htmlspecialchars($this->line['img_3']) . "'>
                            <input type='hidden' name='descricao' value='" . htmlspecialchars(base64_decode($this->line['descricao'])) . "'>
                            <input type='hidden' name='identificador' value='" . htmlspecialchars($this->line['identificador']) . "'>
                            <input type='hidden' name='peso' value='" . htmlspecialchars($this->line['peso']) . "'>
                            <input type='hidden' name='preco' value='" . htmlspecialchars($this->line['preco']) . "'>
                            <input type='hidden' name='quantidade' value='" . htmlspecialchars($this->line['quantidade']) . "'>
                            <input type='hidden' name='maximo' value='" . htmlspecialchars($this->line['maximo']) . "'>
                            <div class='form-group'>
                            <div class='section'>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div class='col-md-12'>
                                          <ul class='list-group'>
                                            <li class='list-group-item'><button type ='submit'  class='btn btn-large btn-block btn-primary'>".base64_decode($this->line['nome_produto'])."</button></li>
                                          </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>

            ";
                }


            }
        }
    }
    function getLoginUser($email,$senha){
        $this->sql="
        SELECT * FROM usuarios WHERE email = :email
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->prepare($this->sql);
        $result->bindValue(':email',$email,\PDO::PARAM_STR);
        $result->execute();
        $count = $result->rowCount();
        /**
         * Confere se foi encontrado apenas 1 registro.
         */
        if($count == 1){
            while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
                /**
                 * Confere se a senha confere com o hash
                 */
                if (crypt($senha, $linha['senha']) === $linha['senha']) {
                    session_start();
                    session_name(md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
                    $_SESSION["user"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
                    $_SESSION['id_user']= $linha['id_usuario'];
                    $_SESSION['user_name'] = base64_decode($linha['nome_usuario']);
                    $_SESSION['email'] = $linha['email'];
                    $_SESSION['password'] = $linha['senha'];
                    $_SESSION['cell'] = $linha['celular'];
                    header("Location:../");

                } /**
                 * Caso a senha não seja a mesma, apresente uma mensagem de erro.
                 */
                else {
                    $this->message="Senha ou email incorretos!<br>";
                    $this->link = "../";
                    $error = new Error();
                    $error->getErroMessage($this->message,$this->link);
                }
            }
        } /**
         * Caso encontre nenhum registro,  apresente a seguinte mensagem
         */
        else{
            $this->message="Senha ou email incorretos!<br>";
            $this->link = "../";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }

    }
    function readCategoriaMenu(){
        $this->sql="
        SELECT * FROM categorias
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while($line = $result->fetch(\PDO::FETCH_ASSOC)){
            echo"
                <li>
                    <a href='http://".$_SERVER['SERVER_NAME'].'/'.base64_decode($line['nome_categoria'])."'>".base64_decode($line['nome_categoria'])."</a>
                </li>
            ";
        }
    }
    function readMenuUser(){
        if(isset($_SESSION['user'])){
            echo"
                <li>
                    <a href='/user'>".$_SESSION['user_name']."</a>
                </li>
            ";
        }
        else{
            echo"
              <li class='active' >
              <a href = 'user/login' > Entrar</a >
              </li >
              <li >
              <a href = 'user/insert' > Cadastrar-se</a >
              </li>
            ";
        }
    }
    function getPedidos($usuario){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM solicitacao_$usuario
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)) {
            echo "
            <form class='form-horizontal' method='post' action='view/request.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='" . $_SESSION['post'] . "'>
                <input type='hidden' name='id' value='" . htmlspecialchars($linha['id']) . "'>
                <input type='hidden' name='pedido' value='" . htmlspecialchars($linha['pedido']) . "'>
                <input type='hidden' name='loja' value='" . htmlspecialchars(base64_decode($linha['loja'])) . "'>
                <input type='hidden' name='status' value='" . htmlspecialchars($linha['status']) . "'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>" . htmlspecialchars(base64_decode($linha['loja'])) . "</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Ver <span class='glyphicon glyphicon-eye-open'></span></button>
                  </div>
                </div>

            </form>
            <hr>
            ";
        }

    }

}


?>
<?php
namespace Admin;
require_once"connection.php";
require_once"error.php";
require_once"success.php";

class Read{
    protected $sql;
    protected $message;
    protected $link;
    function getLoginCliente($email,$senha){
        $this->sql="
        SELECT * FROM clientes WHERE email = :email
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->prepare($this->sql);
        $result->bindValue(':email',$email,\PDO::PARAM_STR);
        $result->execute();
        $count = $result->rowCount();
        if($count == 1){
            while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
                /**
                 * Confere se a senha confere com o hash
                 */
                if (crypt($senha, $linha['senha']) === $linha['senha']) {
                    session_start();
                    session_name(md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
                    $_SESSION["check"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
                    $_SESSION['idCliente']= $linha['id_cliente'];
                    $_SESSION['nome'] = base64_decode($linha['nome']);
                    $this->sql = "
                    SELECT * FROM lojas WHERE id_dono = ".$linha['id_cliente'].";
                    ";
                    $result = $read->query($this->sql);
                    $_SESSION['tLojas'] = $result->rowCount();
                    if($_SESSION['tLojas'] == 1){
                        $linha = $result->fetch(\PDO::FETCH_ASSOC);
                        $_SESSION['lAtual'] = base64_decode($linha['razao_social']);
                        $_SESSION['idAtual'] = $linha['id_loja'];
                        $_SESSION['edit'] = true;
                        header("location:../");
                    }
                    else{
                        $_SESSION['edit'] = false;
                        header('Location:../change');
                    }
                    while($linha = $result->fetch(\PDO::FETCH_ASSOC)){

                    }

                }
                /**
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

    function getCategoriaLojas($idLoja){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM categorias_$idLoja
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)) {
            echo "
            <form class='form-horizontal' method='post' action='view/formUpdateCategoria.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='" . $_SESSION['post'] . "'>
                <input type='hidden' name='id' value='" . htmlspecialchars($linha['id']) . "'>
                <input type='hidden' name='nome' value='" . htmlspecialchars(base64_decode($linha['nome_categoria'])) . "'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>" . htmlspecialchars(base64_decode($linha['nome_categoria'])) . "</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Editar</button>
                  </div>
                </div>

            </form>
            <hr>

            ";
        }
    }

    function getCategoriaForm($idLoja){
        $this->sql="
        SELECT * FROM categorias_$idLoja
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)) {
            echo"<option value=".$linha['id'].">".base64_decode($linha['nome_categoria'])."</option>";
        }
    }
    function getLojaForm($idDono){
        $this->sql="
        SELECT * FROM lojas WHERE id_dono = :id
        ";

        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(":id",$idDono,\PDO::PARAM_INT);
        $db->execute();


        while( $linha = $db->fetch(\PDO::FETCH_ASSOC)) {
            echo"<option value=".$linha['id_loja'].">".base64_decode($linha['razao_social'])."</option>";
        }
    }
    function getNewLoja($idLoja){
        $this->sql="
        SELECT * FROM lojas WHERE id_loja = :id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(":id",$idLoja,\PDO::PARAM_INT);
        if($db->execute()){
            $linha = $db->fetch(\PDO::FETCH_ASSOC);
            $_SESSION['lAtual'] = base64_decode($linha['razao_social']);
            $_SESSION['idAtual'] = $linha['id_loja'];
            $_SESSION['temp'] = $linha['validade'];
            $_SESSION['edit'] = true;
            $this->message = "Loja selecionada com sucesso!<br>";
            $this->link = "../";
            $success = new Success();
            $success->getSuccessMessage($this->message, $this->link);
        }
        else{
            $this->message = "Impossivel realizar operação!<br>";
            $this->link = "../change";
            $error = new Error();
            $error->getErroMessage($this->message, $this->link);
        }

    }
    function getProdutoLojas($idLoja){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM produtos_$idLoja
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)) {
            echo "
            <form class='form-horizontal' method='post' action='view/formUpdateProduto.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='" . $_SESSION['post'] . "'>
                <input type='hidden' name='id' value='" . htmlspecialchars($linha['id']) . "'>
                <input type='hidden' name='idCategoria' value='" . htmlspecialchars($linha['id_categoria']) . "'>
                <input type='hidden' name='nome' value='" . htmlspecialchars(base64_decode($linha['nome_produto'])) . "'>
                <input type='hidden' name='img1' value='" . htmlspecialchars($linha['img_1']) . "'>
                <input type='hidden' name='img2' value='" . htmlspecialchars($linha['img_2']) . "'>
                <input type='hidden' name='img3' value='" . htmlspecialchars($linha['img_3']) . "'>
                <input type='hidden' name='descricao' value='" . htmlspecialchars(base64_decode($linha['descricao'])) . "'>
                <input type='hidden' name='identificador' value='" . htmlspecialchars($linha['identificador']) . "'>
                <input type='hidden' name='peso' value='" . htmlspecialchars($linha['peso']) . "'>
                <input type='hidden' name='preco' value='" . htmlspecialchars($linha['preco']) . "'>
                <input type='hidden' name='quantidade' value='" . htmlspecialchars($linha['quantidade']) . "'>
                <input type='hidden' name='maximo' value='" . htmlspecialchars($linha['maximo']) . "'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>" . htmlspecialchars(base64_decode($linha['nome_produto'])) . "</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Editar</button>
                  </div>
                </div>

            </form>
            <hr>

            ";
        }
    }
    function getOptionCategoriaUpdate($idLoja,$id){
        $this->sql="
        SELECT * FROM categorias_$idLoja
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            if($id == $linha['id']) {
                echo "<option selected value=" . $linha['id'] . ">" . base64_decode($linha['nome_categoria']) . "</option>";
            }
            else{
                echo "<option value=" . $linha['id'] . ">" . base64_decode($linha['nome_categoria']) . "</option>";
            }
        }
    }
    function getImageFormUpdate($idLoja,$idProduto){
        $this->sql="
        SELECT * FROM produtos_$idLoja WHERE id = :id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(":id",$idProduto,\PDO::PARAM_INT);
        if($db->execute()){
            while($linha = $db->fetch(\PDO::FETCH_ASSOC)){
                $src[] = !empty($linha['img_1'])?"<br><img src='../../lojas/$idLoja/".$linha['img_1']."' class='img-thumbnail' width='304' height='236'>":"";
                $src[] = !empty($linha['img_2'])?"<br><img src='../../lojas/$idLoja/".$linha['img_2']."' class='img-thumbnail' width='304' height='236'>":"";
                $src[]= !empty($linha['img_3'])?"<br><img src='../../lojas/$idLoja/".$linha['img_3']."' class='img-thumbnail' width='304' height='236'>":"";
            }
        }
        return $src;
    }
    function getNewSales($loja){
        session_start();
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM pedidos_$loja WHERE status = 0
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        $_SESSION['news'] = $result->rowCount();
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)) {
            echo "
            <form class='form-horizontal' method='post' action='view/request.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='" . $_SESSION['post'] . "'>
                <input type='hidden' name='id' value='" . htmlspecialchars($linha['id']) . "'>
                <input type='hidden' name='pedido' value='" . htmlspecialchars($linha['pedido']) . "'>
                <input type='hidden' name='nome' value='" . htmlspecialchars($linha['nome']) . "'>
                <input type='hidden' name='celular' value='" . htmlspecialchars($linha['celular']) . "'>
                <input type='hidden' name='endereco' value='" . htmlspecialchars($linha['endereco']) . "'>
                <input type='hidden' name='status' value='" . htmlspecialchars($linha['status']) . "'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>" . htmlspecialchars($linha['nome']) . "</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Ver</button>
                  </div>
                </div>

            </form>
            <hr>

            ";
        }

    }
    function getOldSales($loja){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM pedidos_$loja WHERE status = 1
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
                <input type='hidden' name='nome' value='" . htmlspecialchars(base64_decode($linha['nome'])) . "'>
                <input type='hidden' name='celular' value='" . htmlspecialchars($linha['celular']) . "'>
                <input type='hidden' name='endereco' value='" . htmlspecialchars($linha['endereco']) . "'>
                <input type='hidden' name='status' value='" . htmlspecialchars($linha['status']) . "'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>" . htmlspecialchars(base64_decode($linha['nome'])) . "</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Ver</button>
                  </div>
                </div>

            </form>
            <hr>
            ";
        }
    }
    function getSearch($id,$query){
        session_start();
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM pedidos_$id WHERE identificador = :identificador;
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(":identificador",$query,\PDO::PARAM_STR);
        if($db->execute()){
            while( $linha = $db->fetch(\PDO::FETCH_ASSOC)) {
                echo "
            <form class='form-horizontal' method='post' action='view/request.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='" . $_SESSION['post'] . "'>
                <input type='hidden' name='id' value='" . htmlspecialchars($linha['id']) . "'>
                <input type='hidden' name='pedido' value='" . htmlspecialchars($linha['pedido']) . "'>
                <input type='hidden' name='nome' value='" . htmlspecialchars($linha['nome']) . "'>
                <input type='hidden' name='celular' value='" . htmlspecialchars($linha['celular']) . "'>
                <input type='hidden' name='endereco' value='" . htmlspecialchars($linha['endereco']) . "'>
                <input type='hidden' name='status' value='" . htmlspecialchars($linha['status']) . "'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>" . htmlspecialchars($linha['nome']) . "</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Ver</button>
                  </div>
                </div>

            </form>
            <hr>

            ";
            }
        }
    }
}
?>
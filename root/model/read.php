<?php
namespace Root;
require_once"connection.php";
require_once"error.php";

/**
 * Classe responsavel pela leitura do banco de dados.
 * Class Read
 * @package Root
 */
class Read{
    /**
     * @var $slq
     * Este atributo recebe as sql durante a execução, sendo que cada função gera uma sql diferente.
     */
    protected $sql;
    /**
     * @var $message
     * Este atributo recebe mensagens de sucesso ou erro durante a execução, apos receber essas mensagens, é passada
     * como parametro para a função responsavel em gerar a mensagem.
     */
    protected $message;
    /**
     * @var $link
     * Este atributo recebe link de redirecionamento durante a execução, após receber esse link, é passado
     * como parametro para a função responsavel por atribuir o link a pagina/mensagen correta.
     */
    protected $link;

    /**
     * Apresenta os dados da tabela admin
     */
    public function readTableAdmin(){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM admin
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            echo "
            <form class='form-horizontal' method='post' action='view/formUpdateAdmin.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='".$_SESSION['post']."'>
                <input type='hidden' name='id' value='".htmlspecialchars($linha['id_admin'])."'>
                <input type='hidden' name='nome' value='".htmlspecialchars(base64_decode($linha['nome_admin'])) ."'>
                <input type='hidden' name='email' value='".htmlspecialchars($linha['email']) ."'>
                <input type='hidden' name='senha' value='".htmlspecialchars($linha['senha']) ."'>
                <input type='hidden' name='celular' value='".htmlspecialchars($linha['celular']) ."'>

                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>".htmlspecialchars(base64_decode($linha['nome_admin']))."</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Editar</button>
                  </div>
                </div>


            </form>
            <hr>

            ";
        }


    }

    /**
     * Apresenta os dados da tabela categoria.
     */
    public function readTableCategoria(){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM categorias
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            echo "
            <form class='form-horizontal' method='post' action='view/formUpdateCategoria.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='".$_SESSION['post']."'>
                <input type='hidden' name='id' value='".htmlspecialchars($linha['id_categoria']) ."'>
                <input type='hidden' name='nome' value='".htmlspecialchars(base64_decode($linha['nome_categoria'])) ."'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>".htmlspecialchars(base64_decode($linha['nome_categoria']))."</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Editar</button>
                  </div>
                </div>

            </form>
            <hr>

            ";
        }

    }

    /**
     * Apresenta os dados da tabela cliente.
     */
    public function readTableCliente(){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM clientes
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            echo "
            <form class='form-horizontal' method='post' action='view/formUpdateCliente.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='".$_SESSION['post']."'>
                <input type='hidden' name='id' value='".htmlspecialchars($linha['id_cliente']) ."'>
                <input type='hidden' name='nome' value='".htmlspecialchars(base64_decode($linha['nome'])) ."'>
                <input type='hidden' name='email' value='".htmlspecialchars($linha['email']) ."'>
                <input type='hidden' name='senha' value='".htmlspecialchars($linha['senha']) ."'>
                <input type='hidden' name='celular' value='".htmlspecialchars($linha['celular']) ."'>
                <input type='hidden' name='cnpj' value='".htmlspecialchars($linha['cnpj']) ."'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>".htmlspecialchars(base64_decode($linha['nome']))."</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Editar</button>
                  </div>
                </div>

            </form>
            <hr>

            ";
        }

    }

    /**
     * Apresentaos dados da tabela lojas
     */
    public function readTableLoja(){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM lojas
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            echo "
            <form class='form-horizontal' method='post' action='view/formUpdateLojas.php'>
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='".$_SESSION['post']."'>
                <input type='hidden' name='id_loja' value='".htmlspecialchars($linha['id_loja'])."'>
                <input type='hidden' name='id_categoria' value='".htmlspecialchars($linha['id_categoria'])."'>
                <input type='hidden' name='id_dono' value='".htmlspecialchars($linha['id_dono'])."'>
                <input type='hidden' name='razao' value='".htmlspecialchars(base64_decode($linha['razao_social']))."'>
                <input type='hidden' name='fantasia' value='".htmlspecialchars(base64_decode($linha['nome_fantasia']))."'>
                <input type='hidden' name='inscricao' value='".htmlspecialchars($linha['inscricao_estadual'])."'>
                <input type='hidden' name='isento' value='".htmlspecialchars($linha['isento'])."'>
                <input type='hidden' name='optante' value='".htmlspecialchars($linha['optante_pelo_simples'])."'>
                <input type='hidden' name='status' value='".htmlspecialchars($linha['status'])."'>
                <input type='hidden' name='inicio' value='".htmlspecialchars($linha['inicio'])."'>
                <input type='hidden' name='fim' value='".htmlspecialchars($linha['fim'])."'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>".htmlspecialchars(base64_decode($linha['razao_social']))."</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Editar</button>
                  </div>
                </div>

            </form>
            <hr>

            ";
        }
    }

    /**
     * Apresena os dados da tabela usuarios
     */
    public function readTableUsuario(){
        $_SESSION["post"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
        $this->sql="
        SELECT * FROM usuarios
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            echo "
            <form class='form-horizontal' method='post' action='view/formUpdateUsuarios.php' >
                <!-- Form Name -->
                <!-- Button (Double) -->
                <input type='hidden' name='post' value='".$_SESSION['post']."'>
                <input type='hidden' name='id' value='".htmlspecialchars($linha['id_usuario'])."'>
                <input type='hidden' name='nome' value='".htmlspecialchars(base64_decode($linha['nome_usuario']))."'>
                <input type='hidden' name='email' value='".htmlspecialchars($linha['email'])."'>
                <input type='hidden' name='senha' value='".htmlspecialchars($linha['senha'])."'>
                <input type='hidden' name='celular' value='".htmlspecialchars($linha['celular'])."'>
                <div class='form-group'>
                  <label class='col-md-4 control-label' for='button1id'>".htmlspecialchars(base64_decode($linha['nome_usuario']))."</label>
                  <div class='col-md-8'>
                    <button id='button1id' name='button1id' class='btn btn-info'>Editar</button>
                  </div>
                </div>

            </form>
            <hr>

            ";
        }
    }

    /**
     * Realiza o login de um usuario
     * @param string $email Recebe o email do admin
     * @param string $senha Recebe a senha do admin
     */
    function getLoginAdmin($email,$senha){
        $this->sql="
        SELECT * FROM admin WHERE email = :email
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
                    $_SESSION["login"] = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
                    $_SESSION['id']= $linha['id_admin'];
                    $_SESSION['nome'] = base64_decode($linha['nome_admin']);
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
    function readOptionCategoria(){
        $this->sql="
        SELECT * FROM categorias
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            echo"<option value=".$linha['id_categoria'].">".base64_decode($linha['nome_categoria'])."</option>";
        }

    }
    function readOptionCliente(){
        $this->sql="
        SELECT * FROM clientes
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            echo"<option value=".$linha['id_cliente'].">".base64_decode($linha['nome'])."</option>";
        }
    }
    function readOptionCategoriaUpdate($id){
        $this->sql="
        SELECT * FROM categorias
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            if($id == $linha['id_categoria']) {
                echo "<option selected value=" . $linha['id_categoria'] . ">" . base64_decode($linha['nome_categoria']) . "</option>";
            }
            else{
                echo "<option value=" . $linha['id_categoria'] . ">" . base64_decode($linha['nome_categoria']) . "</option>";
            }
        }
    }
    function readOptionClienteUpdade($id){
        $this->sql="
        SELECT * FROM clientes
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->query($this->sql);
        while( $linha = $result->fetch(\PDO::FETCH_ASSOC)){
            if($id == $linha['id_cliente']) {
                echo "<option selected value=" . $linha['id_cliente'] . ">" . base64_decode($linha['nome']) . "</option>";
            }
            else{
                echo "<option value=" . $linha['id_cliente'] . ">" . base64_decode($linha['nome']) . "</option>";
            }
        }
    }
    function readOptionStatusUpdate($status){
            if($status == 1) {
                echo "<option selected value='1'>Online</option>
                      <option value='0'>Offline</option>
                 ";
            }
            else{
                echo "<option value='1'>Online</option>
                      <option selected value='0'>Offline</option>";
            }

    }
    function readHoursOptions(){
        for($n = 0; $n <= 23; $n++){
            echo"<option value='$n'>$n:00:00</option>";
        }
    }
    function readHoursOptionsUpdate($atual){
        for($n = 0; $n <= 23; $n++){
            if($atual == $n){
            echo"<option selected value='$n'>$n:00:00</option>";
            }
            else{
                echo"<option value='$n'>$n:00:00</option>";
            }
        }
    }

    /**
     * Desalocar informações da memoria geradas durante a execução.
     */
    function __destruct(){

    }

}

?>
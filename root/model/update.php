<?php
namespace Root;
require_once"connection.php";
require_once"validationInput.php";
require_once"success.php";
require_once"error.php";
require_once"crypt.php";

/** Esta classe e responsavel por atualizar as informações do banco de dados.
 * Class Update
 * @package Root
 */
class Update{
    /**
     * @var $slq
     * Este atributo recebe as sql durante a execução, sendo que cada função gera uma sql diferente.
     */
    protected $sql;
    /**
     * @var $email
     * Este atributo recebe true ou false conforme os dados forem avaliados pelas expressões regulares.
     */
    protected $email;
    /**
     * @var $celular
     * Este atributo recebe true ou false conforme os dados forem avaliados pelas expressões regulares.
     */
    protected $celular;
    /**
     * @var $cpf
     * Este atributo recebe true ou false conforme os dados forem avaliados pelas expressões regulares.
     */
    protected $cpf;
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
     * Esta função e responsavel por atualizar informações da tabela admin.
     *
     * @param int $id Recebe a id do administrador
     * @param string $nome_admin Recebe o nome do administrador.
     * @param string $email Recebe a email do administrador.
     * @param string $senha Recebe a senha do administrador.
     * @param string $celular Recebe o celular do administrador.
     */
    public function updateTableAdmin($id,$nome_admin,$email,$senha,$celular)
    {
        $validate = new Validation();
        $this->email = $validate->filterEmail($email);
        $this->celular = $validate->filteCelular($celular);
        /**
         * Confere se os dados inseridos são validos.
         */
        if ($this->celular && $this->email) {
            $this->sql = "
            SELECT * FROM admin WHERE id_admin = :id
            ";
            $con = new Connection();
            $read = $con->connection();
            $result = $read->prepare($this->sql);
            $result->bindValue(':id', $id, \PDO::PARAM_INT);
            $result->execute();
            $count  = $result->rowCount();
            $linha = $result->fetch(\PDO::FETCH_ASSOC);
            /**
             * Confere se retornou apena 1 resultado
             */
            if($count == 1){
                /**
                 * Confere se o email não foi alterado
                 */
                if ($linha['email'] == $email) {
                    /**
                     * Confere se a senha não foi alterada
                     */
                    if ($linha['senha'] === $senha) {
                        $this->sql = "
                        UPDATE admin SET
                        nome_admin = :nome,
                        celular = :celular
                        WHERE id_admin = :id
                        ";
                        $con = new Connection();
                        $obj = $con->connection();
                        $db = $obj->prepare($this->sql);
                        $nome_admin = base64_encode($nome_admin);
                        $db->bindValue(':nome', $nome_admin, \PDO::PARAM_STR);
                        $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                        $db->bindValue(':id', $id, \PDO::PARAM_STR);
                        /**
                         * Confere se houve exito executar a slq, se sim, mostre mensagem de sucesso na tela.
                         */
                        if ($db->execute()) {
                            $this->message = "Dados do Administrador atualizado com sucesso!<br>";
                            $this->link = "../admin";
                            $success = new Success();
                            $success->getSuccessMessage($this->message, $this->link);
                        } /**
                         * Caso houver erro, deve ser mostrado uma mensagem de erro na tela.
                         */
                        else {
                            $this->message = "Impossivel realizar operação!<br>";
                            $this->link = "../admin";
                            $error = new Error();
                            $error->getErroMessage($this->message, $this->link);
                        }

                    } /**
                     * Se a senha inserida for diferente da armazenada, execute o script a seguir
                     */
                    else {
                        $crypt = new Crypt();
                        $this->sql = "
                        UPDATE admin SET
                        nome_admin = :nome,
                        senha = :senha,
                        celular = :celular
                        WHERE id_admin = :id
                        ";
                        $con = new Connection();
                        $obj = $con->connection();
                        $db = $obj->prepare($this->sql);
                        $nome_admin = base64_encode($nome_admin);
                        $db->bindValue(':nome', $nome_admin, \PDO::PARAM_STR);
                        $senha = $crypt->hashValue($senha);
                        $db->bindValue(':senha', $senha, \PDO::PARAM_STR);
                        $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                        $db->bindValue(':id', $id, \PDO::PARAM_STR);
                        /**
                         * Confere se houve exito executar a slq, se sim, mostre mensagem de sucesso na tela.
                         */
                        if ($db->execute()) {
                            $this->message = "Dados do administrador realizado com sucesso!<br>";
                            $this->link = "../admin";
                            $success = new Success();
                            $success->getSuccessMessage($this->message, $this->link);
                        }
                        /**
                         * Caso houver erro, deve ser mostrado uma mensagem de erro na tela.
                         */
                        else {
                            $this->message = "Impossivel realizar operação!<br>";
                            $this->link = "../admin";
                            $error = new Error();
                            $error->getErroMessage($this->message, $this->link);
                        }
                    }
                }
                /**
                 * Se o email inserido for diferente do armazenado, deve ser feito uma consulta ao banco de dados,
                 * pois o novo endereço não deve estar registrado.
                 */
                else{
                    $this->sql = "
                    SELECT * FROM admin WHERE email = :email
                    ";
                    $con = new Connection();
                    $read = $con->connection();
                    $result = $read->prepare($this->sql);
                    $result->bindValue(':email', $email, \PDO::PARAM_STR);
                    $result->execute();
                    $count = $result->rowCount();
                    /**
                     * Confere se o email não esta registrado.
                     */
                    if($count == 0){
                        /**
                         * Confere se senha não foi alterada
                         */
                        if ($linha['senha'] === $senha) {
                            $this->sql = "
                            UPDATE admin SET
                            nome_admin = :nome,
                            email = :email,
                            celular = :celular
                            WHERE id_admin = :id
                            ";
                            $con = new Connection();
                            $obj = $con->connection();
                            $db = $obj->prepare($this->sql);
                            $nome_admin = base64_encode($nome_admin);
                            $db->bindValue(':nome', $nome_admin, \PDO::PARAM_STR);
                            $db->bindValue(':email',$email,\PDO::PARAM_STR);
                            $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                            $db->bindValue(':id', $id, \PDO::PARAM_STR);
                            /**
                             * Confere se houve exito executar a slq, se sim, mostre mensagem de sucesso na tela.
                             */
                            if ($db->execute()) {
                                $this->message = "Dados do Administrador atualizado com sucesso!<br>";
                                $this->link = "../admin";
                                $success = new Success();
                                $success->getSuccessMessage($this->message, $this->link);
                            }
                            /**
                             * Caso houver erro, deve ser mostrado uma mensagem de erro na tela.
                             */
                            else {
                                $this->message = "Impossivel realizar operação!<br>";
                                $this->link = "../admin";
                                $error = new Error();
                                $error->getErroMessage($this->message, $this->link);
                            }

                        }
                        /**
                         * Se a senha inserida for diferente da armazenada, execute o script a seguir
                         */
                        else {
                            $crypt = new Crypt();
                            $this->sql = "
                            UPDATE admin SET
                            nome_admin = :nome,
                            email = :email,
                            senha = :senha,
                            celular = :celular
                            WHERE id_admin = :id
                            ";
                            $con = new Connection();
                            $obj = $con->connection();
                            $db = $obj->prepare($this->sql);
                            $nome_admin = base64_encode($nome_admin);
                            $db->bindValue(':nome', $nome_admin, \PDO::PARAM_STR);
                            $db->bindValue(':email',$email,\PDO::PARAM_STR);
                            $senha = $crypt->hashValue($senha);
                            $db->bindValue(':senha', $senha, \PDO::PARAM_STR);
                            $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                            $db->bindValue(':id', $id, \PDO::PARAM_STR);
                            /**
                             * Confere se houve exito executar a slq, se sim, mostre mensagem de sucesso na tela.
                             */
                            if ($db->execute()) {
                                $this->message = "Dados do administrado atualizado com sucesso!<br>";
                                $this->link = "../admin";
                                $success = new Success();
                                $success->getSuccessMessage($this->message, $this->link);
                            }
                            /**
                             * Caso houver erro, deve ser mostrado uma mensagem de erro na tela.
                             */
                            else {
                                $this->message = "Impossivel realizar operação!<br>";
                                $this->link = "../admin";
                                $error = new Error();
                                $error->getErroMessage($this->message, $this->link);
                            }
                        }

                    }
                    /**
                     * Se o email é diferente do atual, e esta registrado, ele pertence a outro usuario
                     * sendo assim deve ser mostrado uma mensagem de erro
                     */
                    else{
                        $this->message="Endereço de email ja pertence a outro usuario!<br>";
                        $this->link = "../admin";
                        $error = new Error();
                        $error->getErroMessage($this->message,$this->link);
                    }
                }
            }
            /**
             * Caso retorne 0 ou mais de 1 resultado
             */
            else{
                $this->message = "Impossivel realizar operação, dados invalidos!<br>";
                $this->link = "../admin";
                $error = new Error();
                $error->getErroMessage($this->message, $this->link);

            }

        }
        /**
         * Caso os dados inseridos não forem validos, deve ser mostrado uma mensagem de erro.
         */
        else {
            $this->message = "
                Um ou mais dos itens seguintes não atende aos padrões requisitados!<br>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <ul>
                                <li>
                                    Email.
                                </li>
                                <li>
                                    Celular.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                ";
            $this->link = "../admin";
            $error = new Error();
            $error->getErroMessage($this->message, $this->link);
        }
    }

    /**
     * Função responsavel por atualizar informações da tabela categoria
     * @param int $id Recebe ID
     * @param string $nome_categoria Recebe Nome da Categoria
     */
    public function updateTableCategoria($id, $nome_categoria){
        $nome_categoria = base64_encode($nome_categoria);
        $this->sql =
            "
        SELECT * FROM categorias WHERE id_categoria = :id
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->prepare($this->sql);
        $result->bindValue(':id', $id, \PDO::PARAM_INT);
        $result->execute();
        $count = $result->rowCount();
        $linha = $result->fetch(\PDO::FETCH_ASSOC);
        if($count == 1){
            /**
             * Confere se a categoria não foi alterada
             */
            if ($linha['nome_categoria'] == $nome_categoria) {
                $this->sql="
                UPDATE categorias SET
                nome_categoria = :nome
                WHERE id_categoria = :id
                ";
                $con = new Connection();
                $obj = $con->connection();
                $db = $obj->prepare($this->sql);
                $db->bindValue(':nome',$nome_categoria,\PDO::PARAM_STR);
                $db->bindValue(':id',$id,\PDO::PARAM_INT);
                if ($db->execute()) {
                    $this->message="Dados do Categoria atualizado com sucesso!<br>";
                    $this->link = "../categoria";
                    $success = new Success();
                    $success->getSuccessMessage($this->message, $this->link);
                }
                else{
                    $this->message="Impossivel realizar operação!<br>";
                    $this->link = "../categoria";
                    $error = new Error();
                    $error->getErroMessage($this->message,$this->link);
                }
            }
            else{
                $this->sql =
                    "
                SELECT * FROM categorias WHERE nome_categoria = :nome
                ";
                $con = new Connection();
                $read = $con->connection();
                $result = $read->prepare($this->sql);
                $result->bindValue(':nome', $nome_categoria, \PDO::PARAM_STR);
                $result->execute();
                $count = $result->rowCount();
                if($count == 0){
                    $this->sql="
                    UPDATE categorias SET
                    nome_categoria = :nome
                    WHERE id_categoria = :id
                    ";
                    $con = new Connection();
                    $obj = $con->connection();
                    $db = $obj->prepare($this->sql);
                    $db->bindValue(':nome',$nome_categoria,\PDO::PARAM_STR);
                    $db->bindValue(':id',$id,\PDO::PARAM_INT);
                    if ($db->execute()) {
                        $this->message="Dados do Categoria atualizado com sucesso!<br>";
                        $this->link = "../categoria";
                        $success = new Success();
                        $success->getSuccessMessage($this->message, $this->link);
                    }
                    else{
                        $this->message="Impossivel realizar operação!<br>";
                        $this->link = "../categoria";
                        $error = new Error();
                        $error->getErroMessage($this->message,$this->link);
                    }
                }
                else{
                    $this->message="Esta categoria ja existe!<br>";
                    $this->link = "../categoria";
                    $error = new Error();
                    $error->getErroMessage($this->message,$this->link);
                }
            }
        }
        else{
            $this->message="Impossivel realizar operação, dados invalidos!<br>";
            $this->link = "../categoria";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }

    }
    public function updateTableCliente($id_cliente,$nome,$email,$senha,$celular,$cnpj){
        $validate = new Validation();
        $this->email = $validate->filterEmail($email);
        $this->celular = $validate->filteCelular($celular);
        $this->cpf = $validate->filterCpfCnpj($cnpj);
        /**
         * Confere se os dados são validos
         */
        $nome = base64_encode($nome);
        if ($this->celular && $this->email && $this->cpf) {
            $this->sql = "
                SELECT * FROM clientes WHERE id_cliente = :id
                ";
            $con = new Connection();
            $read = $con->connection();
            $result = $read->prepare($this->sql);
            $result->bindValue(':id', $id_cliente, \PDO::PARAM_INT);
            $result->execute();
            $count = $result->rowCount();
            $linha = $result->fetch(\PDO::FETCH_ASSOC);
            /**
             * Confere se retornou apenas 1 resultado
             */
            if($count == 1){
                /**
                 * Confere se o email não foi alterado.
                 */
                if($linha['email'] == $email){
                    /**
                     * Confere se a senha não foi alterada
                     */
                    if ($linha['senha'] === $senha) {
                        $this->sql = "
                        UPDATE clientes SET
                        nome = :nome,
                        celular = :celular,
                        cnpj = :cnpj
                        WHERE id_cliente = :id
                        ";
                        $con = new Connection();
                        $obj = $con->connection();
                        $db = $obj->prepare($this->sql);
                        $db->bindValue(':nome', $nome, \PDO::PARAM_STR);
                        $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                        $db->bindValue(':cnpj', $cnpj, \PDO::PARAM_STR);
                        $db->bindValue(':id', $id_cliente, \PDO::PARAM_INT);
                        if ($db->execute()) {
                            $this->message="Dados do Cliente atualizado com sucesso!<br>";
                            $this->link = "../clientes";
                            $success = new Success();
                            $success->getSuccessMessage($this->message, $this->link);
                        }
                        else{
                            $this->message="Impossivel realizar operação!<br>";
                            $this->link = "../clientes";
                            $error = new Error();
                            $error->getErroMessage($this->message,$this->link);
                        }

                    }
                    /**
                     * Caso a nova senha seja diferente, deve ser criptografada.
                     */
                    else {
                        $crypt = new Crypt();
                        $this->sql = "
                    UPDATE clientes SET
                    nome = :nome,
                    senha = :senha,
                    celular = :celular,
                    cnpj = :cnpj
                    WHERE id_cliente = :id
                    ";
                        $con = new Connection();
                        $obj = $con->connection();
                        $db = $obj->prepare($this->sql);
                        $db->bindValue(':nome', $nome, \PDO::PARAM_STR);
                        $senha = $crypt->hashValue($senha);
                        $db->bindValue(':senha', $senha, \PDO::PARAM_STR);
                        $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                        $db->bindValue(':cnpj', $cnpj, \PDO::PARAM_STR);
                        $db->bindValue(':id', $id_cliente, \PDO::PARAM_INT);
                        if ($db->execute()) {
                            $this->message="Dados do Cliente atualizado com sucesso !<br>";
                            $this->link = "../clientes";
                            $success = new Success();
                            $success->getSuccessMessage($this->message, $this->link);
                        }
                        else{
                            $this->message="Impossivel realizar operação!<br>";
                            $this->link = "../clientes";
                            $error = new Error();
                            $error->getErroMessage($this->message,$this->link);
                        }
                    }
                }
                /**
                 * Caso o email inserido for diferente do atual, deve conferir se ele esta disponivel.
                 */
                else{
                    $this->sql = "
                    SELECT * FROM clientes WHERE email = :email
                    ";
                    $con = new Connection();
                    $read = $con->connection();
                    $result = $read->prepare($this->sql);
                    $result->bindValue(':email', $email, \PDO::PARAM_STR);
                    $result->execute();
                    $count = $result->rowCount();
                    $linha = $result->fetch(\PDO::FETCH_ASSOC);
                    /**
                     * Confere se o email esta disponivel
                     */
                    if($count == 0) {
                        /**
                         * Confere se a senha não foi alterada
                         */
                        if ($linha['senha'] === $senha) {
                            $this->sql = "
                            UPDATE clientes SET
                            nome = :nome,
                            email = :email,
                            celular = :celular,
                            cnpj = :cnpj
                            WHERE id_cliente = :id
                            ";
                            $con = new Connection();
                            $obj = $con->connection();
                            $db = $obj->prepare($this->sql);
                            $db->bindValue(':nome', $nome, \PDO::PARAM_STR);
                            $db->bindValue(':email', $email, \PDO::PARAM_STR);
                            $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                            $db->bindValue(':cnpj', $cnpj, \PDO::PARAM_STR);
                            $db->bindValue(':id', $id_cliente, \PDO::PARAM_INT);
                            if ($db->execute()) {
                                $this->message = "Dados do Cliente atualizado com sucesso!<br>";
                                $this->link = "../clientes";
                                $success = new Success();
                                $success->getSuccessMessage($this->message, $this->link);
                            } else {
                                $this->message = "Impossivel realizar operação!<br>";
                                $this->link = "../clientes";
                                $error = new Error();
                                $error->getErroMessage($this->message, $this->link);
                            }

                        }
                        /**
                         * Cso a senha for diferente, a mesma deve ser criptografada
                         */
                        else {
                            $crypt = new Crypt();
                            $this->sql = "
                            UPDATE clientes SET
                            nome = :nome,
                            email = :email,
                            senha = :senha,
                            celular = :celular,
                            cnpj = :cnpj
                            WHERE id_cliente = :id
                            ";
                            $con = new Connection();
                            $obj = $con->connection();
                            $db = $obj->prepare($this->sql);
                            $db->bindValue(':nome', $nome, \PDO::PARAM_STR);
                            $db->bindValue(':email', $email, \PDO::PARAM_STR);
                            $senha = $crypt->hashValue($senha);
                            $db->bindValue(':senha', $senha, \PDO::PARAM_STR);
                            $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                            $db->bindValue(':cnpj', $cnpj, \PDO::PARAM_STR);
                            $db->bindValue(':id', $id_cliente, \PDO::PARAM_INT);
                            if ($db->execute()) {
                                $this->message = "Dados do Cliente atualizado com sucesso !<br>";
                                $this->link = "../clientes";
                                $success = new Success();
                                $success->getSuccessMessage($this->message, $this->link);
                            } else {
                                $this->message = "Impossivel realizar operação!<br>";
                                $this->link = "../clientes";
                                $error = new Error();
                                $error->getErroMessage($this->message, $this->link);
                            }
                        }
                    }
                    else{
                        $this->message="Email ja esta sendo usado por outro usuario!<br>";
                        $this->link = "../clientes";
                        $error = new Error();
                        $error->getErroMessage($this->message,$this->link);
                    }
                }
            }
            /**
             * Se retornar 0 ou mais de 1 resultado, deve ser mostrado uma mensagem de erro.
             */
            else{
                $this->message="Impossivel realizar operação, dados invalidos!<br>";
                $this->link = "../clientes";
                $error = new Error();
                $error->getErroMessage($this->message,$this->link);
            }

        } /**
         * Caso os dados forem invalidos, deve ser mostrada uma mensagem de erro.
         */
        else{
            $this->message="
                Um ou mais dos itens seguintes não atende aos padrões requisitados!<br>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <ul>
                                <li>
                                    Email.
                                </li>
                                <li>
                                    Celular.
                                </li>
                                <li>
                                    CNPJ.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                ";
            $this->link = "../clientes";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }


    }
    public function updateTableLojas($id_loja,$id_categoria,$id_dono,$razao_social,$nome_fantasia,$inscricao_estadual,$isento,$optante_pelo_simples,$status,$inicio,$fim){
        $razao_social = base64_encode($razao_social);
        $nome_fantasia = base64_encode($nome_fantasia);
        $this->sql="
        SELECT * FROM lojas WHERE id_loja = :id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':id',$id_loja,\PDO::PARAM_STR);
        $db->execute();
        $linha = $db->fetch(\PDO::FETCH_ASSOC);
        $count = $db->rowCount();
        /**
         * Confere se o id existe.
         */
        if($count == 1) {
            /**
             * Confere se o a razão não foi alterada
             */
            if($linha['razao_social'] == $razao_social){
                $this->sql = "
                UPDATE lojas SET
                id_categoria = :id_categoria,
                id_dono = :id_dono,
                razao_social = :razao,
                nome_fantasia = :fantasia,
                inscricao_estadual = :inscricao,
                isento = :isento,
                optante_pelo_simples = :optante,
                status = :status,
                inicio = :inicio,
                fim = :fim
                WHERE id_loja = :id_loja
                ";
                $con = new Connection();
                $obj = $con->connection();
                $db = $obj->prepare($this->sql);
                $db->bindValue(':id_categoria', $id_categoria, \PDO::PARAM_INT);
                $db->bindValue(':id_dono', $id_dono, \PDO::PARAM_INT);
                $db->bindValue(':razao', $razao_social, \PDO::PARAM_STR);
                $db->bindValue(':fantasia', $nome_fantasia, \PDO::PARAM_STR);
                $db->bindValue(':inscricao', $inscricao_estadual, \PDO::PARAM_STR);
                $db->bindValue(':isento', $isento, \PDO::PARAM_STR);
                $db->bindValue(':optante', $optante_pelo_simples, \PDO::PARAM_STR);
                $db->bindValue(':id_loja', $id_loja, \PDO::PARAM_INT);
                $db->bindValue(':status', $status, \PDO::PARAM_INT);
                $db->bindValue(':inicio', $inicio, \PDO::PARAM_STR);
                $db->bindValue(':fim', $fim, \PDO::PARAM_STR);
                if($db->execute()){
                    $this->message="Dados da Loja atualizado com sucesso!<br>";
                    $this->link = "../lojas";
                    $success = new Success();
                    $success->getSuccessMessage($this->message, $this->link);
                }
                else{
                    $this->message="Impossivel realizar operação!<br>";
                    $this->link = "../lojas";
                    $error = new Error();
                    $error->getErroMessage($this->message,$this->link);
                }
            }
            /**
             * Caso a razão foi anterada, confira se esta disponivel
             */
            else{
                $this->sql="
                SELECT * FROM lojas WHERE razao_social = :razao
                ";
                $con = new Connection();
                $obj = $con->connection();
                $db = $obj->prepare($this->sql);
                $db->bindValue(':razao',$razao_social,\PDO::PARAM_STR);
                $db->execute();
                $count = $db->rowCount();
                if($count == 0) {
                    $this->sql = "
                    UPDATE lojas SET
                    id_categoria = :id_categoria,
                    id_dono = :id_dono,
                    razao_social = :razao,
                    nome_fantasia = :fantasia,
                    inscricao_estadual = :inscricao,
                    isento = :isento,
                    optante_pelo_simples = :optante,
                    status = :status,
                    inicio = :inicio,
                    fim = :fim
                    WHERE id_loja = :id_loja
                    ";
                    $con = new Connection();
                    $obj = $con->connection();
                    $db = $obj->prepare($this->sql);
                    $db->bindValue(':id_categoria', $id_categoria, \PDO::PARAM_INT);
                    $db->bindValue(':id_dono', $id_dono, \PDO::PARAM_INT);
                    $db->bindValue(':razao', $razao_social, \PDO::PARAM_STR);
                    $db->bindValue(':fantasia', $nome_fantasia, \PDO::PARAM_STR);
                    $db->bindValue(':inscricao', $inscricao_estadual, \PDO::PARAM_STR);
                    $db->bindValue(':isento', $isento, \PDO::PARAM_STR);
                    $db->bindValue(':optante', $optante_pelo_simples, \PDO::PARAM_STR);
                    $db->bindValue(':id_loja', $id_loja, \PDO::PARAM_INT);
                    $db->bindValue(':status', $status, \PDO::PARAM_INT);
                    $db->bindValue(':inicio', $inicio, \PDO::PARAM_STR);
                    $db->bindValue(':fim', $fim, \PDO::PARAM_STR);
                    if ($db->execute()) {
                        $this->message = "Dados da Loja atualizado com sucesso!<br>";
                        $this->link = "../lojas";
                        $success = new Success();
                        $success->getSuccessMessage($this->message, $this->link);
                    } else {
                        $this->message = "Impossivel realizar operação!<br>";
                        $this->link = "../lojas";
                        $error = new Error();
                        $error->getErroMessage($this->message, $this->link);
                    }
                }
                else{
                    $this->message = "Esta razão social pertence a outro usuario!<br>";
                    $this->link = "../lojas";
                    $error = new Error();
                    $error->getErroMessage($this->message, $this->link);
                }
            }
        }
        /**
         * caso o id não exista, ou tenha mais de 1.
         */
        else{
            $this->message="Impossivel realizar operação, dados invalidos!<br>";
            $this->link="../lojas";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);

        }

    }
    public function updateTableUsuarios($id_usuario, $nome_usuario, $email, $senha, $celular)
    {
        $nome_usuario = base64_encode($nome_usuario);
        $validate = new Validation();
        $this->email = $validate->filterEmail($email);
        $this->celular = $validate->filteCelular($celular);
        /**
         * Confere se os dados são validos.
         */
        if ($this->celular && $this->email) {
            $this->sql = "
            SELECT * FROM usuarios WHERE id_usuario = :id
            ";
            $con = new Connection();
            $read = $con->connection();
            $result = $read->prepare($this->sql);
            $result->bindValue(':id', $id_usuario, \PDO::PARAM_INT);
            $result->execute();
            $count = $result->rowCount();
            $linha = $result->fetch(\PDO::FETCH_ASSOC);
            /**
             * Confere se o id e valido.
             */
            if($count == 1) {
                /**
                 * Confere se o email não foi alterado
                 */
                if($linha['email'] == $email) {
                    /**
                     * Confere se a senha não foi alterada
                     */
                    if ($linha['senha'] === $senha) {
                        $this->sql = "
                        UPDATE usuarios SET
                        nome_usuario = :nome,
                        email = :email,
                        celular = :celular
                        WHERE id_usuario = :id
                        ";
                        $con = new Connection();
                        $obj = $con->connection();
                        $db = $obj->prepare($this->sql);
                        $db->bindValue(':nome', $nome_usuario, \PDO::PARAM_STR);
                        $db->bindValue(':email', $email, \PDO::PARAM_STR);
                        $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                        $db->bindValue(':id', $id_usuario, \PDO::PARAM_INT);
                        if ($db->execute()) {
                            $this->message = "Dados do usuario atualizado com sucesso!<br>";
                            $this->link = "../usuarios";
                            $success = new Success();
                            $success->getSuccessMessage($this->message, $this->link);
                            return true;
                        } else {
                            $this->message = "Impossivel realizar operação!<br>";
                            $this->link = "../usuarios";
                            $error = new Error();
                            $error->getErroMessage($this->message, $this->link);
                        }
                    }
                    /**
                     * Se a senha foi alterada, a mesma deve ser criptograda.
                     */
                    else {
                        $crypt = new Crypt();
                        $this->sql = "
                        UPDATE usuarios SET
                        nome_usuario = :nome,
                        email = :email,
                        senha = :senha,
                        celular = :celular
                        WHERE id_usuario = :id
                        ";
                        $con = new Connection();
                        $obj = $con->connection();
                        $db = $obj->prepare($this->sql);
                        $db->bindValue(':nome', $nome_usuario, \PDO::PARAM_STR);
                        $db->bindValue(':email', $email, \PDO::PARAM_STR);
                        $senha = $crypt->hashValue($senha);
                        $db->bindValue(':senha', $senha, \PDO::PARAM_STR);
                        $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                        $db->bindValue(':id', $id_usuario, \PDO::PARAM_INT);
                        if ($db->execute()) {
                            $this->message = "Dados do usuario atualizado com sucesso!<br>";
                            $this->link = "../usuarios";
                            $success = new Success();
                            $success->getSuccessMessage($this->message, $this->link);
                            return true;
                        } else {
                            $this->message = "Impossivel realizar operação!<br>";
                            $this->link = "../usuarios";
                            $error = new Error();
                            $error->getErroMessage($this->message, $this->link);
                        }
                    }
                }
                /**
                 * Se o email, foi alterado confira se ele esta disponivel.
                 */
                else{
                    $this->sql = "
                    SELECT * FROM usuarios WHERE email = :email
                    ";
                    $con = new Connection();
                    $read = $con->connection();
                    $result = $read->prepare($this->sql);
                    $result->bindValue(':email', $email, \PDO::PARAM_STR);
                    $result->execute();
                    $count = $result->rowCount();
                    $linha = $result->fetch(\PDO::FETCH_ASSOC);
                    /**
                     * Confere se esta disponivel
                     */
                    if($count == 0) {
                        /**
                         * Confere se a senha não foi alterada
                         */
                        if ($linha['senha'] === $senha)
                        {
                            $this->sql = "
                            UPDATE usuarios SET
                            nome_usuario = :nome,
                            email = :email,
                            celular = :celular
                            WHERE id_usuario = :id
                            ";
                            $con = new Connection();
                            $obj = $con->connection();
                            $db = $obj->prepare($this->sql);
                            $db->bindValue(':nome', $nome_usuario, \PDO::PARAM_STR);
                            $db->bindValue(':email', $email, \PDO::PARAM_STR);
                            $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                            $db->bindValue(':id', $id_usuario, \PDO::PARAM_INT);
                            if ($db->execute()) {
                                $this->message = "Dados do usuario atualizado com sucesso!<br>";
                                $this->link = "../usuarios";
                                $success = new Success();
                                $success->getSuccessMessage($this->message, $this->link);
                                return true;
                            } else {
                                $this->message = "Impossivel realizar operação!<br>";
                                $this->link = "../usuarios";
                                $error = new Error();
                                $error->getErroMessage($this->message, $this->link);
                            }
                        } /**
                         * Se a senha foi alterada, ela deve ser criptografada.
                         */
                        else {
                            $crypt = new Crypt();
                            $this->sql = "
                            UPDATE usuarios SET
                            nome_usuario = :nome,
                            email = :email,
                            senha = :senha,
                            celular = :celular
                            WHERE id_usuario = :id
                            ";
                            $con = new Connection();
                            $obj = $con->connection();
                            $db = $obj->prepare($this->sql);
                            $db->bindValue(':nome', $nome_usuario, \PDO::PARAM_STR);
                            $db->bindValue(':email', $email, \PDO::PARAM_STR);
                            $senha = $crypt->hashValue($senha);
                            $db->bindValue(':senha', $senha, \PDO::PARAM_STR);
                            $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                            $db->bindValue(':id', $id_usuario, \PDO::PARAM_INT);
                            if ($db->execute()) {
                                $this->message = "Dados do usuario atualizado com sucesso!<br>";
                                $this->link = "../usuarios";
                                $success = new Success();
                                $success->getSuccessMessage($this->message, $this->link);
                                return true;
                            } else {
                                $this->message = "Impossivel realizar operação!<br>";
                                $this->link = "../usuarios";
                                $error = new Error();
                                $error->getErroMessage($this->message, $this->link);
                            }
                        }
                    }
                    /**
                     * Se o endereço de email não tiver disponivel, apresente um erro
                     */
                    else{
                        $this->message = "Endereço de email ja pertence a outro usuario<br>";
                        $this->link = "../usuarios";
                        $error = new Error();
                        $error->getErroMessage($this->message, $this->link);
                    }
                }
            }
            /**
             *Caso o id não exista ou, tenha mais de 1
             */
            else{
                $this->message="Impossivel realizar operação, dados invalidos!<br>";
                $this->link="../usuarios";
                $error = new Error();
                $error->getErroMessage($this->message,$this->link);
            }

        } /**
         * Caso os dados sejam invalidos
         */
        else{
            $this->message="
                Um ou mais dos itens seguintes não atende aos padrões requisitados!<br>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <ul>
                                <li>
                                    Email.
                                </li>
                                <li>
                                    Celular.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                ";
            $this->link = "../usuarios";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }
    }
}
?>
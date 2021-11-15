<?php
namespace Root;
require_once"connection.php";
require_once"crypt.php";
require_once"validationInput.php";
require_once"error.php";
require_once"success.php";
require_once"folder.php";

/**
 * Esta Classe e responsavel por inserir informações no banco de dados.
 * Class Create
 * @package Root
 */
class Create{
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
     *Esta função e responsavel por inserir as informações do cliente no banco de dados.
     *
     * @param string $nome Recebe o nome do cliente.
     * @param string $email Recebe o email do cliente.
     * @param string $senha Recebe a senha do cliente.
     * @param string $celular Recebe o numero de telefone celular do cliente.
     * @param string $cnpj Recebe o CNPJ do cliente.
     */

    function insertTableClientes($nome,$email,$senha,$celular,$cnpj){
        $validate = new Validation();
        $this->email = $validate->filterEmail($email);
        $this->celular = $validate->filteCelular($celular);
        $this->cpf = $validate->filterCpfCnpj($cnpj);
        /**
         * Confere se os dados inseridos atenderam os padrões solitados pelas expressões regulare.
         */
        if($this->cpf && $this->celular && $this->email){

            $this->sql="
            SELECT * FROM clientes WHERE email = :email or cnpj  = :cnpj
            ";
            $con = new Connection();
            $obj = $con->connection();
            $db = $obj->prepare($this->sql);
            $db->bindValue(':email',$email,\PDO::PARAM_STR);
            $db->bindValue(':cnpj',$cnpj,\PDO::PARAM_STR);
            $db->execute();
            $count = $db->rowCount();
            /**
             * Confere se existe algum EMAIL ou CNPJ igual ao que esta sendo inserido no banco de dados.
             */
            if($count == 0){
                $crypt = new Crypt();
                $this->sql="
                INSERT INTO clientes (nome,email,senha,celular,cnpj)
                VALUES(:nome,:email,:senha,:celular,:cnpj)
                ";
                $con = new Connection();
                $obj = $con->connection();
                $db = $obj->prepare($this->sql);
                $nome = base64_encode($nome);
                $db->bindValue(':nome',$nome,\PDO::PARAM_STR);
                $db->bindValue(':email',$email,\PDO::PARAM_STR);
                $senha = $crypt->hashValue($senha);
                $db->bindValue(':senha',$senha,\PDO::PARAM_STR);
                $db->bindValue(':celular',$celular,\PDO::PARAM_STR);
                $db->bindValue(':cnpj',$cnpj,\PDO::PARAM_STR);
                /**
                 * Confere se houve êxito ao executar a sql, se sim, mostra a mensagem de sucesso.
                 */
                if($db->execute()){
                    $this->message="Cadastro de Clientes realizado com sucesso!<br>";
                    $this->link = "../clientes";
                    $success = new Success();
                    $success->getSuccessMessage($this->message, $this->link);

                } /**
                 * Se houver falha durante a execução, a mensagem de erro sera mostrada.
                 */
                else{
                    $this->message="Impossivel realizar operação!<br>";
                    $this->link = "../clientes";
                    $error = new Error();
                    $error->getErroMessage($this->message,$this->link);
                }
            } /**
             *Se houver algum registro no banco de dados, igual ao que está sendo inserido, a mensagem de erro deve ser
             * impressa na tela.
             */
            else{
                $this->message="Endereço de email ou CNPJ já esta sendo usado por outro usuário!<br>";
                $this->link = "../clientes";
                $error = new Error();
                $error->getErroMessage($this->message,$this->link);

            }

        } /**
         * Se os dados não atenderem aos padrões solicitados, a seguinte mensagem deve ser impressa na tela.
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

    /**
     * Esta função e responsavel por inserir as informações de uma loja no banco de dados.
     *
     * @param int $id_dono Recebe o id(Chave primaria) do cliente para usar como Foreing key.
     * @param int $id_categoria Recebe o id(Chave primaria) da categoria para usar como Foreing key.
     * @param string $razao Recebe a Razão Social da loja.
     * @param string $fantasia Recebe o Nome Fantasia da Loja.
     * @param string $inscricao Caso a loja possuir uma inscrição estadual, deve ser passado neste parametro.
     * @param string $isento Caso seja Isento de inscrição estadual, deve ser informado neste parametro.
     * @param string $optante Caso seja Optante Pelo Simples, deve ser informado neste parametro
     */
    function insertTableLojas($id_dono,$id_categoria,$razao,$fantasia,$inscricao,$isento,$optante,$status,$validade,$inicio,$fim){
        $razao = base64_encode($razao);
        $this->sql="
        SELECT * FROM lojas WHERE razao_social = :razao
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':razao',$razao,\PDO::PARAM_STR);
        $db->execute();
        $count = $db->rowCount();
        /**
         * Confere se a Razão social informada, não pertence a outra loja registrada no sistema.
         */
        if($count == 0) {
            $folder = new Folder() ;
            $this->sql = "
            INSERT INTO lojas(id_dono,id_categoria,razao_social,nome_fantasia,inscricao_estadual,isento,optante_pelo_simples,status,validade,inicio,fim)
            VALUES (:id,:categoria,:razao,:fantasia,:inscricao,:isento,:optante,:status,:validade,:inicio,:fim);
            SELECT LAST_INSERT_ID() AS id_loja;
            ";
            $con = new Connection();
            $obj = $con->connection();
            $db = $obj->prepare($this->sql);
            $db->bindValue(':id', $id_dono, \PDO::PARAM_INT);
            $db->bindValue(':categoria', $id_categoria, \PDO::PARAM_INT);
            $db->bindValue(':razao', $razao, \PDO::PARAM_STR);
            $fantasia = base64_encode($fantasia);
            $db->bindValue(':fantasia', $fantasia, \PDO::PARAM_STR);
            $db->bindValue(':inscricao', $inscricao, \PDO::PARAM_STR);
            $db->bindValue(':isento', $isento, \PDO::PARAM_STR);
            $db->bindValue(':optante', $optante, \PDO::PARAM_STR);
            $db->bindValue(':status',$status,\PDO::PARAM_INT);
            $db->bindValue(':validade',$validade,\PDO::PARAM_INT);
            $db->bindValue(':inicio',$inicio,\PDO::PARAM_STR);
            $db->bindValue(':fim',$fim,\PDO::PARAM_STR);
            /**
             * Confere se houve exito durante a execução da SQL, apos conferir, imprime uma mensagem de sucesso na tela.
             */
            if($db->execute()){
                $lastId = $obj->lastInsertId();
                $folder->createDir($lastId);
                $this->message="Cadastro de Loja realizado com sucesso!<br>";
                self::createTablesLojas($lastId,$validade);
                $this->link = "../lojas";
                $success = new Success();
                $success->getSuccessMessage($this->message, $this->link);
                echo"<br>";
            } /**
             * Caso houver alguma falha durante a execução, a seguinte mensagem de erro deve ser impressa na tela.
             */
            else{
                $this->message="Impossivel realizar operação!<br>";
                $this->link = "../lojas";
                $error = new Error();
                $error->getErroMessage($this->message,$this->link);
            }
        } /**
         * Caso a pesquisa no banco de dados retorne algum registro, deve ser apresentada uma mensagem de erro, pois a razão social ja esta em uso.
         */
        else{
            $this->message="Esta Razão Social já esta sendo usada por outro usuário!<br>";
            $this->link="../lojas";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);

        }
    }

    /**
     * Esta função e responsavel por inserir as informações do Usuário no banco de dados.
     * @param string $nome Recebe o nome do Usuário que sera inserido no sistema.
     * @param string $email Recebe o email do Usuário que sera inserido no sistema.
     * @param string $senha Recebe a senha do Usuário que sera inserida no sistema.
     * @param string $celular Recebe o numero de telefone celular do Usuário que sera inserido no sistema.
     */
    function insertTableUsuario($nome,$email,$senha,$celular,$link){
        $validate = new Validation();
        $this->email = $validate->filterEmail($email);
        $this->celular = $validate->filteCelular($celular);
        $this->link = $link;
        /**
         * Confere se os dados inseridos atendem as expressões regulares.
         */
        if($this->email && $this->celular){

            $this->sql="
            SELECT * FROM usuarios WHERE email = :email
            ";
            $con = new Connection();
            $obj = $con->connection();
            $db = $obj->prepare($this->sql);
            $db->bindValue(':email',$email,\PDO::PARAM_STR);
            $db->execute();
            $count = $db->rowCount();
            /**
             * Confere se o endereço de email informado, não esta sendo usado por outro usuario.
             */
            if($count == 0) {
                $crypt = new Crypt();
                $this->sql = "
                INSERT INTO usuarios(nome_usuario,email,senha,celular)
                VALUES (:nome,:email,:senha,:celular);
                SELECT LAST_INSERT_ID() AS id_usuario;
                ";
                $con = new Connection();
                $obj = $con->connection();
                $db = $obj->prepare($this->sql);
                $nome = base64_encode($nome);
                $db->bindValue(':nome', $nome, \PDO::PARAM_STR);
                $db->bindValue(':email', $email, \PDO::PARAM_STR);
                $senha = $crypt->hashValue($senha);
                $db->bindValue(':senha', $senha, \PDO::PARAM_STR);
                $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                /**
                 * Confere se houve exito ao executar a SQL, se sim, imprima uma mensagem de sucesso na tela.
                 */
                if($db->execute()){
                    $lastId = $obj->lastInsertId();
                    self::createUserTable($lastId);
                    $this->message="Cadastro de Usuario realizado com sucesso!<br>";
                    $success = new Success();
                    $success->getSuccessMessage($this->message, $this->link);
                    return true;
                }
                /**
                 * Se houver alguma falha durante a execução, devera ser mostrada uma mensagem de erro.
                 */

                else{
                    $this->message="Impossivel realizar operação!<br>";
                    $error = new Error();
                    $error->getErroMessage($this->message,$this->link);
                }
            } /**
             * Se o email informado ja estiver me uso por outro usuario, deve ser mostrado uma mensagem de erro.
             */
            else {
                $this->message="Este endereço de email já esta sendo usado por outro usuário!<br>";
                $error = new Error();
                $error->getErroMessage($this->message,$this->link);

            }

        } /**
         * Caso alguma infomação inserida não atenda aos padrões, devera ser montrada um mensagem de erro ao usuario.
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
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);

        }
    }

    /**
     * Esta função e responsavel por inserir as informações de um administrador no banco de dados.
     *
     * @param string $nome Recebe o nome do administrador.
     * @param string $email Recebe o email do administrador
     * @param string $senha Recebe a senha do administrador
     * @param string $celular Recebe o numero de telefone celular  do administrador.
     */
    function insertTableAdmin($nome,$email,$senha,$celular){
        $validate = new Validation();
        $this->email = $validate->filterEmail($email);
        $this->celular = $validate->filteCelular($celular);
        /**
         * Confere se os dados informados atendem os padrões solicitados.
         */
        if($this->email && $this->celular){

            $this->sql="
            SELECT * FROM admin WHERE email = :email
            ";
            $con = new Connection();
            $obj = $con->connection();
            $db = $obj->prepare($this->sql);
            $db->bindValue(':email',$email,\PDO::PARAM_STR);
            $db->execute();
            $count = $db->rowCount();
            /**
             * Confere se o email informado não esta em uso por outro administrador
             */
            if($count == 0) {
                $crypt = new Crypt();
                $this->sql = "
                INSERT INTO admin(nome_admin,email,senha,celular)
                VALUES (:nome,:email,:senha,:celular)
                ";
                $con = new Connection();
                $obj = $con->connection();
                $db = $obj->prepare($this->sql);
                $nome = base64_encode($nome);
                $db->bindValue(':nome', $nome, \PDO::PARAM_STR);
                $db->bindValue(':email', $email, \PDO::PARAM_STR);
                $senha = $crypt->hashValue($senha);
                $db->bindValue(':senha', $senha, \PDO::PARAM_STR);
                $db->bindValue(':celular', $celular, \PDO::PARAM_STR);
                /**
                 * Confere se houve exito durante a execução da SQL, apos conferir, deve mostrar um mensagem de sucesso na tela.
                 */
                if($db->execute()){
                    $this->message="Cadastro de Administrador realizado com sucesso!<br>";
                    $this->link = "../admin";
                    $success = new Success();
                    $success->getSuccessMessage($this->message, $this->link);
                } /**
                 * Caso houver algum erro durante a execução, deve ser mostrado uma mensagem de erro na tela.
                 */
                else{
                    $this->message="Impossivel realizar operação!<br>";
                    $this->link = "../admin";
                    $error = new Error();
                    $error->getErroMessage($this->message,$this->link);
                }
            } /**
             * Caso o email informado esteja em uso por outro administrador, deve ser mostrado uma mensagem de erro na tela.
             */
            else{
                $this->message="Este endereço de email já esta sendo usado por outro usuario!<br>";
                $this->link = "../admin";
                $error = new Error();
                $error->getErroMessage($this->message,$this->link);
            }
        } /**
         * Caso as informações inseridas não antenda aos padrões solicitados, deve ser mostrado uma mensagem de erro na tela.
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
            $this->link = "../admin";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }

    }

    /**
     * Esta função e responsavel por inserir uma nova categoria no banco de dados.
     * @param string $nome Recebe o nome da Categoria.
     */
    function insertTableCategoria($nome){
        $nome = base64_encode($nome);
        $this->sql="
        SELECT * FROM categorias WHERE nome_categoria = :nome
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':nome',$nome,\PDO::PARAM_STR);
        $db->execute();
        $count = $db->rowCount();
        /**
         * Confere se a categoria informada não existe no sistema.
         */
        if($count == 0) {
            $this->sql = "
            INSERT INTO categorias(nome_categoria) VALUES (:nome)
            ";
            $con = new Connection();
            $obj = $con->connection();
            $db = $obj->prepare($this->sql);
            $db->bindValue(':nome', $nome, \PDO::PARAM_STR);
            /**
             * Confere se houve exito durante a execução da SQL, apos isso mostrar mensagem de sucesso na tela.
             */
            if($db->execute()){
                $this->message="Cadastro de Categoria realizado com sucesso!<br>";
                $this->link = "../categoria";
                $success = new Success();
                $success->getSuccessMessage($this->message, $this->link);
            } /**
             * Caso houver algum erro durante a execução, deve ser impresso uma mensagem de erro na tela.
             */
            else{
                $this->message="Impossivel realizar operação!<br>";
                $this->link = "../categoria";
                $error = new Error();
                $error->getErroMessage($this->message,$this->link);
            }
        } /**
         * Caso a categoria informada exista no banco de dados, a seguinte mensagem deve ser impressa na tela.
         */
        else{
            $this->message="Esta categoria já existe!<br>";
            $this->link = "../categoria";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }


    }
    function createTablesLojas($id,$tipo){
        if($tipo == 1){
        $this->sql=
            "
            CREATE TABLE categorias_$id(
            id INT (9) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
            nome_categoria VARCHAR (100) NOT NULL
            )engine = innodb;

            CREATE TABLE produtos_$id(
            id INT (9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            id_categoria INT(9) NOT NULL ,
            nome_produto VARCHAR (100) NOT NULL,
            img_1 VARCHAR (255) NOT NULL ,
            img_2 VARCHAR (255) NOT NULL ,
            img_3 VARCHAR (255) NOT NULL,
            descricao TEXT NOT NULL,
            identificador VARCHAR (100),
            peso VARCHAR (10),
            preco VARCHAR (10),
            quantidade VARCHAR (10),
            maximo VARCHAR (10)
            )engine = innodb;

            CREATE TABLE pedidos_$id(
            id INT (9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            pedido TEXT,
            nome VARCHAR(100) NOT NULL ,
            celular VARCHAR (20) NOT NULL,
            endereco TEXT,
            status INT (1) NOT NULL,
            hora VARCHAR (9) NULL
            )engine = innodb;

            ALTER TABLE produtos_$id
            ADD CONSTRAINT key_categoria_$id FOREIGN KEY (id_categoria)
            REFERENCES categorias_$id(id)
            ON DELETE RESTRICT
            ON UPDATE CASCADE;
            ";

        $con = new Connection();
        $obj = $con->connection();
        $obj->query($this->sql);
        }
        else{
            $this->sql=
                "
            CREATE TABLE categorias_$id(
            id INT (9) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
            nome_categoria VARCHAR (100) NOT NULL
            )engine = innodb;

            CREATE TABLE produtos_$id(
            id INT (9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            id_categoria INT(9) NOT NULL ,
            nome_produto VARCHAR (100) NOT NULL,
            img_1 VARCHAR (255) NOT NULL ,
            img_2 VARCHAR (255) NOT NULL ,
            img_3 VARCHAR (255) NOT NULL,
            descricao TEXT NOT NULL,
            identificador VARCHAR (100),
            peso VARCHAR (10),
            preco VARCHAR (10),
            quantidade VARCHAR (10),
            maximo VARCHAR (10)
            )engine = innodb;

            CREATE TABLE pedidos_$id(
            id INT (9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            pedido TEXT,
            nome VARCHAR(100) NOT NULL ,
            celular VARCHAR (20) NOT NULL,
            endereco TEXT,
            status INT (1) NOT NULL,
            hora VARCHAR (20) NULL,
            validade VARCHAR (1),
            identificador VARCHAR (10)
            )engine = innodb;

            ALTER TABLE produtos_$id
            ADD CONSTRAINT key_categoria_$id FOREIGN KEY (id_categoria)
            REFERENCES categorias_$id(id)
            ON DELETE RESTRICT
            ON UPDATE CASCADE;
            ";

            $con = new Connection();
            $obj = $con->connection();
            $obj->query($this->sql);

        }
    }
    function createUserTable($id){
        $this->sql="
            CREATE TABLE solicitacao_$id(
            id INT (9) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            pedido TEXT,
            loja VARCHAR(100) NOT NULL ,
            status INT (1) NOT NULL,
            hora VARCHAR(20),
            identificador VARCHAR (10)
            )engine = innodb;
        ";
        $con = new Connection();
        $obj = $con->connection();
        $obj->query($this->sql);
    }

    /**
     * Esta função desaloca da memoria os dados gerados durante a execuçaõ.
     */
    function __destruct(){
    }
}
?>
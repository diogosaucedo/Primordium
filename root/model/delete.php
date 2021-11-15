<?php
namespace Root;
require_once"connection.php";
require_once"success.php";
require_once"error.php";
require_once"folder.php";

/**
 * Esta classe e responsavel por excluir as informações do banco de dados.
 *
 * Class Delete
 * @package Root
 */
class Delete{
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
     * Função responsavel por excluir registro da tabela Admin.
     *
     * @param int $id Recebe o id do administrador.
     */
    public function deleteTableAdmin($id){
        $this->sql = "
        DELETE FROM admin WHERE id_admin = :id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':id',$id,\PDO::PARAM_INT);
        /**
         * Confere se houve exito durante a execução da SQL, apos isso mostra uma mensagem de sucesso na tela.
         */
        if($db->execute()){
            $this->message="Administrador excluido com sucesso!<br>";
            $this->link = "../admin";
            $success = new Success();
            $success->getSuccessMessage($this->message, $this->link);
        } /**
         * Caso houver algum erro, deve ser mostrada uma mensagem de erro na tela.
         */
        else{
            $this->message="Impossivel realizar operação!<br>";
            $this->link = "../admin";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }
    }

    /**
     * Esta função e responsavel por excluir registro da tabela Categoria.
     *
     * @param int $id Recebe o id da categoria.
     */
    public function deleteTableCategoria($id){
        $this->sql="
        DELETE FROM categorias WHERE id_categoria = :id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':id',$id,\PDO::PARAM_INT);
        /**
         * Confere se houve exito durante a execução da SQL, apos isso mostra uma mensagem de sucesso na tela
         */
        if($db->execute()){
            $this->message="Categoria excluida com sucesso!<br>";
            $this->link = "../categoria";
            $success = new Success();
            $success->getSuccessMessage($this->message, $this->link);

        } /**
         * Caso houver erro durante a execução, deve ser mostrado uma mensagem de erro na tela.
         */
        else{
            $this->message="Impossivel realizar operação!<br>";
            $this->link = "../categoria";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }
    }

    /**
     * Esta função e responsavel por excluir registro da tabela cliente.
     *
     * @param int $id Recebe o id do cliente.
     */
    public function deleteTableCliente($id){
        $this->sql="
        DELETE FROM clientes WHERE id_cliente = :id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':id',$id,\PDO::PARAM_INT);
        /**
         * Confere se houve exito durante a execução da SQL, apos isso mostra uma mensagem de sucesso na tela.
         */
        if($db->execute()){
            $this->message="Cliente excluido com sucesso!<br>";
            $this->link = "../clientes";
            $success = new Success();
            $success->getSuccessMessage($this->message, $this->link);
        } /**
         * Caso houve algum erro durante a execução, deve ser mostrada uma mensagem de erro na tela.
         */
        else{
            $this->message="Impossivel realizar operação!<br>";
            $this->link = "../clientes";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }
    }

    /**
     * Esta função e responsavel por excluir registro da tabela loja.
     *
     * @param int $id Recebe o id da loja.
     */
    public function deleteTableLoja($id){
        $folder = new Folder();
        $this->sql="
        DELETE FROM lojas WHERE id_loja = :id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':id',$id,\PDO::PARAM_INT);
        /**
         * Confere se houve exito durante a execução da SQL, apos isso mostra uma mensagem de sucesso na tela.
         */
        if($db->execute() && $folder->deleteDir($id) && self::deleteTablesLojas($id)){
            $this->message="Loja excluida com Sucesso!<br>";
            $this->link = "../lojas";
            $success = new Success();
            $success->getSuccessMessage($this->message, $this->link);

        }
        /**
         * Caso houve algum erro durante a execução, deve ser mostrada uma mensagem de erro na tela.
         */
        else{
            $this->message="Impossivel realizar operação!<br>";
            $this->link = "../lojas";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }
    }

    /**
     * Esta função e responsavel por excluir registro da tabela usuarios
     *
     * @param int $id Recebe o id do usuario.
     */
    public function deleteTableUsuario($id){
        $this->sql="
        DELETE FROM usuarios WHERE id_usuario = :id;
        DROP TABLE solicitacao_$id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':id',$id,\PDO::PARAM_INT);
        /**
         * Confere se houve exito durante a execução da SQL, apos isso mostra uma mensagem de sucesso na tela.
         */
        if($db->execute()){
            $this->message="Usuario excluido com Sucesso!<br>";
            $this->link = "../usuarios";
            $success = new Success();
            $success->getSuccessMessage($this->message, $this->link);

        }
        /**
         * Caso houve algum erro durante a execução, deve ser mostrada uma mensagem de erro na tela.
         */
        else{
            $this->message="Impossivel realizar operação!<br>";
            $this->link = "../usuarios";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }
    }
    function deleteTablesLojas($id){
        $this->sql="
        DROP TABLE pedidos_$id;
        DROP TABLE produtos_$id;
        DROP TABLE categorias_$id;
        ";
        $con = new Connection();
        $obj = $con->connection();
        if($obj->query($this->sql)){
            return true;
        }

    }

    /**
     * Função responsavel por desalocar da memoria informações geradas durante a execução.
     */
    function __destruct(){

    }
}
?>
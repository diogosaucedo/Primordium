<?php
namespace User;
/**
 * Esta classe é responsavel por realizar a conexão com o banco de dados através do PDO.
 * @author Diogo Ferreira Saucedo <diogoferreiradfs@hotmail.com>
 * @name  class Connection
 */
class Connection{
    /**
     * @var $connection
     * É responsavel por instanciar a classe PDO, para realizar a conexão com banco de dados.
     */
    protected $connection;

    /**
     * Esta função realiza a conexão com o banco de dados.
     * @return \PDO
     */
    public function connection(){
        try {
            $this->connection =new \PDO("mysql:host=mysql.primordium.com.br;dbname=primordium;charset=utf8","primordium","!@#AKJJYGLC");
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        }catch (\PDOException $e){
            echo $e;
        }
    }

    /**
     * Esta função desaloca da memoria os dados gerados durante a execução
     */
   function __destruct(){

}
}

?>
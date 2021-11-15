<?php
namespace Root;
require_once"connection.php";
require_once"success.php";
require_once"create.php";
class Start extends Connection{
    protected $sql;
    protected $connection;
    protected $message;
    protected $link;
    protected function createAllTables(){
        $this->connection = parent::connection();
        $this->sql = "
        CREATE TABLE clientes(
        id_cliente INT (9) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
        nome  VARCHAR (100) NOT NULL ,
        email VARCHAR (100) NOT NULL ,
        senha VARCHAR (60) NOT NULL ,
        celular VARCHAR(20) NOT NULL,
        cnpj VARCHAR(20) NOT NULL
        )engine = innodb;

        CREATE TABLE lojas(
        id_loja INT(9) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
        id_categoria INT(9) NOT NULL ,
        id_dono INT(9) NOT NULL ,
        razao_social VARCHAR(100),
        nome_fantasia VARCHAR (100),
        inscricao_estadual VARCHAR(20),
        isento VARCHAR(3),
        optante_pelo_simples VARCHAR(3),
        status VARCHAR (1),
        validade VARCHAR (1),
        inicio VARCHAR (3),
        fim VARCHAR (3)
        )engine = innodb;

        CREATE TABLE usuarios(
        id_usuario INT(9) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
        nome_usuario  VARCHAR(100) NOT NULL ,
        email VARCHAR(100) NOT NULL ,
        senha VARCHAR(60) NOT NULL ,
        celular VARCHAR(20) NOT NULL
        )engine = innodb;

        CREATE TABLE admin(
        id_admin INT(9) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
        nome_admin VARCHAR(100) NOT NULL ,
        email VARCHAR(100) NOT NULL ,
        senha VARCHAR(100) NOT NULL ,
        celular VARCHAR(20) NOT NULL
        )engine = innodb;

        CREATE TABLE categorias(
        id_categoria INT(9) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
        nome_categoria VARCHAR(100) NOT NULL
        )engine = innodb;

        ALTER TABLE lojas
        ADD CONSTRAINT chave_dono FOREIGN KEY (id_dono)
        REFERENCES clientes(id_cliente)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

        ALTER TABLE lojas
        ADD CONSTRAINT chave_categoria FOREIGN KEY (id_categoria)
        REFERENCES categorias(id_categoria)
        ON DELETE CASCADE
        ON UPDATE CASCADE;

        ";
        $this->connection->query($this->sql);
        $insert = new Create();
        $insert->insertTableAdmin("Diogo Ferreira Saucedo","DiogoferreiraDFS@hotmail.com","thugstools","6599674050");

        return true;

    }
    public function start(){
        if($this->createAllTables()){
            $this->message="Sistema foi iniciado com sucesso!<br>";
            $this->link = "../";
            $success = new Success();
            $success->getSuccessMessage($this->message, $this->link);
        }
        else{
            $this->message="Falha ao iniciar sistema!<br>";
            $this->link = "../";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }
    }
    function __destruct(){

    }
}

?>
<?php
namespace Admin;
require_once"connection.php";
require_once"success.php";
require_once"error.php";
class Delete{
    protected $sql;
    protected $file;
    protected $message;
    protected $link;
    protected $count;
    protected $list;

    function deleteCategoria($idLoja,$idCategoria){
        $this->sql="
        SELECT * FROM produtos_$idLoja WHERE id_categoria = :id
        ";
        $con = new Connection();
        $db = $con->connection();
        $read = $db->prepare($this->sql);
        $read->bindValue(':id',$idCategoria,\PDO::PARAM_INT);
        $read->execute();
        $this->count = $read->rowCount();
        if($this->count == 0){
            $this->sql = "
            DELETE FROM categorias_$idLoja WHERE id = :id
            ";
            $con = new Connection();
            $db = $con->connection();
            $delete = $db->prepare($this->sql);
            $delete->bindValue(':id',$idCategoria,\PDO::PARAM_INT);
            if($delete->execute()){
                $this->message = "Dados de Categoria excluido com sucesso!<br>";
                $this->link = "../categoria";
                $success = new Success();
                $success->getSuccessMessage($this->message, $this->link);
            }
            else{
                $this->message = "Impossivel realizar operação!<br>";
                $this->link = "../categoria";
                $error = new Error();
                $error->getErroMessage($this->message, $this->link);
            }
        }
        else{
            while($linha = $read->fetch(\PDO::FETCH_ASSOC)){
                $this->list[]="
                 <li>
                ".$linha['nome_produto']."
                </li>
                ";
            }

            $this->message="
            Impossivel excluir esta categoria, pois existe produtos vinculados a ela!<br>
            Você pode trocar a categoria destes produtos individualmente ou apenas renomear esta categoria!<br>
            <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <ul>
              ";
            foreach($this->list as $lista){
                $this->message .= $lista;
            }
            $this->message.="
                            </ul>
                        </div>
                    </div>
            </div>
            ";
            $this->link = "../categoria";
            $error = new Error();
            $error->getErroMessage($this->message, $this->link);
        }
    }
    function deleteProdutos($idLoja,$idproduto){
        $this->sql ="
        SELECT * FROM produtos_$idLoja WHERE id = :id
        ";
        $con = new Connection();
        $read = $con->connection();
        $result = $read->prepare($this->sql);
        $result->bindValue(':id',$idproduto,\PDO::PARAM_INT);
        $result->execute();
        $count = $result->rowCount();
        if($count == 1){
            $linha = $result->fetch(\PDO::FETCH_ASSOC);
            $this->file[] = $linha['img_1'];
            $this->file[] = $linha['img_2'];
            $this->file[] = $linha['img_3'];
            foreach($this->file as $file){
                if(file_exists("../../lojas/$idLoja/$file")){
                    unlink("../../lojas/$idLoja/$file");
                }
            }
            $this->sql = "
            DELETE FROM produtos_$idLoja WHERE id = :id
            ";
            $con = new Connection();
            $db = $con->connection();
            $delete = $db->prepare($this->sql);
            $delete->bindValue(':id',$idproduto,\PDO::PARAM_INT);
            if($delete->execute()){
                $this->message = "Dados de Produto excluido com sucesso!<br>";
                $this->link = "../produto";
                $success = new Success();
                $success->getSuccessMessage($this->message, $this->link);
            }
            else{
                $this->message = "Impossivel realizar operação!<br>";
                $this->link = "../produto";
                $error = new Error();
                $error->getErroMessage($this->message, $this->link);
            }

        }
        else{

        }
    }
    function clearSales($loja){
        $this->sql = "
        DELETE FROM pedidos_$loja WHERE status = :status
        ";
        $con = new Connection();
        $db = $con->connection();
        $delete = $db->prepare($this->sql);
        $delete->bindValue(':status',1,\PDO::PARAM_INT);
        if($delete->execute()){
            return true;
        }

    }
}
?>
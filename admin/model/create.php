<?php
namespace Admin;
require_once"../../root/model/create.php";
require_once"connection.php";
require_once"error.php";
require_once"success.php";
require_once"fileFilter.php";
class Create extends \Root\Create{

    protected $sql;
    function insertTableCategoriaLoja($idLoja, $nomeCategoria){
        $nomeCategoria = base64_encode($nomeCategoria);
        $this->sql="
        SELECT * FROM categorias_$idLoja WHERE nome_categoria = :nome
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(":nome",$nomeCategoria,\PDO::PARAM_STR);
        $db->execute();
        $count = $db->rowCount();
        if($count == 0){
            $this->sql = "
            INSERT INTO categorias_$idLoja(nome_categoria) VALUES (:nome)
            ";
            $con = new Connection();
            $obj = $con->connection();
            $db = $obj->prepare($this->sql);
            $db->bindValue(':nome', $nomeCategoria, \PDO::PARAM_STR);
            if($db->execute()){
                $this->message="Cadastro de Categoria realizado com sucesso!<br>";
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
            $this->message="Esta categoria já existe!<br>";
            $this->link = "../categoria";
            $error = new Error();
            $error->getErroMessage($this->message,$this->link);
        }


    }
    function insertTableProdutos($idLoja, $idCategoria,$nomeProduto,$img1,$img2,$img3,$descricao,$identificador,$peso,$preco,$quantidade,$maximo){
        $filter = new ImageFilter();
        if($filter->fileType($img1) && $filter->fileType($img2) && $filter->fileType($img3)) {
            if ($filter->fileSize($img1) && $filter->fileSize($img2) && $filter->fileSize($img3)) {
                if (!empty($img1['name'])) {
                    $img1['name'] = $filter->fileName($img1, $nomeProduto);
                } else {
                    $img1['name'] = '';
                }
                if (!empty($img2['name'])) {
                    $img2['name'] = $filter->fileName($img2, $nomeProduto);
                } else {
                    $img2['name'] = '';
                }
                if (!empty($img3['name'])) {
                    $img3['name'] = $filter->fileName($img3, $nomeProduto);
                } else {
                    $img3['name'] = '';
                }
                $this->sql = "
                INSERT INTO produtos_$idLoja(id_categoria,nome_produto,img_1,img_2,img_3,descricao,identificador,peso,preco,quantidade,maximo) VALUES (:id,:nome,:img1,:img2,:img3,:descricao,:identificador,:peso,:preco,:quantidade,:maximo)
                ";
                $con = new Connection();
                $obj = $con->connection();
                $db = $obj->prepare($this->sql);
                $db->bindValue(':id', $idCategoria, \PDO::PARAM_INT);
                $nomeProduto = base64_encode($nomeProduto);
                $db->bindValue(':nome', $nomeProduto, \PDO::PARAM_STR);
                $db->bindValue(':img1', $img1['name'], \PDO::PARAM_STR);
                $db->bindValue(':img2', $img2['name'], \PDO::PARAM_STR);
                $db->bindValue(':img3', $img3['name'], \PDO::PARAM_STR);
                $descricao = base64_encode($descricao);
                $db->bindValue(':descricao', $descricao, \PDO::PARAM_STR);
                $db->bindValue(':identificador', $identificador, \PDO::PARAM_STR);
                $db->bindValue(':peso', $peso, \PDO::PARAM_STR);
                $db->bindValue(':preco', $preco, \PDO::PARAM_STR);
                $db->bindValue(':quantidade', $quantidade, \PDO::PARAM_INT);
                $db->bindValue(':maximo', $maximo, \PDO::PARAM_INT);

                if ($db->execute()) {
                    try {
                        if (!empty($img1['name'])) {
                            move_uploaded_file($img1['tmp_name'], "../../lojas/" . $idLoja . "/" . $img1['name']);
                        }
                        if (!empty($img2['name'])) {
                            move_uploaded_file($img2['tmp_name'], "../../lojas/" . $idLoja . "/" . $img2['name']);
                        }
                        if (!empty($img3['name'])) {
                            move_uploaded_file($img3['tmp_name'], "../../lojas/" . $idLoja . "/" . $img3['name']);
                        }


                    } catch (\Exception $e) {
                        echo $e->getMessage();

                    }
                    $this->message = "Cadastro de Produto realizado com sucesso!<br>";
                    $this->link = "../produto";
                    $success = new Success();
                    $success->getSuccessMessage($this->message, $this->link);
                } else {
                    $this->message = "Impossivel realizar operação!<br>";
                    $this->link = "../produto";
                    $error = new Error();
                    $error->getErroMessage($this->message, $this->link);
                }
            } else {
                $this->message = "Arquivo muito grande, tente arquivo com até 10 Mb<br>";
                $this->link = "../produto";
                $error = new Error();
                $error->getErroMessage($this->message, $this->link);
            }
        }
        else{
            $this->message = "O arquivo não é uma imagem!<br>";
            $this->link = "../produto";
            $error = new Error();
            $error->getErroMessage($this->message, $this->link);

        }
    }
}
?>
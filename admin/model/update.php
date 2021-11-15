<?php
namespace Admin;
require_once"connection.php";
require_once"success.php";
require_once"error.php";
require_once"fileFilter.php";
class Update
{
    protected $sql;
    protected $message;
    protected $link;
    protected $imageName;

    function updateCategoria($idLoja, $id, $nome)
    {
        $this->sql = "
        UPDATE categorias_$idLoja SET
        nome_categoria = :nome
        WHERE id = :id
        ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $nome = base64_encode($nome);
        $db->bindValue(':nome', $nome, \PDO::PARAM_STR);
        $db->bindValue(':id', $id, \PDO::PARAM_STR);
        if ($db->execute()) {
            $this->message = "Dados do Categoria atualizado com sucesso!<br>";
            $this->link = "../categoria";
            $success = new Success();
            $success->getSuccessMessage($this->message, $this->link);
        } /**
         * Caso houver erro, deve ser mostrado uma mensagem de erro na tela.
         */
        else {
            $this->message = "Impossivel realizar operação!<br>";
            $this->link = "../Categoria";
            $error = new Error();
            $error->getErroMessage($this->message, $this->link);
        }
    }

    function updateProduto($idLoja, $idProduto, $idCategoria, $nomeProduto, $img1, $img2, $img3, $descricao, $identificador, $peso, $preco, $quantidade,$maximo)
    {
        $filter = new ImageFilter();
        if ($filter->fileType($img1) && $filter->fileType($img2) && $filter->fileType($img3)) {
            if ($filter->fileSize($img1) && $filter->fileSize($img2) && $filter->fileSize($img3)) {
                $this->sql = "
                SELECT * FROM produtos_$idLoja WHERE id = :id
                ";
                $con = new Connection();
                $read = $con->connection();
                $result = $read->prepare($this->sql);
                $result->bindValue(':id', $idProduto, \PDO::PARAM_INT);
                $result->execute();
                $count = $result->rowCount();
                if ($count == 1) {
                    $linha = $result->fetch(\PDO::FETCH_ASSOC);
                    $file[] = $img1;
                    $file[] = $img2;
                    $file[] = $img3;
                    $i = 1;
                    foreach ($file as $data) {
                        if (!empty($data["name"])) {
                            if (!empty($linha["img_$i"])) {
                                $data["name"] = $linha["img_$i"];
                                unlink("../../lojas/$idLoja/" . $linha["img_$i"]);
                                move_uploaded_file($data['tmp_name'], "../../lojas/" . $idLoja . "/" . $data['name']);
                            } else {
                                $filter = new ImageFilter();
                                $data["name"] = $filter->fileName($data, $linha["nome_produto"]);
                                move_uploaded_file($data['tmp_name'], "../../lojas/" . $idLoja . "/" . $data['name']);
                            }
                        } else {
                            $data['name'] = $linha["img_$i"];
                        }
                        $this->imageName[] = $data['name'];
                        $i++;
                    }
                    $this->sql = "
                    UPDATE produtos_$idLoja SET
                    id_categoria = :categoria,
                    nome_produto = :nome,
                    img_1 = :img1,
                    img_2 = :img2,
                    img_3 = :img3,
                    descricao = :descricao,
                    identificador = :identificador,
                    peso = :peso,
                    preco = :preco,
                    quantidade = :quantidade,
                    maximo = :maximo
                    WHERE id = :id
                    ";
                    $con = new Connection();
                    $db = $con->connection();
                    $result = $db->prepare($this->sql);
                    $result->bindValue(':categoria', $idCategoria, \PDO::PARAM_INT);
                    $nomeProduto = base64_encode($nomeProduto);
                    $result->bindValue(':nome', $nomeProduto, \PDO::PARAM_STR);
                    $result->bindValue(':img1', $this->imageName[0], \PDO::PARAM_STR);
                    $result->bindValue(':img2', $this->imageName[1], \PDO::PARAM_STR);
                    $result->bindValue(':img3', $this->imageName[2], \PDO::PARAM_STR);
                    $descricao = base64_encode($descricao);
                    $result->bindValue(':descricao', $descricao, \PDO::PARAM_STR);
                    $result->bindValue(':identificador', $identificador, \PDO::PARAM_STR);
                    $result->bindValue(':peso', $peso, \PDO::PARAM_STR);
                    $result->bindValue(':id', $idProduto, \PDO::PARAM_INT);
                    $result->bindValue(':preco', $preco, \PDO::PARAM_STR);
                    $result->bindValue(':quantidade', $quantidade, \PDO::PARAM_INT);
                    $result->bindValue(':maximo', $maximo, \PDO::PARAM_INT);
                    if ($result->execute()) {
                        $this->message = "Dados do Produto atualizado com sucesso!<br>";
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
                    $this->message = "Desculpe, ocorreu um erro durante a execução!<br>";
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
        } else {
            $this->message = "O arquivo não é uma imagem!<br>";
            $this->link = "../produto";
            $error = new Error();
            $error->getErroMessage($this->message, $this->link);
        }
    }

    function saleChange($loja, $produto){
        $this->sql = "
                UPDATE pedidos_$loja SET
                status = :status
                WHERE id = :id
                ";
        $con = new Connection();
        $obj = $con->connection();
        $db = $obj->prepare($this->sql);
        $db->bindValue(':status', 1, \PDO::PARAM_STR);
        $db->bindValue(':id', $produto, \PDO::PARAM_STR);
        if ($db->execute()){
            return true;
        }
    }
}

?>
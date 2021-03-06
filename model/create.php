<?php
namespace User;
require_once"connection.php";
require_once"crypt.php";
class Create
{
    protected $sql;
    protected $connection;
    protected $message;
    protected $link;
    protected $line;
    protected $count;

    function setCarrinho($array)
    {
        session_start();
        $validate = true;
        $count = 0;
        foreach ($_SESSION['car'] as $values) {
            if ($values[2] === $array[2]) {
                $validate = false;
                $_SESSION['car'][$count][1] = $values[1] + $array[1];
            }
            $count++;
        }

        if ($validate) {
            $_SESSION['car'][] = $array;
            return true;
        } else {
            return true;
        }
    }

    function setPedidoLoja($endereco, $bairro, $complemento, $numero, $extras)
    {
        date_default_timezone_set('America/Cuiaba');
        $local = date("Y/m/d H:i:s")."|| Endere?o : $endereco||Bairro : $bairro||Complemento : $complemento||Numero : $numero||Detalhes Adicionais : $extras||<hr>";
        $local = base64_encode($local);
        session_start();
        $nLojas[] = 0;
        foreach ($_SESSION['car'] as $carrinho) {
            if (!in_array($carrinho[3], $nLojas)) {
                $nLojas[] = $carrinho[3];
            }
        }
        unset($nLojas[0]);
        $pedido = "";
        $precoTotal = 0;
        $total = 0;
        $status = 0;
        $this->connection = new Connection();
        $create = $this->connection->connection();

        foreach ($nLojas as $lojas) {
            foreach ($_SESSION['car'] as $carrinho) {
                if ($carrinho[3] === $lojas) {
                    $precoTotal = $carrinho[1] * $carrinho[4];
                    $total += $precoTotal;
                    $pedido .= "Nome do produto : $carrinho[0]||Quantidade : $carrinho[1]||Pre?o Unit?rio : $carrinho[4]||Pre?o conjunto : $precoTotal||<hr>";
                    $this->sql = "
                    SELECT * FROM produtos_$carrinho[3] WHERE id = :id
                      ";
                    $db = $create->prepare($this->sql);
                    $db->bindValue(':id', $carrinho[2], \PDO::PARAM_INT);
                    $db->execute();
                    $linha = $db->fetch(\PDO::FETCH_ASSOC);
                    $restante = $linha['quantidade'] - $carrinho[1];
                    $this->sql = "
                    UPDATE produtos_$carrinho[3] SET
                    quantidade = :quantidade
                    WHERE id = :id
                    ";
                    $con = new Connection();
                    $obj = $con->connection();
                    $db = $obj->prepare($this->sql);
                    $db->bindValue(':quantidade', $restante, \PDO::PARAM_INT);
                    $db->bindValue(':id', $carrinho[2], \PDO::PARAM_INT);
                    $db->execute();

                }
            }

            $pedido .= "Total : $total.";
            $pedido = base64_encode($pedido);
            $this->sql = "
            SELECT * FROM lojas WHERE id_loja = :id
            ";
            $db = $create->prepare($this->sql);
            $db->bindValue(':id', $lojas, \PDO::PARAM_INT);
            $db->execute();
            $line = $db->fetch(\PDO::FETCH_ASSOC);
            if($line['validade'] == 1){
                $this->sql = "
                INSERT INTO pedidos_$lojas (pedido,nome,celular,endereco,status)
                VALUES(:pedido,:nome,:celular,:endereco,:status)
                ";
                $db = $create->prepare($this->sql);
                $db->bindValue(':pedido', $pedido,\PDO::PARAM_STR);
                $db->bindValue(':nome', $_SESSION['user_name'], \PDO::PARAM_STR);
                $db->bindValue(':celular', $_SESSION['cell'], \PDO::PARAM_STR);
                $db->bindValue(':endereco', $local,\PDO::PARAM_STR);
                $db->bindValue(':status', $status, \PDO::PARAM_STR);
                $db->execute();

                $date = date("Y/m/d H:i:s");
                $this->sql = "
                INSERT INTO solicitacao_" . $_SESSION['id_user'] . " (pedido,loja,status,hora)
                VALUES(:pedido,:loja,:status,:hora)
                ";
                $db = $create->prepare($this->sql);
                $db->bindValue(':pedido', $pedido);
                $db->bindValue(':loja', $line['razao_social'], \PDO::PARAM_STR);
                $db->bindValue(':status', $status, \PDO::PARAM_INT);
                $db->bindValue(':hora', $date, \PDO::PARAM_STR);
                $db->execute();
                unset ($_SESSION['car']);
                header("location:http://www.primordium.com.br/user/pedidos-enviados");
            }

            else{
                $date = date("Y/m/d H:i:s");
                $class = new Crypt();
                $rand = $class->rand(10);
                $this->sql = "
                INSERT INTO pedidos_$lojas (pedido,nome,celular,endereco,status,hora,validade,identificador)
                VALUES(:pedido,:nome,:celular,:endereco,:status,:hora,:validade,:identificador)
                ";
                $db = $create->prepare($this->sql);
                $db->bindValue(':pedido', $pedido,\PDO::PARAM_STR);
                $db->bindValue(':nome', $_SESSION['user_name'], \PDO::PARAM_STR);
                $db->bindValue(':celular', $_SESSION['cell'], \PDO::PARAM_STR);
                $db->bindValue(':endereco', $local,\PDO::PARAM_STR);
                $db->bindValue(':status', $status, \PDO::PARAM_STR);
                $db->bindValue(':hora', $date, \PDO::PARAM_STR);
                $db->bindValue(':validade', 1, \PDO::PARAM_INT);
                $db->bindValue(':identificador', $rand, \PDO::PARAM_STR);
                $db->execute();

                $this->sql = "
                INSERT INTO solicitacao_" . $_SESSION['id_user'] . " (pedido,loja,status,hora,identificador)
                VALUES(:pedido,:loja,:status,:hora,:identificador)
                ";
                $db = $create->prepare($this->sql);
                $db->bindValue(':pedido', $pedido);
                $db->bindValue(':loja', $line['razao_social'], \PDO::PARAM_STR);
                $db->bindValue(':status', $status, \PDO::PARAM_INT);
                $db->bindValue(':hora', $date, \PDO::PARAM_STR);
                $db->bindValue(':identificador', $rand, \PDO::PARAM_STR);
                $db->execute();
                unset ($_SESSION['car']);
                header("location:http://www.primordium.com.br/user/pedidos-enviados");
            }

        }

    }

}
?>    
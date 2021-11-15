<?php
namespace User;
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
    function deletePedidos($user)
    {
        $this->sql = "
            DELETE  FROM solicitacao_$user
            ";
        $con = new Connection();
        $db = $con->connection();
        if ($db->query($this->sql)) {
            return true;
        }
    }
}
?>
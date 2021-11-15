<?php
session_start();
require_once"../model/read.php";
$read = new \User\Read();
$read->getPedidos($_SESSION['id_user']);
?>
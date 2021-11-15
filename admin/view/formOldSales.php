<?php
require_once"model/read.php";
$read = new \Admin\Read();
$read->getOldSales($_SESSION['idAtual']);
?>
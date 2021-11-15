<?php
require_once"../model/start.php";
$start = isset($_POST['start'])?$_POST['start']:'';
if($start == "start"){
    $s = new \Root\Start();
    $s->start();
}
?>
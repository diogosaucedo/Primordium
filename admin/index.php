<?php
ob_start();
session_start();
?>

<?php
require_once"view/cabecalho.php";
$atual = isset($_GET['pg'])?$_GET['pg']:'';
$atual = explode("-",$atual);
if(isset($_SESSION['check']) && $_SESSION['check'] == md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])){
    if(file_exists("view/$atual[0].php")){
        require_once("view/$atual[0].php");
    }
   }
else{
    require_once"view/formLogin.php";
}
ob_end_flush();
?>

</html>
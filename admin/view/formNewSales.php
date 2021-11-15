<?php
require_once"model/read.php";
$read = new \Admin\Read();
$read->getNewSales($_SESSION['idAtual']);
if(isset($_SESSION['news']) && $_SESSION['news'] > 0){
    echo"
                    <audio autoplay='autoplay'>
                        <source src='media/Rhea.mp3' type='audio/mp3'>
                    </audio>
                    ";
}
?> 
<?php
namespace Root;
class Folder{
    function createDir($filename){
        if(mkdir("../../lojas/".$filename,0777,true)) {
            return true;
        }
    }
    function deleteDir($filename){
        if(rmdir("../../lojas/".$filename)){
            return true;
        }
    }

}
?>
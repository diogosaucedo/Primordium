<?php
namespace Admin;
require_once"../../root/model/crypt.php";
class ImageFilter extends \Root\Crypt{
    private $ext;
    private $randValue;
    private $name;
    function fileName($file,$productName){


        switch($file['type']){
            case "image/jpeg";
            case "image/pjpeg";
                $this->ext = ".jpg";
                break;
            case "image/png";
                $this->ext = ".png";
                break;
            case "image/gif";
                $this->ext = ".gif";
                break;
        }
        $this->randValue = self::rand(21);
        $this->name = md5($productName.$this->randValue.time()).$this->ext;
        return $this->name;
    }
    function fileType($file){
        if(!empty($file['name'])){
            if($file['type'] == 'image/jpeg' || $file['type'] == 'image/pjpeg' || $file['type'] == 'image/png' || $file['type'] == 'image/gif'){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return true;
        }
    }
    function fileSize($file){
        if(!empty($file['name'])){
            if($file['size'] <= 10485760){
                return true;
            }
            else{
                return false;
            }
        }else{
            return true;
        }



    }
}
?>
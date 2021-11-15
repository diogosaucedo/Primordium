<?php
namespace Root;
/**
 * Classe responsavel por fazer a validação dos inputs
 * Class Validation
 * @package Root
 */
class Validation{
    /**
     * Recebe a expressão regular
     * @var $pattern
     */
    protected $pattern;

    /**
     * Esta função e responsavel por validar email
     * @param string $email Recebe o email que ira passar pela validação
     * @return bool Se passar na validação, retorna verdadeiro, se não, retorna falso.
     */
    function filterEmail($email){
        $this->pattern = "/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/";
        if(preg_match($this->pattern,$email)){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Esta função valida CNPJ
     * @param string $documento Recebe CNPJ
     * @return bool Se passar na validação, retorna verdadeiro, se não, retorna falso.
     */
    function filterCpfCnpj($documento){
        $this->pattern ="/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/";
        if(preg_match($this->pattern,$documento)){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Responsavel por validar numero de telefone celular.
     * @param string $numero Recebe numero de telefone celular
     * @return bool Se passar na validação, retorna verdadeiro, se não, retorna falso.
     */
    function filteCelular($numero){
        $this->pattern="/^[0-9]{2,3}[0-9]{8,9}|[(]{1}[0-9]{2,3}[)]{1}[0-9]{8,9}$/";
        if(preg_match($this->pattern,$numero)){
            return true;
        }
        else{
            return false;
        }

    }

}

?>
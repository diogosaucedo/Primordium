<?php
namespace User;
/**
 * Esta Classe e responsavel por criptografar strings que serão inseridas no banco de dados.
 *
 * Class Crypt
 * @package Root
 */
class Crypt{
    /**
     * Este atributo recebe durante a execução uma string gerada de forma randomica
     * contendo quantos caracteres forem necessarios.
     * @var $retorno
     */
    protected $retorno;
    /**
     * Este atributo recebe uma lista de caracteres, que serão usados para gerar uma string randomica.
     * @var $caracteres
     */
    protected $caracteres;
    /**
     * Este atributo recebe o valor final, ou seja a string criptografada com bcrypt.
     * @var $hash
     */
    protected $hash;

    /**Esta função e responsavel por gerar uma string randomica.
     * @param int $size Recebe o tamanho(caracteres) que  string deve possuir.
     * @return mixed
     */
   function rand($size){
// Caracteres de cada tipo
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';


// Agrupamos todos os caracteres que poderão ser utilizados
        $this->caracteres .= $lmin;
        $this->caracteres .= $lmai;
        $this->caracteres .= $num;

// Calculamos o total de caracteres possíveis
        $len = strlen($this->caracteres);

        for ($n = 1; $n <= $size; $n++) {
// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
            $rand = mt_rand(1, $len);
// Concatenamos um dos caracteres na variável $retorno
            $this->retorno .= $this->caracteres[$rand-1];
        }
        return $this->retorno;
    }

    /**
     * Esta função e responvel por criptografar uma string de qualquer valor.
     *
     * @param string $valor Recebe o valor que ira ser criptografado.
     * @return string Retorna uma string de 60 caracteres criptografados.
     */

  public function hashValue($valor){

        $custo = '08';
        $salt = $this->rand(22);

        $this->hash = crypt($valor, '$2a$' . $custo . '$' . $salt . '$');
        return $this->hash;
    }

    /**
     * Função responsavel por desalocar da memoria as informações geradas durante a execução.
     */
    function __destruct(){

    }

}
?>
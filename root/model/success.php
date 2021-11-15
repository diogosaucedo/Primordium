<?php
namespace Root;
/**
 * Esta Classe apresenta as mensagens de sucesso.
 * Class Success
 * @package Root
 */
class Success{
    /**
     * Esta função gera as mensagens de sucesso.
     * @param string $mensagem Recebe a mensagem.
     * @param string $link Recebe o link de redirecionamento.
     */
    function getSuccessMessage($mensagem,$link){
        echo"
            <head>
                <title>Primordium</title>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1'>
                <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
                <script type='text/javascript' src='http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
                <link href='http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css'
                      rel='stylesheet' type='text/css'>
                <link href='http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css'
                      rel='stylesheet' type='text/css'>
            </head>

            <div class='view'>
                <div class='alert alert-success alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h4>Sucesso!</h4>
                    <strong>Mensagem!</strong> ".$mensagem." <a href='".$link."' class='btn btn-default'>Voltar</a>
                </div>
            </div>
                ";

    }

    /**
     * desaloca da memoria informações geradas durante a execução.
     */
    function __destruct(){

    }
}
?>
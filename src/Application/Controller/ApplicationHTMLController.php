<?php

    namespace Application\Controller;

    /**
     * Application HTML Controller
     * 
     * @author Pedro Greg�rio <phsgregorio@gmail.com>
     */
    abstract class ApplicationHTMLController {

        protected $mensagens;

        /**
         * ApplicationHTMLController Constructor
         */
        function __construct() {
            $this->mensagens = array();
        }

        /**
         * @name setDefaultHeader
         * 
         * Retorna o cabeçalho padrão de resposta da aplicação
         * 
         */
        protected function setDefaultHeader() {

            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Content-Type: text/html; charset=utf-8');
        }
        
        /**
         * @name addMessage
         * 
         * @param String $tipo Tipo da mensagem a ser informada
         * @param String $descricao Descrição da mensagem
         */
        protected function addMessage($tipo, $mensagem) {
            array_push($this->mensagens, array("tipo" => $tipo, "descricao" => $mensagem));
        }
    }
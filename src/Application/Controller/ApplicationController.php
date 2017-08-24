<?php

    namespace Application\Controller;

    use Application\ApplicationBootstrap;
    
    /**
     * @name ApplicationController
     * @version 1.0
     * 
     * @author Pedro Greg�rio <phsgregorio@gmail.com>
     * 
     * Classe utilizada para fazer o controle de requisi��es da aplica��o.
     * Esse controle gen�rico pode ser acesso tanto atrav�s de um mapeamento
     * de url ou de um pr�prio arquivo PHP.
     * 
     * Para alterar o rederecionamento das requi��es HTTP alterar o arquivo
     * de configura��o do diret�rio do seu servidor de aplica��es. Para o apache
     * por exemplo configurar o arquivo httpd.conf para gerenciar as URLs enviadas
     * para a aplica��o.
     * 
     * mod_dir FallbackResource /{application_context}/index.php
     * 
     * @property String $baseUrl Url base da aplica��o WEB
     * @property String $requestedUrl Url solicitada pelo navegador
     * @property String $method M�todo utilizado para fazer a solicita��o
     * @property String $controllerContext Contexto da aplica��o
     * @property String $controllerPath Diret�rio f�sico dos controllers da aplica��o
     * @property String $controllerName Nome do controle solicitado
     * @property String $controllerFile Arquivo responsável pela solicita��o
     * 
     */
    class ApplicationController {
        
        private $baseUrl;
        private $basePath;
        
        private $requestedUrl;
        private $method;
        private $contentType;
        
        private $controllerContext;
        private $controllerPath;
        private $controllerName;
        
        private static $fowardError = "FowardError.php";

        /**
         * Construtor
         * 
         * @name __construct
         * 
         * @param String $baseUrl Rair da Url da aplica��o
         * @param String $requestedUrl Url Solicitada pelo sistema
         */
        public function __construct($requestedUrl, $method, $contentType) {
            
            $this->baseUrl = ApplicationBootstrap::getInstance()->getBaseUrl();
            $this->basePath = ApplicationBootstrap::getInstance()->getBasePath();
            
            $this->requestedUrl = "http://" . $requestedUrl;
            $this->method = $method;
            $this->contentType = $contentType;
            
            $this->controllerContext = ""; // basename(__FILE__)
            $this->controllerPath = "\\Application\\Controller\\";
        }

        /**
         * @name validateUrlParameters
         * 
         * Valida os par�metros informados
         * 
         * @param Array $getParams Par�metros informados ao controller
         */
        public function validateUrlParameters($getParams) {

            $return = true;
            
            // Par�metros insuficientes
            if (count($getParams)<2) {
                $return = false;
            // Os par�metros informados n�o foram preenchidos corretamente
            } else if (empty($getParams[0]) || empty ($getParams[1])) {
                $return = false;
            }
            
            return $return;
        }

        /**
         * @name fowardApllication
         * 
         * Inst�ncia o controle solicitado e faz o foward para o aciton solicitado
         */
        public function fowardApllication() {
            
            $return = self::$fowardError;

            $requestString = substr($this->requestedUrl, strlen($this->baseUrl . $this->controllerContext)-1);
            $getParams = explode('/', $requestString);

            // Válida os par�metros informados
            if ($this->validateUrlParameters($getParams)) {

                // Recupera os nomes do controle e do action
                $controllerName = ucfirst(array_shift($getParams)) . 'Controller';
                $actionName = $this->method . array_shift($getParams) . 'Action';
                
                $this->controllerName = $this->controllerPath . $controllerName;

                if (class_exists($this->controllerName)) {
                    
                    // Inst�ncia nova classe atrav�s de Namespaces
                    $controller = new $this->controllerName();

                    if (method_exists($controller, $actionName)) {
                        
                        // Faz a chamada do action definido por par�metro
                        try {
                            $return = call_user_func_array(array($controller, $actionName), $getParams);
                        } catch (\Exception $ex) {
                            echo $ex->getMessage();
                        }
                    } else {
                        http_response_code(404);
                    }
                } else {
                     http_response_code(404);
                }
            } else {
                http_response_code(404);
            }
        }
    }
<?php

    namespace Application\Controller;

    use Application\ApplicationBootstrap;
    
    /**
     * @name ApplicationController
     * @version 1.0
     * 
     * @author Pedro Gregório <phsgregorio@gmail.com>
     * 
     * Classe utilizada para fazer o controle de requisições da aplicação.
     * Esse controle genérico pode ser acesso tanto através de um mapeamento
     * de url ou de um próprio arquivo PHP.
     * 
     * Para alterar o rederecionamento das requições HTTP alterar o arquivo
     * de configuração do diretório do seu servidor de aplicações. Para o apache
     * por exemplo configurar o arquivo httpd.conf para gerenciar as URLs enviadas
     * para a aplicação.
     * 
     * mod_dir FallbackResource /{application_context}/index.php
     * 
     * @property String $baseUrl Url base da aplicação WEB
     * @property String $requestedUrl Url solicitada pelo navegador
     * @property String $method Método utilizado para fazer a solicitação
     * @property String $controllerContext Contexto da aplicação
     * @property String $controllerPath Diretório físico dos controllers da aplicação
     * @property String $controllerName Nome do controle solicitado
     * @property String $controllerFile Arquivo responsÃ¡vel pela solicitação
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
         * @param String $baseUrl Rair da Url da aplicação
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
         * Valida os parâmetros informados
         * 
         * @param Array $getParams Parâmetros informados ao controller
         */
        public function validateUrlParameters($getParams) {

            $return = true;
            
            // Parâmetros insuficientes
            if (count($getParams)<2) {
                $return = false;
            // Os parâmetros informados não foram preenchidos corretamente
            } else if (empty($getParams[0]) || empty ($getParams[1])) {
                $return = false;
            }
            
            return $return;
        }

        /**
         * @name fowardApllication
         * 
         * Instância o controle solicitado e faz o foward para o aciton solicitado
         */
        public function fowardApllication() {
            
            $return = self::$fowardError;

            $requestString = substr($this->requestedUrl, strlen($this->baseUrl . $this->controllerContext)-1);
            $getParams = explode('/', $requestString);

            // VÃ¡lida os parâmetros informados
            if ($this->validateUrlParameters($getParams)) {

                // Recupera os nomes do controle e do action
                $controllerName = ucfirst(array_shift($getParams)) . 'Controller';
                $actionName = $this->method . array_shift($getParams) . 'Action';
                
                $this->controllerName = $this->controllerPath . $controllerName;

                if (class_exists($this->controllerName)) {
                    
                    // Instância nova classe através de Namespaces
                    $controller = new $this->controllerName();

                    if (method_exists($controller, $actionName)) {
                        
                        // Faz a chamada do action definido por parâmetro
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
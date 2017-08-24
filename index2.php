<?php

    /**
     * Application Action foward
     * 
     * @version 1.0
     * 
     * @author Pedro Gregório  <phsgregorio@gmail.com>
     * 
     * Arquivo destinado ao controle de requisições enviadas a aplicação WEB do
     * Ecommerce. As URLs enviadas foram formatadas no padrão similar de uma aplicação
     * REST, exemplo:
     * 
     * Para enviar um amail através da aplicação utilizamos a seguinte URL
     * https://{HOST}/{APP}/{Controller}/{Action}/
     * 
     * Esse arquivo faz a gerência da URL e dos dados fornecidados através da
     * requisição e implementa um padrão para normalização do sistema.
     * 
     */
    require_once "src/Application/ApplicationBootstrap.php";
    
    use Application\ApplicationBootstrap;
    use Application\ApplicationSession;
    use Application\Controller\ApplicationController;

    // Init configurations and Singletons for the entire application cycle
    $applicationSettings = ApplicationBootstrap::getInstance();
    $applicationSession = ApplicationSession::getInstance();

    // Set Request Application Parameters
    $requestedUrl = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $requestedMethod = $_SERVER['REQUEST_METHOD'];
    $contentType = empty($_SERVER['CONTENT_TYPE']) ? "" : $_SERVER['CONTENT_TYPE'];

    // Foward Application Requests
    $applicationController = new ApplicationController($requestedUrl, $requestedMethod, $contentType);
    $applicationController->fowardApllication();
?>
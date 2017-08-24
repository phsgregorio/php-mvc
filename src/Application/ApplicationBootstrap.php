<?php

    namespace Application;
    
    use Doctrine\ORM\Tools\Setup;
    use Doctrine\ORM\EntityManager;

    require_once "vendor/autoload.php";
    
    /**
     * @name ApplicationBootstrap
     * @version 1.0
     * 
     * @author Pedro GregÃ³rio <phsgregorio@gmail.com>
     * 
     * Singleton destinado a manter disponível as configuraçÃµes da aplicação
     * para todo o contexto do sistema. Os valores dessa classe são atribuidos
     * apenas na primeira chamada.
     * 
     * @property String $context Contexto da aplicação WEB
     * @property String $baseUrl Url base da aplicação
     * @property String $basePath Diretório físico da aplicação
     * 
     * @property EntityManager $entityManager
     * 
     * @property ApplicationSettings $instance Singleton
     */
    class ApplicationBootstrap {

        private $context;
        private $baseUrl;
        private $basePath;
        
        private $entityManager;

        /**
         * 
         * @var ApplicationBootstrap
         */
        private static $instance = null;
        
        
        /**
         * @name __construct
         * 
         * @param String $context Contexto utilizado pela aplicação no servidor
         * @param String $host Url do host da aplicação
         * @param String $root Path físico da aplicação
         */        
        function __construct($context, $host, $root) {
            
            $this->context = $context;
            $this->baseUrl = $host . $this->getContext() . "/";
            $this->basePath = $root .$context . "/";

            // Load entity configuration from PHP file annotations in dev mode(true)
            $config = Setup::createAnnotationMetadataConfiguration(
                    array(__DIR__."/src"), true);
            
            // Set System Application Entity Manager
            $this->entityManager = EntityManager::create(
                    ApplicationDatasources::$DEVELOPER_DATASOURCES['comercio'], 
                    $config);
        }

        public static function getInstance() {

            if ( is_null( self::$instance ) ) {
                self::$instance = new self("phpunit", "https://localhost/", "C:/wamp64/www/");
            }

            return self::$instance;
        }
        
        function getContext() {
            return $this->context;
        }

        function getBaseUrl() {
            return $this->baseUrl;
        }

        function getBasePath() {
            return $this->basePath;
        }

        function getEntityManager() {
            return $this->entityManager;
        }
    }
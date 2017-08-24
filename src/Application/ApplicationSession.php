<?php

    namespace Application;

    // Session Controll
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    /**
     * @name ApplicationSession
     * 
     * @author Pedro Gregório <phsgregorio@gmail.com>
     * 
     */
    class ApplicationSession {
        
        private $administrador = null;
        
        /**
         * 
         * @var ApplicationSession
         */
        private static $instance;

        public function __construct() {

            if (isset($_SESSION) && array_key_exists("administrador", $_SESSION) && !empty($_SESSION['administrador'])) {
                self::$administrador = unserialize($_SESSION["administrador"]);
            }
        }

        public static function getInstance() {
            
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        static function getAdministrador() {
            return $this->administrador;
        }
    }
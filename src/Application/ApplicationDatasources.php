<?php

    namespace Application;

    class ApplicationDatasources {
        
        public static $DEVELOPER_DATASOURCES = array(
            "comercio" => array(
                'driver'   => 'pdo_mysql',
                'host'     => '127.0.0.1',
                'dbname'   => 'comercio',
                'user'     => 'root',
                'password' => ''
            )
        );
        
        public static $TEST_DATASOURCES = array();
        
        public static $PRODUCTION_DATASOURCES = array();
    }
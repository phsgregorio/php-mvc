<?php

    namespace Application\DAO;
    
    use Application\Entity\Categoria;

    class CategoriaDAO extends ApplicationDAO {

        function __construct() {
            parent::__construct();
        }
        
        protected function getEntity() {
            return Categoria::class;
        }
    }
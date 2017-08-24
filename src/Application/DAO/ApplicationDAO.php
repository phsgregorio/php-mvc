<?php

    namespace Application\DAO;
    
    use Application\ApplicationBootstrap;

    abstract class ApplicationDAO {

        protected $entityManager = null;

        function __construct() {
            $this->entityManager = ApplicationBootstrap::getInstance()->getEntityManager();
        }
        
        abstract protected function getEntity();
        
        protected function getEntityManager() {
            return $this->entityManager;
        }

        public function getById($id) {
            return $this->getEntityManager()->getRepository($this->getEntity())->find($id);
        }
        
        public function getAll() {
            return $this->getEntityManager()->getRepository($this->getEntity())->findAll();
        }

        public function insert($entity) {
            
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();
        }
        
        public function update($entity) {
            
            $this->getEntityManager()->merge($entity);
            $this->getEntityManager()->flush();
        }

        public function delete($entity) {

            $this->getEntityManager()->remove($entity);
            $this->getEntityManager()->flush();
        }
    }

<?php

    namespace Application\Service;
    
    use Application\DAO\CategoriaDAO;
    use Application\Entity\Categoria;
    
    class CategoriaService {

        private $categoriaDAO;
        
        function __construct() {
            $this->categoriaDAO = new CategoriaDAO();
        }
        
        public function getById($id) {
            return $this->categoriaDAO->getById($id);
        }
        
        public function getAll(){
            return $this->categoriaDAO->getAll();
        }
        
        public function fillObjectWithPOST($parameters) {
            
            $categoria = new Categoria();
            $categoria->setId_categoria($parameters['id_categoria']);
            $categoria->setNome($parameters['nome']);

            return $categoria;
        }

        public function insert(Categoria $categoria) {

            if (empty($categoria->getNome())) {
                throw new \Exception("Os campos obrigatórios devem ser devidamente preenchidos");
            } else {

                if (!empty($categoria->getId_categoria())) {
                    return $this->categoriaDAO->update($categoria);
                } else {
                    return $this->categoriaDAO->insert($categoria);
                }
            }
        }

        public function delete($id_categoria) {
            return $this->categoriaDAO->delete($id_categoria);
        }
    }
<?php

    namespace Application\Controller;
    
    use Application\Enum\ApplicationMessage;
    use Application\Service\CategoriaService;
    use Application\Entity\Categoria;

    /**
     * Ecommerce Categoria Controller
     * 
     * @author Pedro Gregório <phsgregorio@gmail.com>
     */
    class CategoriaController extends ApplicationHTMLController {
        
        private $categoriaService;
        
        /**
         * CategoriaController Constructor
         */
        function __construct() {
            
            parent::__construct();
            
            $this->categoriaService = new CategoriaService();
        }
        
        /**
         * @name GETlistAction
         * 
         * @author Pedro Gregório <phsgregorio@gmail.com>
         */
        public function GETlistAction() {

            $this->setDefaultHeader();
            $categorias = array();

            try {

                $categorias = $this->categoriaService->getAll();
                
                var_dump($categorias);

            } catch (\Exception $ex) {
                $this->addMessage(ApplicationMessage::ERROR, "Falha ao recuperar categorias");
            }

            // View
            $mensagens = $this->mensagens;
            $collection = $categorias;
            
            var_dump($mensagens);

            // include 'web/categoria_list.php';
        }
        
        /**
         * @name GETcreateAction
         * 
         * @author Pedro Gregório <phsgregorio@gmail.com>
         */
        public function GETcreateAction() {

            $this->setDefaultHeader();
            
            
            try {
                
            } catch (\Exception $ex) {
                $this->addMessage(ApplicationMessage::ERROR, "Falha ao recuperar lista de unidades.");
            }

            // View
            $mensagens = $this->mensagens;

            // include 'web/categoria.php';
        }
        
        /**
         * @name POSTinsertAction
         * 
         * @author Pedro Gregório <phsgregorio@gmail.com>
         */
        public function POSTinsertAction() {

            $this->setDefaultHeader();
            $categoria = new Categoria();
            
            try {

                // Atualiza ou salva registro
                $categoria = $this->categoriaService->fillObjectWithPOST($_POST);
                $id_categoria = $this->categoriaService->insert($categoria);

                $this->addMessage(ApplicationMessage::SUCCESS, "Categoria salvo com sucesso");
                return $this->GETlistAction();
                
            } catch (\Exception $ex) {

                $this->addMessage(ApplicationMessage::ERROR, "Falha ao cadastrar novo categoria");
            }

            // View
            $mensagens = $this->mensagens;
            // include 'web/categoria.php';
        }
        
        /**
         * @name GETeditAction
         * 
         * @author Pedro Gregório <phsgregorio@gmail.com>
         */
        public function GETeditAction($id_categoria) {

            $this->setDefaultHeader();
            $categoria = new Categoria();

            if (empty($id_categoria)) {
                $this->addMessage(ApplicationMessage::ERROR, "Um categoria deve ser informado para sua edição");
            } else {

                try {

                    // Recupera as inforamaÃ§Ãµes do categoria
                    $categoria = $this->categoriaService->getById($id_categoria);
                    
                    var_dump($categoria);
                } catch (\Exception $ex) {
                    $this->addMessage(ApplicationMessage::ERROR, "Falha ao recuperar informações do categoria");
                }
            }

            // View
            $mensagens = $this->mensagens;
            // include 'web/categoria.php';
        }
        
        /**
         * @name GETdeleteAction
         * 
         * @author Pedro Gregório <phsgregorio@gmail.com>
         */
        public function GETdeleteAction($id_categoria = null) {

            $this->setDefaultHeader();

            if (empty($id_categoria)) {
                $this->addMessage(ApplicationMessage::ERROR, "Uma categoria deve ser informada para a efetuar a exclusão");
            } else {

                try {
                    $this->categoriaService->delete($id_categoria);
                    $this->addMessage(ApplicationMessage::SUCCESS, "Categoria removida com sucesso");
                } catch (\Exception $ex) {
                    $this->addMessage(ApplicationMessage::ERROR, "Falha ao excluir informações do categoria");
                }
            }

            return $this->GETlistAction();
        }
    }
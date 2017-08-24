<?php

    require 'bootstrap.php';

	use PHPUnit_Framework_TestCase as PHPUnit;
	use Application\Service\CategoriaService;

	class CategoriaServicoTest extends PHPUnit {
	    
	    private $categoriaServico;
		
		public function setUp() {
			$this->categoriaServico = new CategoriaService();
		}
		
		public function testGetAll() {
		    
		    $categorias = $this->categoriaServico->getAll();
		    
		    $this->assertEquals(true, is_array($categorias), "Falha ao recuperar categorias");
		    $this->assertNotEquals(false, count($categorias)>0, "Falha ao recuperar categorias");
		}

		public function tearDown() {
		    
		}
	}
?>
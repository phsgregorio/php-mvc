<?php

    namespace Application\Entity;

    /**
     * @Entity @Table(name="categoria")
     **/
    class Categoria {

        /** @Id @Column(type="integer") @GeneratedValue **/
        protected $id_categoria;

        /** @Column(type="string") **/
        protected $nome;

        function getId_categoria() {
            return $this->id_categoria;
        }

        function getNome() {
            return $this->nome;
        }

        function setId_categoria($id_categoria) {
            $this->id_categoria = $id_categoria;
        }

        function setNome($nome) {
            $this->nome = $nome;
        }
    }
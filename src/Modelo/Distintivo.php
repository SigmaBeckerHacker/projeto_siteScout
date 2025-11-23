<?php
    class Distintivo
    {
        private int $id;
        private string $nome;
        private int $quantidade;
        private string $categoria;
        private string $imagem;


        public function __construct(int $id, string $nome, int $quantidade, string $categoria, string $imagem){
            $this->id = $id;
            $this->nome = $nome;
            $this->quantidade = $quantidade;
            $this->categoria = $categoria;
            $this->imagem = $imagem;
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getNome(): string
        {
            return $this->nome;
        }

        public function getQuantidade(): int
        {
            return $this->quantidade;
        }

        public function getCategoria(): string
        {
            return $this->categoria;
        }

        public function getImagem(): string
        {
            return $this->imagem;
        }



    }


?>
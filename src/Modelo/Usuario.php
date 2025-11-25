<?php
    class Usuario
    {
        private int $registro;
        private string $nome;
        private string $funcao;
        private string $email;

        public function __construct(int $registro, string $nome, string $funcao, string $email){
            $this->registro = $registro;
            $this->nome = $nome;
            $this->funcao = $funcao;
            $this->email = $email;

        }

        public function getRegistro(): int
        {
            return $this->registro;
        }

        public function getNome(): string
        {
            return $this->nome;
        }

        public function getFuncao(): string
        {
            return $this->funcao;
        }

        public function getEmail(): string
        {
            return $this->email;
        } 

    }

?>
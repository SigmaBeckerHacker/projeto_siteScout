<?php
    class Escoteiro
    {
        private int $registro;
        private string $nome;
        private string $ramo;

        public function __construct(int $registro, string $nome, string $ramo){
            $this->registro = $registro;
            $this->nome = $nome;
            $this->ramo = $ramo;

        }

        public function getRegistro(): int
        {
            return $this->registro;
        }

        public function getNome(): string
        {
            return $this->nome;
        }

        public function getRamo(): string
        {
            return $this->ramo;
        }

    }

?>²
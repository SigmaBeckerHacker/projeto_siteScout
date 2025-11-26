<?php

require_once __DIR__ . '/Usuario.php';

class Requisicao
{
    private int $id;
    private string $distintivo;
    private string $data;        
    private Usuario $chefe;

    public function __construct(int $id, string $distintivo, string $data, Usuario $chefe)
    {
        $this->id = $id;
        $this->distintivo = $distintivo;
        $this->data = $data;
        $this->chefe = $chefe;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDistintivo(): string
    {
        return $this->distintivo;
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setDistintivo(string $distintivo): void
    {
        $this->distintivo = $distintivo;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }
    
    public function getChefe(): Usuario
    {
        return $this->chefe;
    }

    public function setChefe(Usuario $chefe): void
    {
        $this->chefe = $chefe;
    }
}

?>
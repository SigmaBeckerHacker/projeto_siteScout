<?php

class Requisicao
{
    private int $id;
    private String $distintivo;
    private string $data;      
    private string $status;    

    public function __construct(int $id, string $distintivo, string $data, string $status)
    {
        $this->id = $id;
        $this->distintivo = $distintivo;
        $this->data = $data;
        $this->status = $status;
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

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setDistintivo(string $distintivo): void
    {
        $this->distintivo = $distintivo;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}

?>
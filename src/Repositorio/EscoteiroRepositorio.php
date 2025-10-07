<?php

class EscoteiroRepositorio{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Escoteiro
    {
        return new Escoteiro((int)$dados['nome'],$dados['registro'],$dados['ramo']);
    }

    public function buscarPorNome(string $nome): ?Escoteiro
    {
        $sql = "SELECT registro, nome, ramo FROM tbEscoteiro WHERE nome =?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1,$nome);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados): null;
    }


    public function salvar(Escoteiro $escoteiro): void
    {
        $sql = "INSERT INTO tbEscoteiro(nome, registro, ramo) VALUES (?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $escoteiro->getNome());
        $stmt->bindValue(2, $escoteiro->getRegistro());
        $stmt->bindValue(3, $escoteiro->getRamo());
        $stmt->execute();

    }

    public function deletarEscoteiro($registro) {
    $stmt = $this->pdo->prepare("DELETE FROM tbEscoteiro WHERE registro = :registro");
    $stmt->bindValue(':registro', $registro);
    $stmt->execute();
}
}

?>
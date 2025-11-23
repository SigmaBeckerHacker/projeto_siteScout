<?php

class EscoteiroRepositorio {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto($linha): Escoteiro
    {
        return new Escoteiro(
        (int)$linha['registro'], 
        $linha['nome'],          
        $linha['ramo']);
    }

  
    public function buscarPorRegistro(int $registro): ?Escoteiro
    {
        $sql = "SELECT nome, registro, ramo FROM tbEscoteiro WHERE registro = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $registro);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT nome, registro, ramo FROM tbEscoteiro ORDER BY nome";
        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    return array_map(
        fn($linha) => $this->formarObjeto($linha),
        $rs);
    }


    public function buscarPorNome(string $nome): ?Escoteiro
    {
        $sql = "SELECT nome, registro, ramo FROM tbEscoteiro WHERE nome = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $nome);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

  
    public function salvar(Escoteiro $escoteiro): void
    {
        $sql = "INSERT INTO tbEscoteiro (nome, registro, ramo) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $escoteiro->getNome(),
            $escoteiro->getRegistro(),
            $escoteiro->getRamo()
        ]);
    }


    public function atualizar(Escoteiro $escoteiro): void
    {
        $sql = "UPDATE tbEscoteiro SET nome = ?, ramo = ? WHERE registro = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $escoteiro->getNome(),
            $escoteiro->getRamo(),
            $escoteiro->getRegistro()
        ]);
    }


    public function excluirEscoteiro(int $registro): void
    {
        $sql = "DELETE FROM tbEscoteiro WHERE registro = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$registro]);
    }
}
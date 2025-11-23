<?php

class DistintivoRepositorio {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto($linha): Distintivo
    {
        return new Distintivo(
            (int)$linha['id_distintivo'],
            $linha['nome_distintivo'],
            (int)$linha['quantidade'],
            $linha['categoria_distintivo'],
            $linha['imagem']
        );
    }

    public function buscarPorId(int $id): ?Distintivo
    {
        $sql = "SELECT id_distintivo, nome_distintivo, quantidade, categoria_distintivo, imagem 
                FROM tbDistintivo 
                WHERE id_distintivo = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT id_distintivo, nome_distintivo, quantidade, categoria_distintivo, imagem 
                FROM tbDistintivo 
                ORDER BY nome_distintivo";

        $rs = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            fn($linha) => $this->formarObjeto($linha),
            $rs
        );
    }

    public function buscarPorNome(string $nome): ?Distintivo
    {
        $sql = "SELECT id_distintivo, nome_distintivo, quantidade, categoria_distintivo, imagem 
                FROM tbDistintivo 
                WHERE nome_distintivo = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $nome);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function salvar(Distintivo $distintivo): void
    {
        $sql = "INSERT INTO tbDistintivo (nome_distintivo, quantidade, categoria_distintivo, imagem)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $distintivo->getNome(),
            $distintivo->getQuantidade(),
            $distintivo->getCategoria(),
            $distintivo->getImagem()
        ]);
    }

    public function atualizar(Distintivo $distintivo): void
    {
        $sql = "UPDATE tbDistintivo 
                SET nome_distintivo = ?, quantidade = ?, categoria_distintivo = ?, imagem = ?
                WHERE id_distintivo = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $distintivo->getNome(),
            $distintivo->getQuantidade(),
            $distintivo->getCategoria(),
            $distintivo->getImagem(),
            $distintivo->getId()
        ]);
    }

    public function excluirDistintivo(int $id): void
    {
        $sql = "DELETE FROM tbDistintivo WHERE id_distintivo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}
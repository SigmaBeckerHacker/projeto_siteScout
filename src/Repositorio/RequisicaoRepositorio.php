<?php

class RequisicaoRepositorio {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto(array $linha): Requisicao
    {
       
    

        return new Requisicao(
            (int)$linha['id_requisicao'],
            $distintivo['distintivo'],                
            $linha['data_requisicao'],   
            $linha['status_requisicao']
        );
    }

    public function buscarPorId(int $id): ?Requisicao
    {
        $sql = "SELECT id_requisicao, distintivo, data_requisicao, status_requisicao
                FROM tbRequisicao
                WHERE id_requisicao = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function buscarTodos(): array
    {
        $sql = "SELECT id_requisicao, distintivo, data_requisicao, status_requisicao
                FROM tbRequisicao
                ORDER BY data_requisicao DESC";

        $rows = $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            fn($linha) => $this->formarObjeto($linha),
            $rows
        );
    }

    public function salvar(Requisicao $r): void
    {
        $sql = "INSERT INTO tbRequisicao (distintivo, data_requisicao, status_requisicao)
                VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $r->getDistintivo(),   
            $r->getData(),         
            $r->getStatus()
        ]);
    }

    public function atualizar(Requisicao $r): void
    {
        $sql = "UPDATE tbRequisicao
                SET distintivo = ?, data_requisicao = ?, status_requisicao = ?
                WHERE id_requisicao = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $r->getDistintivo(),   
            $r->getData(),
            $r->getStatus(),
            $r->getId()
        ]);
    }

    public function excluir(int $id): void
    {
        $sql = "DELETE FROM tbRequisicao WHERE id_requisicao = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
}

?>
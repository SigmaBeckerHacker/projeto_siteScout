<?php

require_once __DIR__ . '/../Modelo/Requisicao.php';
require_once __DIR__ . '/../Repositorio/UsuarioRepositorio.php';

class RequisicaoRepositorio {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    private function formarObjeto(array $linha): Requisicao
    {
        
        $usuarioRepo = new UsuarioRepositorio($this->pdo);
        $chefe = $usuarioRepo->buscarPorRegistro((int)$linha['registroChefe']);

        return new Requisicao(
            (int)$linha['id_requisicao'],
            $linha['distintivo'],                
            $linha['data_requisicao'],   
            $chefe
        );
    }

    public function buscarPorId(int $id): ?Requisicao
    {
        $sql = "SELECT id_requisicao, distintivo, data_requisicao, registroChefe AS registroChefe
                FROM tbRequisicao
                WHERE id_requisicao = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function contarTodos(): int
    {
        $sql = "SELECT COUNT(*) as total FROM tbRequisicao";
        $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    public function buscarTodos(int $limit = 10, int $offset = 0, string $sort = 'data_requisicao', string $order = 'DESC'): array
    {
        $allowedSort = ['id_requisicao', 'distintivo', 'data_requisicao', 'status_requisicao', 'registroChefe'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'data_requisicao';
        }

        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT id_requisicao, distintivo, data_requisicao, registroChefe AS registroChefe
                FROM tbRequisicao
                ORDER BY $sort $order
                LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            fn($linha) => $this->formarObjeto($linha),
            $rows
        );
    }

    public function contarPorRegistroChefe(int $registroChefe): int
    {
        $sql = "SELECT COUNT(*) as total FROM tbRequisicao WHERE registroChefe = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $registroChefe, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    public function buscarPorRegistroChefe(int $registroChefe, int $limit = 10, int $offset = 0, string $sort = 'data_requisicao', string $order = 'DESC'): array
    {
        $allowedSort = ['id_requisicao', 'distintivo', 'data_requisicao', 'status_requisicao', 'registroChefe'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'data_requisicao';
        }

        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT id_requisicao, distintivo, data_requisicao, registroChefe AS registroChefe
                FROM tbRequisicao
            WHERE registroChefe = ?
                ORDER BY $sort $order
                LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $registroChefe, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            fn($linha) => $this->formarObjeto($linha),
            $rows
        );
    }

    public function salvar(Requisicao $r): void
    {
        $sql = "INSERT INTO tbRequisicao (distintivo, data_requisicao, registroChefe)
                VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $r->getDistintivo(),   
            $r->getData(),         
            $r->getChefe()->getRegistro()
        ]);
    }

    public function atualizar(Requisicao $r): void
    {
        $sql = "UPDATE tbRequisicao
            SET distintivo = ?, data_requisicao = ?, registroChefe = ?
            WHERE id_requisicao = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $r->getDistintivo(),   
            $r->getData(),
            $r->getChefe()->getRegistro(),
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
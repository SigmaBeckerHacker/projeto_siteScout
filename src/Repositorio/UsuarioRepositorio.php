<?php

class UsuarioRepositorio {
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto($linha): Usuario
    {
        return new Usuario(
        (int)$linha['registro'], 
        $linha['nome'],          
        $linha['funcao'],
        $linha['email']);
    }

  
    public function buscarPorRegistro(int $registro): ?Usuario
    {
        $sql = "SELECT nome, registro, funcao, email FROM tbUsuario WHERE registro = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $registro);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function contarTodos(): int
    {
        $sql = "SELECT COUNT(*) as total FROM tbUsuario";
        $row = $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        return (int)$row['total'];
    }

    public function buscarTodos(int $limit = 10, int $offset = 0, string $sort = 'nome', string $order = 'ASC'): array
    {
        $allowedSort = ['nome', 'registro', 'funcao', 'email'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'nome';
        }

        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT nome, registro, funcao, email FROM tbUsuario ORDER BY $sort $order LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(
            fn($linha) => $this->formarObjeto($linha),
            $rs);
    }


    public function buscarPorNome(string $nome): ?Usuario
    {
        $sql = "SELECT nome, registro, funcao, email FROM tbUsuario WHERE nome = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $nome);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function buscarPorEmail(string $email): ?Usuario
    {
        $sql = "SELECT nome, registro, funcao, email FROM tbUsuario WHERE TRIM(LOWER(email)) = LOWER(?)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, trim(strtolower($email)));
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        return $dados ? $this->formarObjeto($dados) : null;
    }

  
    public function salvar(Usuario $Usuario): void
    {
        $sql = "INSERT INTO tbUsuario (nome, registro, funcao, email) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $Usuario->getNome(),
            $Usuario->getRegistro(),
            $Usuario->getFuncao(),
            $Usuario->getEmail(),    
        ]);
    }


    public function atualizar(Usuario $Usuario): void
    {
    $sql = "UPDATE tbUsuario SET nome = ?, funcao = ?, email = ? WHERE registro = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $Usuario->getNome(),
            $Usuario->getFuncao(),
            $Usuario->getEmail(),
            $Usuario->getRegistro()
        ]);
    }


    public function excluirUsuario(int $registro): void
    {
        $sql = "DELETE FROM tbUsuario WHERE registro = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$registro]);
    }

    public function autenticar(string $email, $registro): bool
    {
        $u = $this->buscarPorEmail(trim($email));

        if ($u === null) {
            return false;
        }

        return intval($registro) === intval($u->getRegistro());
    }
}
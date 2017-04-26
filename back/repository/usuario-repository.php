<?php

require_once "base-repository.php";

class UsuarioRepository extends BaseRepository
{

    function GetThis($codUsuario)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT cod_usuario, nome, telefone, email, perfil FROM tb_usuario WHERE cod_usuario = :cod_usuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':cod_usuario', $codUsuario);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function GetList()
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT cod_usuario, nome, telefone, email, perfil FROM tb_usuario';

        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function Insert(Usuario &$usuario)
    {
        if (!$this->IsAvailableEmail($usuario->email))
            throw new Warning("Email já cadastrado");

        $conn = $this->db->getConnection();

        $sql = 'INSERT INTO tb_usuario (nome, telefone, email, senha, perfil) VALUES (:nome, :telefone, :email, SHA1(:senha), :perfil)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':nome', $usuario->nome);
        $stm->bindParam(':telefone', $usuario->telefone);
        $stm->bindParam(':email', $usuario->email);
        $stm->bindParam(':senha', $usuario->senha);
        $stm->bindParam(':perfil', $usuario->perfil);
        $stm->execute();

        $usuario->codUsuario = $conn->lastInsertId();

        return $stm->rowCount() > 0;
    }

    function Update(Usuario &$usuario)
    {
        if (!$this->IsAvailableEmail($usuario->email, $usuario->codUsuario))
            throw new Warning("Email já cadastrado");

        $conn = $this->db->getConnection();

        $sql = 'UPDATE tb_usuario SET nome = :nome, telefone = :telefone, email = :email, perfil = :perfil WHERE cod_usuario = :codUsuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':codUsuario', $usuario->codUsuario);
        $stm->bindParam(':nome', $usuario->nome);
        $stm->bindParam(':telefone', $usuario->telefone);
        $stm->bindParam(':email', $usuario->email);
        $stm->bindParam(':perfil', $usuario->perfil);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    function Login(Usuario &$usuario)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT cod_usuario, nome, perfil FROM tb_usuario WHERE email = :email && senha = SHA1(:senha)';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':email', $usuario->email);
        $stm->bindParam(':senha', $usuario->senha);
        $stm->execute();

        $result = $stm->fetch(PDO::FETCH_ASSOC);

        if (!$result['cod_usuario']) {
            throw new Warning("Usuário ou senha inválidos");
        }

        $usuario->FillByDB($result);
        $usuario->senha = null;
    }

    private function IsAvailableEmail($email, $codUsuario = null)
    {
        $conn = $this->db->getConnection();

        $sql = 'SELECT cod_usuario FROM tb_usuario WHERE email = :email';

        if ($codUsuario)
            $sql .= ' AND cod_usuario <> :codUsuario';

        $stm = $conn->prepare($sql);
        $stm->bindParam(':email', $email);

        if ($codUsuario)
            $stm->bindParam(':codUsuario', $codUsuario);

        $stm->execute();

        return $stm->rowCount() == 0;
    }
}
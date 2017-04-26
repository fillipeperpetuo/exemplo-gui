<?php

class Usuario
{
    var $codUsuario;
    var $nome;
    var $telefone;
    var $email;
    var $senha;
    var $perfil;

    function FillByObject($obj)
    {
        if (property_exists($obj, 'codUsuario'))
            $this->codUsuario = $obj->codUsuario;

        if (property_exists($obj, 'nome'))
            $this->nome = $obj->nome;

        if (property_exists($obj, 'telefone'))
            $this->telefone = $obj->telefone;

        if (property_exists($obj, 'email'))
            $this->email = $obj->email;

        if (property_exists($obj, 'senha'))
            $this->senha = $obj->senha;

        if (property_exists($obj, 'perfil'))
            $this->perfil = $obj->perfil;
    }

    function FillByDB($dbArray)
    {
        if (array_key_exists("cod_usuario", $dbArray))
            $this->codUsuario = $dbArray['cod_usuario'];

        if (array_key_exists("nome", $dbArray))
            $this->nome = $dbArray['nome'];

        if (array_key_exists("telefone", $dbArray))
            $this->telefone = $dbArray['telefone'];

        if (array_key_exists("email", $dbArray))
            $this->email = $dbArray['email'];

        if (array_key_exists("perfil", $dbArray))
            $this->perfil = $dbArray['perfil'];
    }
}
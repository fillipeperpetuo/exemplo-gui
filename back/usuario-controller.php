<?php

session_start();

require_once "includes.php";
require_once "repository/usuario-repository.php";
require_once "model/usuario.php";

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : "");

if (!$action) {
    ToErrorJson("Action needs to be defined");
}

switch ($action) {
    case "get":
        ActionGetThis();
        break;
    case "list":
        ActionGetList();
        break;
    case "insert":
        ActionInsert();
        break;
    case "update":
        ActionUpdate();
        break;
    case "login":
        ActionLogin();
        break;
    default:
        ToErrorJson("Action not found");
}

function ActionGetThis()
{
    try {
        $codUsuario = $_GET['key'];
        $usuarioRepository = new UsuarioRepository();
        $result = $usuarioRepository->GetThis($codUsuario);

        $usuario = new Usuario();
        $usuario->FillByDB($result);

        if (!$usuario->codUsuario)
            throw new Warning("Usuario não encontrado");

        ToWrappedJson($usuario);
    } catch (Warning $e) {
        ToErrorJson($e->getMessage());
    } catch (Exception $e) {
        ToExceptionJson($e);
    }
}

function ActionGetList()
{
    try {
        $usuarioRepository = new UsuarioRepository();
        $result = $usuarioRepository->GetList();

        $listUsuario = array();

        foreach ($result as $dbUsuario) {
            $modelUsuario = new Usuario();
            $modelUsuario->FillByDB($dbUsuario);
            $listUsuario[] = $modelUsuario;
        }

        ToWrappedJson($listUsuario);
    } catch (Warning $e) {
        ToErrorJson($e->getMessage());
    } catch (Exception $e) {
        ToExceptionJson($e);
    }
}

function ActionInsert()
{
    try {
        $data = isset($_POST['data']) ? $_POST['data'] : null;

        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $usuario = new Usuario();
        $usuario->FillByObject($obj);

        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Insert($usuario);

        ToWrappedJson($usuario, "Usuario inserido com sucesso");
    } catch (Warning $e) {
        ToErrorJson($e->getMessage());
    } catch (Exception $e) {
        ToExceptionJson($e);
    }
}

function ActionUpdate()
{
    try {
        $data = isset($_POST['data']) ? $_POST['data'] : null;

        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $usuario = new Usuario();
        $usuario->FillByObject($obj);

        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Update($usuario);

        ToWrappedJson($usuario, "Dados atualizados com sucesso");
    } catch (Warning $e) {
        ToErrorJson($e->getMessage());
    } catch (Exception $e) {
        ToExceptionJson($e);
    }
}

function ActionLogin()
{
    try {
        $data = isset($_POST['data']) ? $_POST['data'] : null;

        if (!$data) {
            throw new Warning("Os dados enviados são inválidos");
        }

        $obj = json_decode($data);

        $usuario = new Usuario();
        $usuario->FillByObject($obj);

        $usuarioRepository = new UsuarioRepository();
        $usuarioRepository->Login($usuario);

        $_SESSION['cod_usuario'] = $usuario->codUsuario;
        $_SESSION['nome'] = $usuario->nome;
        $_SESSION['perfil'] = $usuario->perfil;

        ToWrappedJson(null, "Usuário autenticado com sucesso");
    } catch (Warning $e) {
        ToErrorJson($e->getMessage());
    } catch (Exception $e) {
        ToExceptionJson($e);
    }
}
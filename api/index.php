<?php

session_start();

//General Include
require_once "includes.php";

require_once "model/_includes.php";
require_once "controller/_includes.php";
require_once "repository/_includes.php";

$controller = isset($_GET['controller']) ? $_GET['controller'] : (isset($_POST['controller']) ? $_POST['controller'] : "");
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : "");

if (!$controller) {
    ToErrorJson("Controller needs to be defined");
}

if (!$action) {
    ToErrorJson("Action needs to be defined");
}

switch ($controller){
    case "usuario":
        $usuario = new UsuarioController();
        $usuario->ProcessRequest($action);
        break;
    default:
        ToErrorJson("Controller not found");
}
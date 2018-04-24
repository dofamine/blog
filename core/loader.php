<?php
defined("DOCROOT") or die ("NO DIRECT ACCESS");
include CLASS_PATH . "Config.php";
include CLASS_PATH . "Router.php";
include CLASS_PATH . "View.php";
include CLASS_PATH . "Model.php";
include CLASS_PATH . "Entity.php";
include CLASS_PATH . "AutoLoader.php";
session_start();
spl_autoload_register("Autoloader::load");
$router = Router::getInstance();

$router->addRoute(new Route("",
    [
        "controller" => "main",
        "action" => "index"
    ]));
$router->addRoute(new Route("register",
    [
        "controller" => "main",
        "action" => "register"
    ]));
$router->addRoute(new Route("regaction",
    [
        "controller" => "auth",
        "action" => "register"
    ]));
$router->addRoute(new Route("logout",
    [
        "controller" => "auth",
        "action" => "logout"
    ]));
$router->addRoute(new Route("deeplogout",
    [
        "controller" => "auth",
        "action" => "logoutAll"
    ]));
$router->addRoute(new Route("login",
    [
        "controller" => "auth",
        "action" => "login"
    ]));
$router->addRoute(new Route("post/showall",
    [
        "controller" => "post",
        "action" => "myPosts"
    ]));
$router->addRoute(new Route("/post/new",
    [
        "controller" => "post",
        "action" => "new"
    ]));
$router->addRoute(new Route("/post/add",
    [
        "controller" => "post",
        "action" => "add"
    ]));
$router->addRoute(new Route("/categories/{id}",
    [
        "controller" => "menu",
        "action" => "showCategory"
    ]));
try {
    $router->run();
} catch (RouterException $exception) {
    $router->redirect404();
    echo $exception->getMessage();
};

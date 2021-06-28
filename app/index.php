<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Slim\Exception\NotFoundException;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/entidades/Usuario.php';
require __DIR__ . '/accesoDatos/accesoDatos.php';
require __DIR__ . '/controllers/usuarioController.php';
require __DIR__ . '/funciones/funciones.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true,true,true);
$app->setBasePath("/app/public/index.php");



// Enable CORS
$app->add(function (Request $request, RequestHandlerInterface $handler): Response {
    
    $response = $handler->handle($request);

    $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');

    $response = $response->withHeader('Access-Control-Allow-Origin', '*');
    $response = $response->withHeader('Access-Control-Allow-Methods', 'get,post');
    $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);

    return $response;
});




$app->group('/login', function (RouteCollectorProxy $group) {
    $group->post('[/]', \UsuarioController::class . ':ValidarUsers' );
}); 

$app->group('/signin', function (RouteCollectorProxy $group) {
    $group->post('[/]', \UsuarioController::class . ':RegistrarUser' );
}); 
    

$app->run();


?>
<?php
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

require __DIR__ . '/../vendor/autoload.php';
$requet = ServerRequestFactory::fromGlobals();

// почти контроллер :)
$path = $requet->getUri()->getPath();
if($path === '/') {
    $name = $requet->getQueryParams()['name'] ?? 'Guest';
    $response = new HtmlResponse("Hello {$name}");
} elseif ($path === '/about') {
    $response = new HtmlResponse("About. Simple site.");
}else{
    $response = new JsonResponse(['error'=>'Undefined page'], 404);
}

// Post processing
$response = $response->withHeader('X-Engine', 'Simple php framework');
// Sender to
$emitter = new SapiEmitter();
// отправить ответ
$emitter->emit($response);

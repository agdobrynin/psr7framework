<?php
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

require __DIR__ . '/../vendor/autoload.php';
$requet = ServerRequestFactory::fromGlobals();

// почти контроллер :)
$name = $requet->getQueryParams()['name'] ?? 'Guest';

// создаем новый HTML response
$response = (new HtmlResponse("Hello {$name}"))
    ->withHeader('X-Engine', 'Simple php framework');

$emitter = new SapiEmitter();
// отправить ответ
$emitter->emit($response);

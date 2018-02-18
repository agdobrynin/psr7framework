<?php
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

require __DIR__ . '/../vendor/autoload.php';

$requet = ServerRequestFactory::fromGlobals();

$name = $requet->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse("Hello {$name}"))
    ->withHeader('X-Engine', 'Simple php framework');

$emitter = new SapiEmitter();
$emitter->emit($response);

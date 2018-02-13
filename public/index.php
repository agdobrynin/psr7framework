<?php
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;
use Framework\Http\ResponseSender;

require __DIR__ . '/../vendor/autoload.php';

$requet = ServerRequestFactory::fromGlobals();

$name = $requet->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse("Hello {$name}"))
    ->withHeader('X-Engine', 'Simple php framework');

$emitter = new ResponseSender();
$emitter->send($response);

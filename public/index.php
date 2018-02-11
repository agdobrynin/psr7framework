<?php
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$requet = ServerRequestFactory::fromGlobals();

$name = $requet->getQueryParams()['name'] ?? 'Guest';

$response = (new HtmlResponse("Hello {$name}"))
    ->withHeader('X-Engine', 'Simple php framework');

header('HTTP/1.0 '.$response->getStatusCode().' '.$response->getReasonPhrase());
foreach ($response->getHeaders() as $name=>$vals) {
    header($name . ':' . implode(', ', $vals));
}
echo $response->getBody();

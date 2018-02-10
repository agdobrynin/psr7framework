<?php
use Framework\Http\RequestFactory;
use Framework\Http\Response;

require __DIR__ . '/../vendor/autoload.php';

$requet = RequestFactory::fromGlobals();

$name = $requet->getQueryParams()['name'] ?? 'Guest';

$response = (new Response("Hello {$name}"))
    ->withHeader('X-Engine', 'Simple php framework');

header('HTTP/1.0 '.$response->getStatusCode().' '.$response->getReasonPhrase());
foreach ($response->getHeaders() as $name=>$val) {
    header($name . ': '.$val);
}
echo $response->getBody();

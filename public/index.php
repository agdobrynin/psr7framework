<?php
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

require __DIR__ . '/../vendor/autoload.php';
$requet = ServerRequestFactory::fromGlobals();

// почти контроллер :)
$path = $requet->getUri()->getPath();
if ($path === '/') {
    $name = $requet->getQueryParams()['name'] ?? 'Guest';
    $response = new HtmlResponse("Hello {$name}");
} elseif ($path === '/about') {
    $response = new HtmlResponse("About. Simple site.");
} elseif ($path === '/blog') {
    $response = new JsonResponse([
        ['id'=>1, 'title'=>'First post'],
        ['id'=>2, 'title'=>'Second post'],
    ]);
} elseif (preg_match('#^/blog/(?P<id>[0-9]+)$#i', $path, $matches)) {
    if ($matches['id']) {
        $response = new JsonResponse([
            'id'=>$matches['id'],'title'=>"Post #{$matches['id']}"
        ]);
    } else {
        $response = new JsonResponse(['error'=>'Undefined post'], 404);
    }
} else {
    $response = new JsonResponse(['error'=>'Undefined page'], 404);
}

// Post processing
$response = $response->withHeader('X-Engine', 'Simple php framework');
// Sender to
$emitter = new SapiEmitter();
// отправить ответ
$emitter->emit($response);

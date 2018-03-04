<?php
/**
 * Simple PHP PSR-7 Framework
 */

use App\Http\Action;
use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Http\ActionResolver;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$config = [
    'users' => [
        'admin' => '123456',
        'user' => '654321',
    ],
];

$aura = new Aura\Router\RouterContainer();
$Routes = $aura->getMap();

$Routes->get('home', '/', Action\HelloAction::class);
$Routes->get('about', '/about', Action\AboutAction::class);
$Routes->get('blog', '/blog', Action\Blog\IndexAction::class);
$Routes->get('blog_show', '/blog/{id}', Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);

$Routes->get('cabinet', '/cabinet', function (ServerRequestInterface $request) use ($config) {
    $auth = new BasicAuthMiddleware($config['users']);
    $cabinet = new Action\CabinetAction();
    return $auth($request, function (ServerRequestInterface $request) use ($cabinet) {
        return $cabinet($request);
    });
});

$Router = new Framework\Http\Router\AuraRouterAdapter($aura);
$Resolver = new ActionResolver();

$request = ServerRequestFactory::fromGlobals();

try {
    $res = $Router->match($request);
    foreach ($res->getAttributes() as $attr => $val) {
        $request = $request->withAttribute($attr, $val);
    }
    $handler = $res->getHandler();
    $action = $Resolver->resolve($handler);
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new HtmlResponse('Page not found', 404);
}

// Post processing
$response = $response->withHeader('X-Engine', 'Simple php framework');
// Sender to
$emitter = new SapiEmitter();
// отправить ответ
$emitter->emit($response);

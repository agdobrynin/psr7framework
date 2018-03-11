<?php
/**
 * Simple PHP PSR-7 Framework
 */
use App\Http\Action;
use App\Http\Middleware;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Appilcation;
use Framework\Http\Pipeline\Pipeline;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;


require __DIR__ . '/../vendor/autoload.php';

$config = [
    'users' => [
        'admin' => '123456',
        'user' => '654321',
    ],
];

$Resolver = new MiddlewareResolver();

$App = new Appilcation($Resolver);
$App->pipe(Middleware\ProfilerMiddleware::class);

$aura = new Aura\Router\RouterContainer();
$Routes = $aura->getMap();
$Routes->get('home', '/', Action\HelloAction::class);
$Routes->get('about', '/about', Action\AboutAction::class);
$Routes->get('blog', '/blog', Action\Blog\IndexAction::class);
$Routes->get('blog_show', '/blog/{id}', Action\Blog\ShowAction::class)->tokens(['id' => '\d+']);
$Routes->get('cabinet', '/cabinet', [
    new Middleware\BasicAuthMiddleware($config['users']),
    Action\CabinetAction::class,
]);

$Router = new Framework\Http\Router\AuraRouterAdapter($aura);

$request = ServerRequestFactory::fromGlobals();

try {
    $res = $Router->match($request);
    foreach ($res->getAttributes() as $attr => $val) {
        $request = $request->withAttribute($attr, $val);
    }
    $handlers = $res->getHandler();
    $App->pipe($Resolver->resolve($handlers));
} catch (RequestNotMatchedException $e) {}

$response = $App($request, new Middleware\NotFoundHandler());

// Post processing
$response = $response->withHeader('X-Engine', 'Simple php framework');
// Sender to
$emitter = new SapiEmitter();
// отправить ответ
$emitter->emit($response);

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
use Zend\Diactoros\Response;

require __DIR__ . '/../vendor/autoload.php';

// Config
$config = [
    'debug' => 1,
    'users' => [
        'admin' => '123456',
        'user' => '654321',
    ],
];

// Routing
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

// Middleware
$Resolver = new MiddlewareResolver();
$App = new Appilcation($Resolver, new Middleware\NotFoundHandler());
$App->pipe(new Middleware\ErrorHandlerMiddleware($config['debug']));
$App->pipe(Middleware\ProfilerMiddleware::class);
$App->pipe(Middleware\PowerByMiddleware::class);
// Router Middleware v 1.0
$App->pipe(new Framework\Http\Middleware\RouteMiddleware($Router));
$App->pipe(new Framework\Http\Middleware\DispatchMiddleware($Resolver));


$request = ServerRequestFactory::fromGlobals();
$response = $App->run($request, new Response());

// Sender to
$emitter = new SapiEmitter();
// отправить ответ
$emitter->emit($response);

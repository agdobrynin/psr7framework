<?php
namespace Test\Framework\Http;

use PHPUnit\Framework\TestCase;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Zend\Diactoros\Uri;
use Zend\Diactoros\ServerRequest;

class RouterTest extends TestCase
{
    private function buildRequest($method, $path): ServerRequest
    {
        return (new ServerRequest())
                ->withMethod($method)
                ->withUri(new Uri($path));
    }

    public function testCorrectMetod()
    {
        $RouteCollection = new RouteCollection();

        $name_get = 'blog';
        $handler_get = 'handler_get';
        $RouteCollection->get($name_get, '/blog', $handler_get);

        $name_post = 'blog_edit';
        $handler_post = 'handler_post';
        $RouteCollection->post($name_post, '/blog', $handler_post);

        $router = new Router($RouteCollection);

        $res = $router->match($this->buildRequest('GET', '/blog'));
        self::assertEquals($name_get, $res->getName());
        self::assertEquals($handler_get, $res->getHandler());

        $res = $router->match($this->buildRequest('POST', '/blog'));
        self::assertEquals($name_post, $res->getName());
        self::assertEquals($handler_post, $res->getHandler());
    }

    public function testGenerateMissingAttributes()
    {
        $RouteCollection = new RouteCollection();
        $name = 'blog_show';
        $RouteCollection->get($name, '/blog/{id}', 'handler', ['id'=>'\d+']);
        $router = new Router($RouteCollection);
        $this->expectException(\InvalidArgumentException::class);
        $router->generate('blog_show', ['slug'=>'post']);
    }

    public function testCorrectAttributes()
    {
        $RouteCollection = new RouteCollection();

        $name = 'show_post';
        $handler = 'handler_show_post';
        $RouteCollection->get($name, '/blog/{id}', $handler, ['id'=>'\d+']);
        $router = new Router($RouteCollection);
        $res = $router->match($this->buildRequest('GET', '/blog/5'));
        self::assertEquals($name, $res->getName());
        self::assertEquals(['id'=>5], $res->getAttributes());
    }

    public function testIncorrectAttributes()
    {
        $RouteCollection = new RouteCollection();

        $name = 'show_post';
        $handler = 'handler_show_post';
        $RouteCollection->get($name, '/blog/{id}', $handler, ['id'=>'\d+']);
        $router = new Router($RouteCollection);
        $this->expectException(RequestNotMatchedException::class);
        $router->match($this->buildRequest('GET', '/blog/not-matched-attr'));
    }
}

<?php
namespace Test\Framework\Http;

use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\SimpleRouter;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class RouterTest extends TestCase
{
    /**
     * Undocumented function
     *
     * @param [type] $method Метод
     * @param [type] $path   Путь
     *
     * @return ServerRequest
     */
    private function buildRequest($method, $path): ServerRequest
    {
        return (new ServerRequest())
            ->withMethod($method)
            ->withUri(new Uri($path));
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCorrectMetod()
    {
        $RouteCollection = new RouteCollection();

        $name_get = 'blog';
        $handler_get = 'handler_get';
        $RouteCollection->get($name_get, '/blog', $handler_get);

        $name_post = 'blog_edit';
        $handler_post = 'handler_post';
        $RouteCollection->post($name_post, '/blog', $handler_post);

        $router = new SimpleRouter($RouteCollection);

        $res = $router->match($this->buildRequest('GET', '/blog'));
        self::assertEquals($name_get, $res->getName());
        self::assertEquals($handler_get, $res->getHandler());

        $res = $router->match($this->buildRequest('POST', '/blog'));
        self::assertEquals($name_post, $res->getName());
        self::assertEquals($handler_post, $res->getHandler());
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testGenerateMissingAttributes()
    {
        $RouteCollection = new RouteCollection();
        $name = 'blog_show';
        $RouteCollection->get($name, '/blog/{id}', 'handler', ['id' => '\d+']);
        $router = new SimpleRouter($RouteCollection);
        $this->expectException(\InvalidArgumentException::class);
        $router->generate('blog_show', ['slug' => 'post']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testCorrectAttributes()
    {
        $RouteCollection = new RouteCollection();

        $name = 'show_post';
        $handler = 'handler_show_post';
        $RouteCollection->get($name, '/blog/{id}', $handler, ['id' => '\d+']);
        $router = new SimpleRouter($RouteCollection);
        $res = $router->match($this->buildRequest('GET', '/blog/5'));
        self::assertEquals($name, $res->getName());
        self::assertEquals(['id' => 5], $res->getAttributes());
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testIncorrectAttributes()
    {
        $RouteCollection = new RouteCollection();

        $name = 'show_post';
        $handler = 'handler_show_post';
        $RouteCollection->get($name, '/blog/{id}', $handler, ['id' => '\d+']);
        $router = new SimpleRouter($RouteCollection);
        $this->expectException(RequestNotMatchedException::class);
        $router->match($this->buildRequest('GET', '/blog/not-matched-attr'));
    }
}

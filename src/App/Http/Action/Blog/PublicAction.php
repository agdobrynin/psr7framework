<?php

namespace App\Http\Action\Blog;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class PublicAction
{
    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $id = $request->getAttribute('id');

        if ($id) {
            return new RedirectResponse($this->router->generate('blog_show', ['id' => $id]));
        }
        return $next($request);
    }
}

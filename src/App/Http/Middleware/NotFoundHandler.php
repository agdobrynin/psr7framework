<?php
namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;


class NotFoundHandler
{
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     * 
     * @return Zend\Diactoros\Response\HtmlResponse
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse('Undefined page :-(', 404);
    }
}
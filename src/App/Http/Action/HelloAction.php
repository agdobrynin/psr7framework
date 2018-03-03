<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class HelloAction
{
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request запрос
     *
     * @return Zend\Diactoros\Response\HtmlResponse
     */
    public function __invorke(ServerRequestInterface $request)
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse("Hello {$name}");
    }
}

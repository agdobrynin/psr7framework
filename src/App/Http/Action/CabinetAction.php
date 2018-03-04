<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;

class CabinetAction
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
        $auth_user = $request->getAttribute('username');
        return new HtmlResponse("I am logged as {$auth_user}");
    }
}

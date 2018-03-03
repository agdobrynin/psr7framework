<?php
namespace App\Http\Action\Blog;

use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction
{
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request
     * 
     * @return Zend\Diactoros\Response\JsonResponse
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        if ($id) {
            return new JsonResponse(['id' => $id, 'title' => "Post #{$id}"]);
        }
        return new JsonResponse(['error' => 'Undefined post'], 404);
    }
}

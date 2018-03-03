<?php
namespace App\Http\Action\Blog;

use Zend\Diactoros\Response\JsonResponse;

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
        $id = $request->getiAttribute('id');
        if ($id) {
            return new JsonResponse(['id' => $id, 'title' => "Post #{$id}"]);
        }
        return new JsonResponse(['error' => 'Undefined post'], 404);
    }
}

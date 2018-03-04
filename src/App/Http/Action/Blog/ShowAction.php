<?php
namespace App\Http\Action\Blog;

use Psr\Http\Message\ServerRequestInterface;
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
        $id = (int) $request->getAttribute('id');
        if ($id && $id <= 3) {
            return new JsonResponse(['id' => $id, 'title' => "Post #{$id}"]);
        }
        return new HtmlRespolse('Page in blog not found', 404);
    }
}

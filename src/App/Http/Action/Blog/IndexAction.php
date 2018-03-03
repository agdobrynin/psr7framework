<?php
namespace App\Http\Action\Blog;

use Zend\Diactoros\Response\JsonResponse;

class IndexAction
{
    /**
     * Undocumented function
     *
     * @return Zend\Diactoros\Response\JsonResponse
     */
    public function __invoke()
    {
        return new JsonResponse(
            [
                ['id' => 1, 'title' => 'First post'],
                ['id' => 2, 'title' => 'Second post'],
                ['id' => 3, 'title' => 'Threed post'],
            ]
        );
    }
}

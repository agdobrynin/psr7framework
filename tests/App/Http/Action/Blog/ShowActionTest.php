<?php

namespace Tests\App\Http\Action\Blog;

use App\Http\Action\Blog\ShowAction;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class ShowActionTest extends Testcase
{
    public function testSuccess()
    {
        $action = new ShowAction();

        $request = (new ServerRequest())
                    ->withAttribute('id', $id = 2);

        $response = $action($request);

        self::assertEquals(200, $response->getStatusCode());

        $ResTest = ["id" => $id, "title" => "Post #{$id}"];

        self::assertJsonStringEqualsJsonString(
            json_encode($ResTest),
            $response->getBody()->getContents()
        );
    }

    public function testNotFound()
    {
        $action = new ShowAction();

        $request = (new ServerRequest())
                    ->withAttribute('id', $id = 0);

        $response = $action($request);
        self::assertEquals(404, $response->getStatusCode());
    }
}

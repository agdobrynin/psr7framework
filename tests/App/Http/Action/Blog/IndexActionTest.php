<?php

namespace Tests\App\Http\Action\Blog;

use App\Http\Action\Blog\IndexAction;
use PHPUnit\Framework\TestCase;

class IndexActionTest extends Testcase
{
    public function testSuccess()
    {
        $action = new IndexAction();
        $response = $action();

        self::assertEquals(200, $response->getStatusCode());

        $ResTest = [
            ["id" => 1, "title" => "First post"],
            ["id" => 2, "title" => "Second post"],
            ["id" => 3, "title" => "Threed post"],
        ];
        self::assertJsonStringEqualsJsonString(
            json_encode($ResTest),
            $response->getBody()->getContents()
        );
    }
}

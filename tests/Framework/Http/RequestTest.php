<?php
namespace Tests\Framework\Http;

use Zend\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testEmpty(): void
    {
        $request = new ServerRequest();

        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testQueryParams(): void
    {
        $data = [
            'name' => 'Ivan',
            'age' => 43,
        ];

        $request = (new ServerRequest())->withQueryParams($data);

        self::assertEquals($data, $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testParsedBody(): void
    {
        $data = [
            'name' => 'Ivan',
            'age' => 43
        ];

        $request = (new ServerRequest())->withParsedBody($data);

        self::assertEquals([], $request->getQueryParams());
        self::assertEquals($data, $request->getParsedBody());
    }
}

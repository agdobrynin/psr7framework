<?php
use Framework\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testEmpty(): void
    {
        $body = "My Body";
        $response =  new Response($body);
        self::assertEquals($body, $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals("OK", $response->getReasonPhrase());
    }

    public function test404(): void
    {
        $body = "Empty";
        $status = 404;
        $response =  new Response($body, $status);

        self::assertEquals($body, $response->getBody()->getContents());
        self::assertEquals(mb_strlen($body), $response->getBody()->getSize());

        self::assertEquals($status, $response->getStatusCode());
        self::assertEquals('Not Found', $response->getReasonPhrase());
    }

    public function testHeaders(): void
    {
        $arrHeader = [
            "X-Test-1" => "Test-1",
            "X-Test-2" => "Test-2"
        ];

        $respose = new Response('');
        foreach ($arrHeader as $key => $value) {
            $respose = $respose->withHeader($key, $value);
        }
        self::assertEquals($arrHeader, $respose->getHeaders());
    }
}

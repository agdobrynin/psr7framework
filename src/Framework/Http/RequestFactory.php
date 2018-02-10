<?php
/**
 * Фабрика для создания объекта Framework\Http\Request
 */
namespace Framework\Http;
use Framework\Http\Request;

class RequestFactory
{
    public static function fromGlobals(array $query = null, array $body = null): Request
    {
        return (new Request())
                ->withQueryParams($query ?: $_GET)
                ->withParsedBody($body ?: $_POST);
    }
}

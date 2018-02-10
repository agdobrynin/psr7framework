<?php
namespace Framework\Http;

interface ServerRequestInterface
{
    public function getQueryParams(): array;

    public function withQueryParams(array $query);

    public function getParsedBody();

    public function withParsedBody($data);
}

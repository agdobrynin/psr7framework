<?php
namespace Framework\Http\Router\Route;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Result;

interface Route
{
    public function match(ServerRequestInterface $request): ?Result;

    public function generate($name, array $params = []): ?string;
}
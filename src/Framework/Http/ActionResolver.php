<?php
namespace Framework\Http;

class ActionResolver
{
    public function resolve($handler)
    {
        return \is_string($handler) ? new $handler() : $handler;
    }
}

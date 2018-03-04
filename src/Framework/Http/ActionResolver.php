<?php
namespace Framework\Http;

/**
 * Класс предназначеный чтобы была возможнось вернуть хэндлер ввиде класса 
 * если вызов происходит по имени класса
 *
 * @category Action_Resolver
 * @package  Resolver
 * @author   Name <email@email.com>
 * @license  MIT
 * @link     http://url.com
 */
class ActionResolver
{
    /**
     * Undocumented function
     *
     * @param mixed $handler
     *
     * @return void
     */
    public function resolve($handler)
    {
        return \is_string($handler) ? new $handler() : $handler;
    }
}

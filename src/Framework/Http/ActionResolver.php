<?php
namespace Framework\Http;

/**
 * Undocumented class
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

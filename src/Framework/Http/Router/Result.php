<?php

namespace Framework\Http\Router;

/**
 * Undocumented class
 * 
 * @category Router_Result
 * @package  Router
 * @author   Name <email@email.com>
 * @license  MIT 
 * @link     http://url.com
 */
class Result
{
    private $_name;
    private $_handler;
    private $_attributes;

    /**
     * Undocumented function
     *
     * @param mixed $name 
     * @param mixed $handeler 
     * @param array $attributes 
     */
    public function __construct($name, $handeler, array $attributes)
    {
        $this->_name = $name;
        $this->_handler = $handeler;
        $this->_attributes = $attributes;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->_attributes;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getHandler()
    {
        return $this->_handler;
    }
}

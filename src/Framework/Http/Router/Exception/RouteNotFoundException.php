<?php
namespace Framework\Http\Router\Exception;

/**
 * Description
 * 
 * @category Router_Exception
 * @package  Router
 * @author   Name <email@email.com>
 * @license  MIT 
 * @link     http://url.com
 */

class RouteNotFoundException extends \LogicException
{
    private $_name;
    private $_params;

    /**
     * Undocumented function
     * 
     * @param string     $name 
     * @param array      $params 
     * @param \Throwable $previous 
     */
    public function __construct($name, array $params, \Throwable $previous = null)
    {
        parent::__construct("Route \"{$name}\" not found", 0, $previous);
        $this->_name = $name;
        $this->_params = $params;
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
    public function getParams(): array
    {
        return $this->_params;
    }
}

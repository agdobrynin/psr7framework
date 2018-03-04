<?php
namespace Framework\Http\Router\Exception;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Exception if Route not matched
 *
 * @category Router_Exeption
 * @package  Router
 * @author   Name <email@email.com>
 * @license  MIT 
 * @link     http://url.com
 */

class RequestNotMatchedException extends \LogicException
{
    private $_request;

    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     */
    public function __construct(ServerRequestInterface $request)
    {
        parent::__construct('Matches not found');
        $this->_request = $request;
    }

    /**
     * Undocumented function
     *
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->_request;
    }
}

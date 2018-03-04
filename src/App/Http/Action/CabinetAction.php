<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\EmptyResponse;

class CabinetAction
{
    /**
     * Users array pair user=password
     *
     * @var array
     */
    private $_users;
    
    /**
     * Undocumented function
     *
     * @param array $users 
     */
    public function __construct(array $users)
    {
        $this->_users = $users;
    }
    
    /**
     * Undocumented function
     *
     * @param ServerRequestInterface $request 
     *
     * @return Zend\Diactoros\Response\HtmlResponse
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $auth_user = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $auth_password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (!empty($auth_user) && !empty($auth_password)) {
            foreach ($this->_users as $name => $passwd) {
                if ($auth_user === $name && $auth_password === $passwd) {
                    return new HtmlResponse("I am logged as {$auth_user}");
                }
            }
        }

        return new EmptyResponse(401, ['WWW-Authenticate'=>'Basic realm=Access to the staging site, charset=UTF-8']);
    }
}

<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;

class BasicAuthDecorator
{
    private $_next;
    private $_users;

    public function __construct(callable $next, array $users)
    {
        $this->_next = $next;
        $this->_users = $users;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $auth_user = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $auth_password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (!empty($auth_user) && !empty($auth_password)) {
            foreach ($this->_users as $name => $passwd) {
                if ($auth_user === $name && $auth_password === $passwd) {
                    return ($this->_next)($request->withAttribute('username', $name));
                }
            }
        }

        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Access to the staging site, charset=UTF-8']);
    }
}

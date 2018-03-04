<?php
namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;

class BasicAuthMiddleware
{
    public const AUTHUSER = '_user';
    private $_users;

    public function __construct(array $users)
    {
        $this->_users = $users;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $auth_user = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $auth_password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (!empty($auth_user) && !empty($auth_password)) {
            foreach ($this->_users as $name => $passwd) {
                if ($auth_user === $name && $auth_password === $passwd) {
                    return $next($request->withAttribute(self::AUTHUSER, $name));
                }
            }
        }

        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Access to the staging site, charset=UTF-8']);
    }
}

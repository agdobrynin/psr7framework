<?php
namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class BasicAuthMiddleware
{
    public const AUTHUSER = '_user';
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
     * @param ResponseInterface      $response 
     * @param callable               $next 
     * 
     * @return mixed 
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
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

        return $response
                ->withStatus(401)
                ->withHeader('WWW-Authenticate', 'Basic realm=Access to the staging site, charset=UTF-8');
    }
}

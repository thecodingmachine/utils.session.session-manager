<?php


namespace Mouf\Utils\Session\SessionManager;

use TheCodingMachine\Funky\Annotations\Factory;
use TheCodingMachine\Funky\ServiceProvider;

class SessionManagerServiceProvider extends ServiceProvider
{
    /**
     * @Factory(aliases={SessionManagerInterface::class})
     */
    public static function createDefaultSessionManager(\SessionHandlerInterface $sessionHandler = null): DefaultSessionManager
    {
        $sessionManager =  new DefaultSessionManager();
        $sessionManager->sessionHandler = $sessionHandler;
        return $sessionManager;
    }
}

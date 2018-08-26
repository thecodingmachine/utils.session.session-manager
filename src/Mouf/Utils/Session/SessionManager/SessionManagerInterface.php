<?php
namespace Mouf\Utils\Session\SessionManager;

/**
 * Classes implementing this interface can manage a PHP session.
 * The default implementation for this class is DefaultSessionManager, but you can provide your own implementation
 * if you have a special management for the sessions.
 *
 * @author David Negrier
 */
interface SessionManagerInterface
{
    
    /**
     * Starts the session.
     *
     * @see session_start
     */
    public function start(): void;
    
    /**
     * Writes and closes the session
     *
     * @see session_write_close
     */
    public function writeClose(): void;
    
    /**
     * Destroys the session
     *
     * @see session_destroy
     */
    public function destroy(): void;

    /**
     * Update the current session id with a newly generated one.
     *
     * @param bool $deleteOldSession Whether to delete the old associated session file or not. You should not delete old session if you need to avoid races caused by deletion or detect/avoid session hijack attacks.
     */
    public function regenerateId(bool $deleteOldSession = false): void;
}

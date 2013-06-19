<?php
namespace Mouf\Utils\Session\SessionManager;

/**
 * Classes implementing this interface can manage a PHP session.
 * The default implementation for this class is DefaultSessionManager, but you can provide your own implementation
 * if you have a special management for the sessions.
 *  
 * @author David Negrier
 */
interface SessionManagerInterface {
	
	/**
	 * Starts the session.
	 * 
	 * @see session_start
	 * @return bool
	 */
	public function start();
	
	/**
	 * Writes and closes the session
	 * 
	 * @see session_write_close
	 */
	public function write_close();
	
	/**
	 * Destroys the session
	 * 
	 * @see session_destroy
	 * @return bool
	 */
	public function destroy();
}
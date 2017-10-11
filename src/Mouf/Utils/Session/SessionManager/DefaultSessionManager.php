<?php
namespace Mouf\Utils\Session\SessionManager;

/**
 * This class is the default manager for PHP sessions.
 * Using this class, you can start a standard PHP session, in an object oriented way.
 *
 * @Component
 * @author David Negrier
 */
class DefaultSessionManager implements SessionManagerInterface
{
    
    /**
     * $gcMaxLifeTime specifies the number of seconds after which data will be seen as 'garbage' and potentially cleaned up.
     * Garbage collection may occur during session start (depending on session.gc_probability and session.gc_divisor settings).
     *
     * NOTE: if you decide to set this value, we highly recommend to change the $savePath property.
     * Indeed, other scripts, using other settings, might clean your sessions.
     * If different scripts have different values of session.gc_maxlifetime but share the same place for storing the session data
     * then the script with the minimum value will be cleaning the data.
     *
     * @Property
     * @var string
     */
    public $gcMaxLifeTime;
    
    /**
     * The directory where the session files should be saved.
     *
     * @Property
     * @var string
     */
    public $savePath;
    
    /**
     * The name of the cookie used to keep the session.
     * If empty, this is set to the default value (PHPSESSID).
     *
     * @Property
     * @Compulsory
     * @var string
     */
    public $cookieName;
    
    /**
     * Set the lifetime of the cookie handling the session.
     * Set this value to empty to use the default value stored in php.ini.
     * Set this value to 0 to keep the cookie alive as long as the browser is open.
     * Otherwise, this is the lifetime of the cookie, in seconds.
     *
     * @Property
     * @var string
     */
    public $cookieLifetime;
    
    /**
     * $cookiePath specifies path to set in the session cookie.
     *
     * @Property
     * @var string
     */
    public $cookiePath;
    
    /**
     * $cookieDomain specifies the domain to set in the session cookie.
     * Default is none at all meaning the host name of the server which generated the cookie according to cookies specification.
     *
     * @Property
     * @var string
     */
    public $cookieDomain;
    
    /**
     * $cookieOnlySecure specifies whether cookies should only be sent over secure connections. Defaults to false.
     *
     * @Property
     * @var boolean
     */
    public $cookieOnlySecure = false;
    
    /**
     * Marks the cookie as accessible only through the HTTP protocol.
     * This means that the cookie won't be accessible by scripting languages, such as JavaScript.
     * This setting can effectively help to reduce identity theft through XSS attacks (although it is not supported by all browsers).
     *
     * @Property
     * @var boolean
     */
    public $cookieHttpOnly = false;
    
    /**
     * Set the session handler.
     *
     * @Property
     * @var \SessionHandlerInterface
     */
    public $sessionHandler;
    
    /**
     * Starts the session.
     *
     * @see session_start
     */
    public function start()
    {
        if (isset($_SESSION)) {
            return false;
        }

        if (in_array(php_sapi_name(), ['cli', 'phpdbg'], true)) {
            // Let's ignore session if we are in CLI
            return;
        }
        
        if (!empty($this->sessionHandler)) {
            session_set_save_handler($this->sessionHandler, true);
        }

        if (!empty($this->cookieName)) {
            session_name($this->cookieName);
        }
        
        if ($this->cookieLifetime !== null && $this->cookieLifetime !== "") {
            ini_set("session.cookie_lifetime", $this->cookieLifetime);
        }
        if (!empty($this->cookiePath)) {
            ini_set("session.cookie_path", $this->cookiePath);
        }
        if (!empty($this->cookieDomain)) {
            ini_set("session.cookie_domain", $this->cookieDomain);
        }
        ini_set("session.cookie_secure", $this->cookieOnlySecure);
        ini_set("session.cookie_httponly", $this->cookieHttpOnly);
        
        if (!empty($this->gcMaxLifeTime)) {
            ini_set("session.gc_maxlifetime", $this->gcMaxLifeTime);
        }
        if (!empty($this->savePath)) {
            ini_set("session.save_path", $this->savePath);
        }

        $result = session_start();
        if ($result === false) {
            throw new SessionManagerException('Failed to start the session.');
        }
    }
    
    /**
     * Writes and closes the session
     *
     * @see session_write_close
     */
    public function write_close()
    {
        if (in_array(php_sapi_name(), ['cli', 'phpdbg'], true)) {
            // Let's ignore session if we are in CLI
            return;
        }

        session_write_close();
    }
    
    /**
     * Destroys the session
     *
     * @see session_destroy
     */
    public function destroy()
    {
        if (in_array(php_sapi_name(), ['cli', 'phpdbg'], true)) {
            // Let's ignore session if we are in CLI
            return;
        }

        $result = session_destroy();
        if ($result === false) {
            throw new SessionManagerException('Failed to destroy the session.');
        }
    }

    /**
     * Update the current session id with a newly generated one.
     *
     * @param bool $deleteOldSession Whether to delete the old associated session file or not. You should not delete old session if you need to avoid races caused by deletion or detect/avoid session hijack attacks.
     */
    public function regenerateId($deleteOldSession = false)
    {
        if (in_array(php_sapi_name(), ['cli', 'phpdbg'], true)) {
            // Let's ignore session if we are in CLI
            return;
        }

        $result = session_regenerate_id($deleteOldSession);
        if ($result === false) {
            throw new SessionManagerException('Failed to regenerate session ID.');
        }
    }
}

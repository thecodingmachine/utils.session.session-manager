<?php
namespace Mouf\Utils\Action;

use Mouf\Utils\Value\ValueInterface;

use Mouf\Utils\Value\ValueUtils;

use Mouf\Utils\Value\VariableInterface;
use Mouf\Utils\Session\SessionManager\SessionManagerInterface;
use Mouf\MoufException;

/**
 * This action assigns a value to a variable.
 * 
 * @author David Négrier
 */
class SessionAssign implements ActionInterface {
	
	private $key;
	private $value;
	private $sessionManagerInterface;
	
	/**
	 * @Important $key
	 * @Important $value
	 * @param string|ValueInterface $key
	 * @param ValueInterface|string $value
	 * @param SessionManagerInterface $sesssionManagerInterface
	 */
	public function __construct($key, $value, SessionManagerInterface $sessionManagerInterface = null) {
		$this->key = $key;
		$this->value = $value;
		$this->sessionManagerInterface = $sessionManagerInterface;
	}
	
	/**
	 * Performs the action the object was designed to do.
	 */
	public function run() {
		if($this->sessionManagerInterface) {
			$this->sessionManagerInterface->start();
		}
		if(!isset($_SESSION)) {
			throw new MoufException('Session must be initialized when calling SessionAssign action');
		}
		$_SESSION[ValueUtils::val($this->key)] = ValueUtils::val($this->value);
	}
}
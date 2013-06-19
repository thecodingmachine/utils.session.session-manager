<?php
require_once __DIR__."/../../../autoload.php";

use Mouf\Actions\InstallUtils;
use Mouf\MoufManager;

// Let's init Mouf
InstallUtils::init(InstallUtils::$INIT_APP);
// Let's create the instance
$moufManager = MoufManager::getMoufManager();
if (!$moufManager->instanceExists("sessionManager")) {
	$moufManager->declareComponent("sessionManager", "Mouf\\Utils\\Session\\SessionManager\\DefaultSessionManager");
}

// Let's rewrite the MoufComponents.php file to save the component
$moufManager->rewriteMouf();

// Finally, let's continue the install
InstallUtils::continueInstall(isset($_REQUEST['selfedit']) && $_REQUEST['selfedit'] == 'true');
?>
<?php
defined('SC_PANEL') or die;

define('SC_PANEL_VERSION', '2.0.0');
define('SC_PANEL_VERSION_NAME', 'SuperComputer Panel' . SC_PANEL_VERSION);

// Debug flag
define('DEBUG', true);

/* Установка внутренней кодировки в UTF-8 */
mb_internal_encoding("UTF-8");
header('Content-Type: text/html; charset=UTF-8');

// Минимальная версия PHP, необходимая для запуска форума
define('REQUIRED_PHP_VERSION', '5.5.0');

if (version_compare(PHP_VERSION, REQUIRED_PHP_VERSION, '<')) {
	include __DIR__.'/errors/phpversion.php';
	die;
}

if (DEBUG) {
	ini_set('display_errors', true);
	ini_set('error_reporting', true);
	error_reporting(E_ALL);
}

require __DIR__.DIRECTORY_SEPARATOR.'autoloader.php';
require __DIR__.DIRECTORY_SEPARATOR.'Core'.DIRECTORY_SEPARATOR.'Inno'.DIRECTORY_SEPARATOR.'bootstrap.php';

require __DIR__.'/config.php';
App\Core\SCApp::initialize($config);
$scApp = App\Core\SCApp::getInstance();
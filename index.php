<?php
define('SC_PANEL', true);

ini_set('error_reporting', true);
ini_set('display_errors', true);
error_reporting(E_ALL);

define('ROOT', __DIR__);
define('APP_DIR', ROOT.DIRECTORY_SEPARATOR.'Application');
define('TEMPLATES_DIR', APP_DIR.DIRECTORY_SEPARATOR.'Template');
define('CORE_DIR', APP_DIR.DIRECTORY_SEPARATOR.'Core');
define('LIBRARIES_DIR', CORE_DIR.DIRECTORY_SEPARATOR.'Libraries');
define('UPLOADS_DIR', ROOT.DIRECTORY_SEPARATOR.'uploads');

define('CACHE_DIR', ROOT.DIRECTORY_SEPARATOR.'cache');

define('ROOT_URL', 'http://sc-panel.ru');


require 'Scheduler.php';
require 'view.php';

require ROOT.DIRECTORY_SEPARATOR.'Application'.DIRECTORY_SEPARATOR.'bootstrap.php';

\App\Core\SCApp::getInstance()->template->setTemplatePath(TEMPLATES_DIR);

try {
    $router = new App\Core\Libraries\Router(Inno::$app->request);

    echo $router->route();
}
catch (\Exception $error) {
    echo 'Something went wrong. '.$error->getMessage();
}
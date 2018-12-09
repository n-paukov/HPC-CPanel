<?php
namespace App\Core\Libraries;

use App\Controllers\NotFoundController;
use App\Core\Exceptions\NotFoundException;
use Inno\Base\Controller;
use Inno\Request;

/**
 * Class Router
 * @package App\Core\Libraries
 */
class Router {
    private const DEFAULT_CONTROLLER_NAME = 'index';
    private const DEFAULT_ACTION_NAME = 'index';

    /**
     * @var \Inno\Request
     */
    private $request;

    /**
     * Router constructor.
     *
     * @param \Inno\Request $request
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function route() {
        try {
            $query = !empty($this->request->get['r']) ? strtolower($this->request->get['r']) :
                static::DEFAULT_CONTROLLER_NAME . '/' . static::DEFAULT_ACTION_NAME;

            $queryParts = explode('/', $query);

            $controllerName = static::DEFAULT_CONTROLLER_NAME;
            $actionName = static::DEFAULT_ACTION_NAME;

            if (!empty($queryParts[0])) {
                $controllerName = $queryParts[0];
            }

            if (!empty($queryParts[1])) {
                $actionName = $queryParts[1];
            }

            $controllerClassName = 'App\\Controllers\\' . ucfirst(strtolower($controllerName));
            $actionMethodName = 'Action' . ucfirst(strtolower($actionName));

            if (!class_exists($controllerClassName)) {
                throw new NotFoundException();
            }


            $controller = new $controllerClassName();

            if (! ($controller instanceof Controller)) {
                throw new NotFoundException();
            }

            if (!method_exists($controller, $actionMethodName)) {
                throw new NotFoundException();
            }

            $controller->setSection([$controllerName, $actionName]);
            $controller->preload();

            return $controller->$actionMethodName();
        }
        catch (NotFoundException $error) {
            $controller = new NotFoundController();
            $controller->setSection(['notFound', 'index']);
            $controller->preload();

            return $controller->ActionIndex();
        }
    }
}
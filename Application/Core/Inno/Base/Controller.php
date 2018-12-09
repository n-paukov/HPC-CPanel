<?php
namespace Inno\Base;

use Inno\Session;
use Inno\Request;

/**
 * Класс, являющийся родителем для любого контроллера в системе
 *
 * Class Controller
 * @package Inno\Base
 */
class Controller {
	/**
	 * @var \Inno\Request Объект класса для доступа к переменным запроса
	 */
	protected $request;
	/**
	 * @var \Inno\Session Объект класса для работы с сессиями
	 */
	protected $session;

	/**
	 * @var \Inno\Web\Template Объект класса для работы с шаблоном
	 */
	protected $template;


    /**
     * @var string Название текущего контроллера
     */
    protected $controllerName;

    /**
     * @var string Название текущего действия
     */
    protected $actionName;


    /**
	 * @var string Путь к директории с файлами моделей
	 */
	private $modelsPath;

	/**
	 * @var string Префикс пространства имён для текущего приложения
	 */
	private $appNamespacePrefix;

    /**
	 *
	 */
	public function __construct() {
		$this->request = \Inno::$app->request;
		$this->session = \Inno::$app->session;

		$this->template = \Inno::$app->template;

		$this->appNamespacePrefix = 'App';
	}

    /**
     *
     */
	public function preload() {

    }

    /**
     * @param array $section
     */
    public function setSection(array $section) {
        $this->controllerName = strtolower($section[0]);
        $this->actionName = strtolower($section[1]);
    }

    /**
     * @param $view
     * @param $data
     *
     * @return string
     * @throws \Exception
     */
	protected function render($view, $data) {
	    $data['currentRouteSection'] = [ $this->controllerName, $this->actionName ];
        $data['page']['controllerName'] = $this->controllerName;
        $data['page']['actionName'] = $this->actionName;

	    $this->beforeRender($data);
        $content = $this->template->render('views/'.$view, $data);
	    $this->afterRender();

	    return $content;
    }

    /**
     * @param $view
     * @param array $data
     * @param string $pageTemplate
     *
     * @return string
     * @throws \Exception
     */
	protected function renderPage($view, $data=[], $pageTemplate='views/template') {
        $data['currentRouteSection'] = [ $this->controllerName, $this->actionName ];
        $data['page']['controllerName'] = $this->controllerName;
        $data['page']['actionName'] = $this->actionName;


        $this->beforeRender($data);
		$pageContent = $this->template->renderPage('views/'.$view, $data, $pageTemplate);
		$this->afterRender();

		return $pageContent;
	}

    /**
     * @param array $data
     */
	protected function beforeRender(array& $data) {

	}

	/**
	 * Выполняется после подключения файла с представлением
	 */
	protected function afterRender() {

	}

	/**
	 * Выполняет HTTP-переадресацию
	 *
	 * @param string $url URL для переадресации
	 * @param int $statusCode Код статуса
	 */
	protected function redirect($url, $statusCode = 302) {
		header('Location: '.$url, true, $statusCode);
		die;
	}
}
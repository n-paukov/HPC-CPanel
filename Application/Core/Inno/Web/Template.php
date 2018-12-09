<?php
namespace Inno\Web;

use Inno\Helpers\HtmlHelper;
use Inno\Helpers\UrlHelper;

/**
 * Class Template
 * @package Inno
 */
class Template {
	/**
	 * Расширение файлов с шаблонами
	 */
	const TEMPLATES_EXTENSION = '.php';

	/**
	 * @var string Путь к папке с шаблоном
	 */
	private $templatePath;

	/**
	 * @var string URL папки с шаблоном
	 */
	private $templateUrl;

	/**
	 * @var array массив подключённых JS скриптов
	 */
	private $javaScripts = [];

	/**
	 * @var array массив подключённых CSS стилей
	 */
	private $styleSheets = [];

	/**
	 * @var array массив с meta-тегами
	 */
	private $metaTags = [];

	/**
	 * @var array массив с произвольными кодами, добавленными в <head></head>
	 */
	private $codes = [];

	/**
	 * @var string название страницы, отображаемый в <title></title>
	 */
	private $title;

	/**
	 * @var string заголовок страницы для отображения на сайте
	 */
	private $heading;

	/**
	 * @var array массив хлебных крошек
	 */
	private $breadcrumbs = [];

	/**
	 * Конструктор
	*/
	public function __construct() {

	}

	/**
	 * Устанавливает путь к директории с шаблоном
	 *
	 * @param string $templatePath путь к шаблону
	 */
	public function setTemplatePath($templatePath) {
		$this->templatePath = $templatePath;

		$this->templateUrl = UrlHelper::getRootUrl() . str_replace([ROOT, '\\'], ['', '/'], $this->templatePath);
	}

	/**
	 * Отображает шаблон
	 *
	 * @param string $tpl название шаблона
	 * @param array $data массив данных для шаблона
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function render($tpl, $data=[]) {
		$data['page']['title'] = $this->title;
		$data['page']['heading'] = $this->heading;
		$data['page']['breadcrumbs'] = $this->breadcrumbs;

		$viewPath = $this->templatePath . DIRECTORY_SEPARATOR . $tpl . static::TEMPLATES_EXTENSION;

		if (!file_exists($viewPath)) {
			throw new \Exception('Template file not found. Path is ' . $viewPath);
		}

		ob_start();
		extract($data);

		include $viewPath;

		return ob_get_clean();
	}

	/**
	 * Отображает страницу
	 *
	 * @param string $tpl файл шаблона
	 * @param array $data массив данных для шаблона
	 * @param string $pageTemplate название файла с шаблоном страницы
	 *
	 * @return string
	 *
	 * @throws \Exception
	 */
	public function renderPage($tpl, $data=[], $pageTemplate='template') {
		return $this->render($pageTemplate, [
			'content' => $this->render($tpl, $data),
            'page' => (!empty($data['page'])) ? $data['page'] : [],
		]);
	}

    /**
     * @param $tpl
     *
     * @throws \Exception
     */
	public function includeTpl($tpl) {
		echo $this->render($tpl);
	}

	/**
	 * Устанавливает название страницы. Отображается в <title></title>
	 *
	 * @param string $title заголовок
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Возвращает название страницы
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Устанавливает заголовок страницы
	 *
	 * @param string $heading заголовок страницы
	 */
	public function setHeading($heading) {
		$this->heading = $heading;
	}

	/**
	 * Возвращает заголовок страницы
	 *
	 * @return string
	 */
	public function getHeading() {
		return $this->heading;
	}

	/**
	 * Добавляет элемент в массив "хлебных крошек"
	 * [ 'url' => 'Ссылка', 'label' => 'Надпись' ]
	 *
	 * @param array|string $breadcrumb массив с данными
	 */
	public function addBreadcrumb($breadcrumb) {
		$this->breadcrumbs[] = $breadcrumb;
	}

	/**
	 * Возвращает "хлебные крошки"
	 *
	 * @return array массив "хлебных крошек"
	 */
	public function getBreadcrumbs() {
		return $this->breadcrumbs;
	}

	/**
	 * Подключает таблицу стилей
	 *
	 * @param string $url URL таблицы стилей
	 * @param int|null $key ключ
	 */
	public function registerStyleSheet($url, $key = null) {
		if (is_null($key)) {
			$this->styleSheets[] = HtmlHelper::styleSheet($url, false);
		}
		else {
			$this->styleSheets[$key] = HtmlHelper::styleSheet($url, false);
		}
	}

	/**
	 * Подключает JavaScript
	 *
	 * @param string $url URL JS скрипта
	 * @param string $mode режим подключения (async, defer)
	 * @param int|null $key ключ
	 */
	public function registerJavaScript($url, $key = null, $mode='') {
		if (is_null($key)) {
			$this->javaScripts[] = HtmlHelper::javaScript($url, false, $mode);
		}
		else {
			$this->javaScripts[$key] = HtmlHelper::javaScript($url, false, $mode);
		}
	}

	/**
	 * Регистрирует мета-тег
	 * $template->registerMetaTag([
	 * 	 'name' => 'description',
	 *   'content' => 'test page'
	 * ], 'description');
	 *
	 * @param array $options атрибуты тега
	 * @param string|null $key ключ
	 */
	public function registerMetaTag($options, $key = null) {
		if (is_null($key)) {
			$this->metaTags[] = HtmlHelper::tag('meta', '', $options);
		} else {
			$this->metaTags[$key] = HtmlHelper::tag('meta', '', $options);
		}
	}

	/**
	 * Добавляет произвольный код между тегами <head></head>
	 *
	 * @param string $code код
	 */
	public function setCode($code) {
		$this->codes[] = $code;
	}

	/**
	 * Возвращает код, который должен находиться в <head></head>
	 *
	 * @return string код
	 */
	public function getHeadSection() {
		$html = '';

		foreach ($this->metaTags as $metaTag) {
			$html .= '	'.$metaTag."\n";
		}

		$html .= "\n";

		foreach ($this->javaScripts as $javaScript) {
			$html .= '	'.$javaScript."\n";
		}

		$html .= "\n";

		foreach ($this->styleSheets as $styleSheet) {
			$html .= '	'.$styleSheet."\n";
		}

		$html .= "\n";

		foreach ($this->codes as $code) {
			$html .= '	'.$code."\n";
		}

		return $html;
	}

	/**
	 * Возвращает URL папки с шаблоном
	 *
	 * @return string
	 */
	public function getTemplateUrl() {
		return $this->templateUrl;
	}
}
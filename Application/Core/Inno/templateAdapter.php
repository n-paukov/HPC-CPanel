<?php
use Inno\Helpers\UrlHelper;

/**
 * Генерирует URL страницы
 *
 * @param array $route массив вида [контроллер, действие, точка_входа(не обязательно)]
 * @param array|null $parameters массив GET параметров
 * @param string|null $anchor якорь
 *
 * @return string
 */
function innoUrl($route, $parameters=null, $anchor=null) {
	return UrlHelper::to($route, $parameters, $anchor);
}

/**
 * Возвращает URL корневого каталога с форумом
 *
 * @return string
 */
function innoGetRootUrl() {
	return UrlHelper::getRootUrl();
}

/**
 * Подключает файл шаблона
 *
 * @param string $tpl название шаблона
 */
function innoIncludeTpl($tpl) {
	Inno::$app->template->includeTpl($tpl);
}

/**
 * Выводит название страницы
 */
function innoTitle() {
	return Inno::$app->template->getTitle();
}

/**
 * Выводит заглавие страницы
 */
function innoHeading() {
    return Inno::$app->template->getHeading();
}

/**
 * Выводит содержимое <head></head>
 */
function innoHead() {
    return Inno::$app->template->getHeadSection();
}

/**
 * Функция вывода хлебных крошей по-умолчанию
 */
function innoDefaultBreadcrumbs() : string {
	$data = '<ul class="b-breadcrumbs">';

	foreach (Inno::$app->template->getBreadcrumbs() as $breadcrumb) {
		if (is_array($breadcrumb)) {
			$data .= '<li><a href="'.$breadcrumb['url'].'">'.$breadcrumb['label'].'</a></li>';
		}
		else {
			$data .= '<li>'.$breadcrumb.'</li>';
		}
	}

	$data .= '</ul>';

	return $data;
}

/**
 * Функция вывода хлебных крошек
 */
function innoBreadcrumbs() : string {
	if (function_exists('innoTemplateBreadcrumbs')) {
		return innoTemplateBreadcrumbs();
	}
	else {
		return innoDefaultBreadcrumbs();
	}
}

/**
 * Подключает таблицу стилей
 *
 * @param string $url URL таблицы стилей
 * @param int|null $key ключ
 */
function innoRegisterStyleSheet($url, $key = null) {
	Inno::$app->template->registerStyleSheet($url, $key);
}

/**
 * Подключает JavaScript
 *
 * @param string $url URL JS скрипта
 * @param string $mode режим подключения (async, defer)
 * @param int|null $key ключ
 */
function innoRegisterJavaScript($url, $mode='', $key = null) {
	Inno::$app->template->registerJavaScript($url, $mode, $key);
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
function innoRegisterMetaTag($options, $key = null) {
	Inno::$app->template->registerMetaTag($options, $key);
}

/**
 * Добавляет произвольный код между тегами <head></head>
 *
 * @param string $code код
 */
function innoRegisterHeadCode($code) {
	Inno::$app->template->setCode($code);
}

/**
 * Возвращает URL папки с шаблоном
 *
 * @return string
 */
function innoGetTemplateUrl() {
	return Inno::$app->template->getTemplateUrl();
}

/**
 * Выводит URL папки с шаблоном
 */
function innoTemplateUrl() {
    return Inno::$app->template->getTemplateUrl();
}

/**
 * Очищает строку для безопасного вывода
 *
 * @param string $string строка
 *
 * @return string
 */
function e($string) {
	return htmlspecialchars($string, ENT_COMPAT, 'UTF-8');
}
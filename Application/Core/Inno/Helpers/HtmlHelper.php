<?php
namespace Inno\Helpers;

/**
 * Class HtmlHelper
 * @package Inno\Helpers
 */
class HtmlHelper {
	/**
	 * @var array список тегов, которые не требуется закрывать
	 */
	public static $voidElements = [
		'area' => true,
		'base' => true,
		'br' => true,
		'col' => true,
		'command' => true,
		'embed' => true,
		'hr' => true,
		'img' => true,
		'input' => true,
		'keygen' => true,
		'link' => true,
		'meta' => true,
		'param' => true,
		'source' => true,
		'track' => true,
		'wbr' => true,
	];

	/**
	 * Создаёт HTML код тега
	 *
	 * @param string $name название тега
	 * @param string $content содержимое тега
	 * @param array $options массив атрибутов тега
	 *
	 * @return string
	 */
	public static function tag($name, $content='', $options=[]) {
		$html = '<' . $name . static::renderTagAttributes($options) . '>';

		return (isset(static::$voidElements[strtolower($name)])) ? $html : $html . $content . '</' . $name . '>';
	}

	/**
	 * Возвращает код для подключения CSS таблицы стилей
	 *
	 * @param string styleSheet URL или код таблицы стилей
	 * @param bool $inline флаг inline- вставки
	 *
	 * @return string
	 */
	public static function styleSheet($styleSheet, $inline=false) {
		if (!$inline) {
			return static::tag('link', '', [
				'rel' => 'stylesheet',
				'type' => 'text/css',
				'href' => $styleSheet,
			]);
		}
		else {
			return static::tag('style', $styleSheet);
		}
	}

	/**
	 * Возвращает код для подключения JavaScript
	 *
	 * @param string $javaScript URL или код скрипта
	 * @param bool|false $inline флаг inline- вставки
	 * @param string $mode режим загрузки (defer, async). Только для не inline- подключения
	 *
	 * @return string
	 */
	public static function javaScript($javaScript, $inline=false, $mode='') {
		if (!$inline) {
			$attributes = [
				'src' => $javaScript,
			];

			if ($mode != '') {
				$attributes[$mode] = true;
			}

			return static::tag('script', '', $attributes);
		}
		else {
			return static::tag('script', $javaScript);
		}
	}

	/**
	 * Преобразовывает массив в строку атрибутов тега
	 *
	 * @param Array $attributes массив атрибутов
	 *
	 * @return string
	 */
	public static function renderTagAttributes(Array $attributes) {
		$resultString = '';

		foreach ($attributes as $name => $value) {
			if (is_bool($value)) {
				$resultString .= ' '.$name;
			}
			else if (is_string($value)) {
				$resultString .= ' ' . $name . '="'.$value.'"';
			}
		}

		return $resultString;
	}
}
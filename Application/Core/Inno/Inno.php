<?php
/**
 * Class Inno
 * @package Inno
 */
class Inno {
	/**
	 * @var \Inno\Application
	 */
	public static $app;

	public static function initialzie() {
	    static::$app = \Inno\Application::getInstance();
    }
}
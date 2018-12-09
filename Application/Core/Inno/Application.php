<?php
namespace Inno;

use Inno\Web\Template;
use Inno\Request;
use Inno\Session;

/**
 * Class Application
 * @package Inno
 */
class Application {
    /**
     * @var \Inno\Web\Template
     */
	public $template;

    /**
     * @var \Inno\Request
     */
    public $request;

    /**
     * @var \Inno\Session
     */
    public $session;

    /**
     * @var null
     */
	private static $_instance = null;

    /**
     * Application constructor.
     */
	private function __construct() {
		$this->template = new Template();
		$this->request = new Request();
		$this->session = new Session();
	}

    /**
     *
     */
	private function __clone() {

	}

    /**
     * @return \Inno\Application|null
     */
	public static function getInstance() {
		if (self::$_instance === null) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}
}
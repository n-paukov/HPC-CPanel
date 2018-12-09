<?php
namespace Inno\Base;

/**
 * Класс, являющийся родителем для всех моделей в системе
 *
 * Class Model
 * @package Inno\Base
 */
class Model {
    /**
     * @var \Inno\Request
     */
    protected $request;

    /**
     * @var \Inno\Session
     */
    protected $session;

	public function __construct() {
        $this->request = \Inno::$app->request;
        $this->session = \Inno::$app->session;
    }
}
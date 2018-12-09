<?php
namespace Inno\DataBase;

/**
 * Class DataBase
 * @package Inno\DataBase
 */
class DataBase {
    /**
     * @var \Inno\DataBase\IDriver
     */
    private $driver;

    /**
     * DataBase constructor.
     *
     * @param \Inno\DataBase\IDriver $driver
     */
    public function __construct(IDriver $driver) {
        $this->driver = $driver;
    }

    public function connect() {
        $this->driver->connect();
    }

    /**
     * @param string $query
     *
     * @return \Inno\DataBase\QueryResult
     */
    public function query(string $query) : QueryResult {
        return $this->driver->query($query);
    }

    /**
     * @return string
     */
    public function getTablePrefix() : string {
        return $this->driver->getTablePrefix();
    }

    public function escape(string $value) : string {
        return $this->driver->escape($value);
    }

}
<?php
namespace Inno\DataBase;

abstract class QueryResult {
    public function __construct() {
    }

    abstract public function fetchAssoc() : ?array;
    abstract public function fetch() : ?array;
    abstract public function fetchRow() : ?array;
    abstract public function fetchAll() : array;
}
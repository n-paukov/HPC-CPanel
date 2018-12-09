<?php
namespace Inno\DataBase;


class MySQLiQueryResult extends QueryResult {
    private $queryResult;

    public function __construct($queryResult) {
        $this->queryResult = $queryResult;
    }

    public function fetchAssoc() : ?array {
        return $this->queryResult->fetch_assoc();
    }

    public function fetch() : ?array {
        return $this->fetchAssoc();
    }

    public function fetchRow() : ?array {
        return $this->fetchRow();
    }

    public function fetchAll(): array {
        $result = [];

        while ($row = $this->fetchAssoc())
            $result[] = $row;

        return $result;
    }
}
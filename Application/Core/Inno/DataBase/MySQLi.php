<?php
namespace Inno\DataBase;


use mysql_xdevapi\Exception;

class MySQLi implements IDriver {
    private $client;
    private $parameters;

    public function __construct(array $parameters = []) {
        $this->client = new \mysqli();
        $this->parameters = $parameters;
    }

    public function connect() {
        $this->client->connect($this->parameters['host'], $this->parameters['user'],
            $this->parameters['password'], $this->parameters['database']);
    }

    public function escape(string $value): string {
        return $this->client->real_escape_string($value);
    }

    public function query($query): QueryResult {
        $result = $this->client->query($query);

        if ($result === false)
            throw new Exception();

        return new MySQLiQueryResult($result);
    }

    public function getTablePrefix(): string {
        return $this->parameters['prefix'];
    }
}
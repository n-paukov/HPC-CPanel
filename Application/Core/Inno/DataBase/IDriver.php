<?php
namespace Inno\DataBase;


interface IDriver {
    public function connect();
    public function escape(string $value) : string;
    public function getTablePrefix() : string;

    public function query(string $query) : QueryResult;
}
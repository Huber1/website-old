<?php

namespace framework\database;

class Query
{
    public string $query;
    public array $parameters;

    public function __construct(string $query, array $parameters = [])
    {
        $this->query = $query;
        $this->parameters = $parameters;
    }
}

<?php

namespace My;

class DatabaseAdapter
{
    protected $dsn;
    
    public function __construct($dsn)
    {
        $this->dsn = $dsn;
    }
}

<?php

namespace My;

class UserTable
{
    protected $databaseAdapter = null;

    public function __construct(DatabaseAdapter $databaseAdapter)
    {
        $this->databaseAdapter = $databaseAdapter;
    }

}

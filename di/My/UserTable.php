<?php

namespace My;

class Album
{
    protected $artist = null;

    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

}

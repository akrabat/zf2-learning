<?php

namespace My;

include __DIR__ . "/../load_zf.php";

class Artist
{
    
}

class Album
{
    protected $artist = null;

    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

}

// Test it
echo "Manual instantiation:\n";
$album = new \My\Album(new \My\Artist());
var_dump($album);
unset($album);

echo PHP_EOL. 'DI one: $album = $di->get(\'My\Album\')' . PHP_EOL;
$di = new \Zend\Di\DependencyInjector();
$album = $di->get('My\Album');
var_dump($album);

echo PHP_EOL. 'DI two: $album2 = $di->newInstance(\'My\Album\')' . PHP_EOL;
$album2 = $di->newInstance('My\Album');
var_dump($album2);

echo PHP_EOL. 'DI three: $albumAgain = $di->get(\'My\Album\')' . PHP_EOL;
$albumAgain = $di->get('My\Album');
var_dump($albumAgain);

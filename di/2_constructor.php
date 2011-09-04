<?php

namespace My;

include __DIR__ . "/../load_zf.php";

class Artist
{
    protected $name;
        public function __construct($name)
        {
            $this->name = $name;
        }
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
$album = new \My\Album(new \My\Artist('Queen'));
var_dump($album);
unset($album);

echo PHP_EOL. 'Config injection of parameter one: $album = $di->get(\'My\Album\')' . PHP_EOL;
$di = new \Zend\Di\DependencyInjector();
$di->getInstanceManager()->setParameters('My\Artist', array(
        'name' => 'The Beatles',
    ));
$album = $di->get('My\Album');
var_dump($album);

echo PHP_EOL. 'Dynamic injection of parameter: $album2 = $di->get(\'My\Album\', array(\'Jonathan Coulton\')' . PHP_EOL;
unset($di);
$di = new \Zend\Di\DependencyInjector();
$album2 = $di->newInstance('My\Album', array('name'=>'Jonathan Coulton'));
var_dump($album2);


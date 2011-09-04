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

    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

}

// Test it
echo "Manual instantiation:\n";
$album = new \My\Album();
$album->setArtist(new \My\Artist('Queen'));
var_dump($album);
unset($album);

echo PHP_EOL. 'DI: $album = $di->get(\'My\Album\', array(\'Jonathan Coulton\')' . PHP_EOL;

use Zend\Di\DependencyInjector,
    Zend\Di\Definition,
    Zend\Di\Definition\Builder;

$method = new Builder\InjectionMethod();
$method->setName('setArtist');
$method->addParameter('artist', 'My\Artist');

$class = new Builder\PhpClass();
$class->setName('My\Album');
$class->addInjectionMethod($method);


$builder = new Definition\BuilderDefinition;
$builder->addClass($class);

$aDef = new Definition\AggregateDefinition;
$aDef->addDefinition($builder);
$aDef->addDefinition(new Definition\RuntimeDefinition);

$di = new \Zend\Di\DependencyInjector();
$di->setDefinition($aDef);

$album = $di->get('My\Album', array('Jonathan Coulton'));
var_dump($album);

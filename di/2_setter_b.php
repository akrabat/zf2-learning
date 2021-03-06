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

use Zend\Di\Di,
    Zend\Di\DefinitionList,
    Zend\Di\Definition;


// Create builder definitions
$builderDef = new Definition\BuilderDefinition();

// Builder definition for My\Album
$method = new Definition\Builder\InjectionMethod();
$method->setName('setArtist');
$method->addParameter('artist', 'My\Artist');

$class = new Definition\Builder\PhpClass();
$class->setName('My\Album');
$class->addInjectionMethod($method);

$builderDef->addClass($class);

$di = new Di(new DefinitionList(array($builderDef)));

// Test it
$album = $di->get('My\Album', array('artist'=>'Jonathan Coulton'));
var_dump($album);

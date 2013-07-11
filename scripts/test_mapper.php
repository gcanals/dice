<?php
require '../vendor/autoload.php';
require '../src/dice/conf/DiceConfigure.php';

require 'mapper/ArticleMapper.php';

$map = new ArticleMapper(\dice\mapper\ConnectionFactory::makeConnection("TEST"));

var_dump($map);

?>

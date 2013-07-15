<?php
require '../src/dice/conf/DiceConfigure.php';
require '../vendor/autoload.php';
//DiceConfigure::autloadRegister();
//DiceConfigure::setConfigFile()
require 'mapper/ArticleMapper.php';
require 'model/Article.php';

//echo DiceConfigure::getConfigFile() ."<br/>";




// making a connection :
use dice\mapper\ConnectionFactory;
echo "making connections <br/>";
$c1=ConnectionFactory::makeConnection("TEST") ; var_dump($c1);
$c2=ConnectionFactory::makeConnection() ; var_dump($c2);

echo "building mappers <br/>" ;
$map = new ArticleMapper($c1); var_dump($map);

ArticleMapper::setDefaultDBConf('TEST');
$map2=new ArticleMapper(); var_dump($map2);

ArticleMapper::setDefaultDBConf(null);
$map3=new ArticleMapper(); var_dump($map3);

echo "building models <br />";

$a = new Article($map); var_dump($a);


ArticleMapper::setDefaultDBConf('TEST');
$a2=new Article() ; var_dump($a2);

ArticleMapper::setDefaultDBConf(null);
$a3=new Article() ; var_dump($a3);


?>

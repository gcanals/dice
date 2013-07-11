<?php

require '../src/dice/conf/DiceConfigure.php';
require '../vendor/autoload.php';
//DiceConfigure::autloadRegister();
//DiceConfigure::setConfigFile()
require 'mapper/ArticleMapper.php';
require 'mapper/CategorieMapper.php';
require 'model/Article.php';
require 'model/Categorie.php';

echo "config file : managed at the dice level<br/>";
echo "should be : db.conf.ini (default) <br/>";
echo DiceConfigure::getConfigFile() ."<br />";

echo "config file : managed at the dice level<br/>";
echo "should be : db.conf.ini (default) <br/>";
DiceConfigure::setConfigFile('path/to/conf.ini');
echo DiceConfigure::getConfigFile() ."<br />";


echo "DB configuration at the dice level: <br/>";
echo "should be : 'DEFAULT' <br/>";
echo DiceConfigure::getDefaultDBConf() ."<br />";
echo dice\mapper\SQLMapper::getDefaultDBConf() ."<br />";
echo ArticleMapper::getDefaultDBConf()."<br/>";
echo CategorieMapper::getDefaultDBConf()."<br/>";

echo "now should be : grab <br/>";
DiceConfigure::setDefaultDBConf("grab");
echo dice\mapper\SQLMapper::getDefaultDBConf() ."<br />";
echo ArticleMapper::getDefaultDBConf()."<br/>";
echo CategorieMapper::getDefaultDBConf()."<br/>";

echo "now should be : toto <br/>";
dice\mapper\SQLMapper::setDefaultDBConf("toto");
echo dice\mapper\SQLMapper::getDefaultDBConf() ."<br />";
echo CategorieMapper::getDefaultDBConf()."<br/>";
echo ArticleMapper::getDefaultDBConf()."<br/>";



echo "default mapper for Model (empty): ". \dice\model\Model::getDefaultMapperClass()."<br/>";
\dice\model\Model::setDefaultMapperClass("SQLMaper");
echo "default mapper for Model (SQLMapper) : ". \dice\model\Model::getDefaultMapperClass()."<br/>";
echo "default mapper for Categorie (should be SQLMapper):".  Categorie::getDefaultMapperClass()."<br/>";
echo "default mapper for Article (should be ArticleMapper):".Article::getDefaultMapperClass()."<br/>";


Article::setDefaultMapperClass('CocoChanel');
echo "default mapper for Article (should be CocoChanel):".Article::getDefaultMapperClass()."<br/>";








    
?>

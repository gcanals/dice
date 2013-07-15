<?php
require '../vendor/autoload.php';
require '../src/dice/conf/DiceConfigure.php';

require 'mapper/ArticleMapper.php';
require 'model/Article.php';

$map = new ArticleMapper(\dice\mapper\ConnectionFactory::makeConnection("TEST"));

$a= new Article($map);

$a->setAttr('nom', 'velo');
$a->setAttr('descr', 'beau velo de course rouge');
$a->setAttr('tarif', 59.95);
$a->insert();

$a2=new Article($map);
$a2->setAttr('nom', 'biclou');
$a2->setAttr('descr', 'beau velo de course bleu');
$a2->setAttr('tarif', 214.56);
$a2->insert();



echo "finder en utilisant les static<br/>";
echo "tout les articles :<br/>";
$all = Article::find_many();
foreach ($all as $a) { echo $a; echo "<br/>";}
echo "le 1er de tous les articles :<br/>";
$all = Article::find_one();
echo $all; echo "<br/>";


$id=$all->getOid();
//var_dump($o);

echo "find sur la clé : $id<br/>";
$all = Article::find_one(intval($id));
echo $all; echo "<br/>";

//var_dump($o2[0]);
echo "find avec condition : le biclou<br/>";
$all= Article::find_many(array('conditions'=>array('nom'=>'biclou')));
foreach ($all as $a) { echo $a; echo "<br/>";}


echo "find all avec order, mais on garde juste le 1<br/>";
$all= Article::find_one(array('orders'=>array('orderby'=>'id', 'ord'=>  \dice\mapper\SQLMapper::ORDER_DESC)));
echo $all; echo "<br/>";

echo "find avec condition : le biclou et order<br/>";
$all= Article::find_many(array('conditions'=>array('nom'=>'biclou'),
                        'orders'=>array('orderby'=>'id', 'ord'=>  \dice\mapper\SQLMapper::ORDER_DESC)));
foreach ($all as $a) { echo $a; echo "<br/>";}


?>

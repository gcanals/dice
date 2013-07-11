<?php
require '../vendor/autoload.php';
require '../src/dice/conf/DiceConfigure.php';

require '../tests/mapper/ArticleMapper.php';
require '../tests/model/Article.php';

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

$all=$map->_find(array('conditions'=>array('nom'=> 'velo','id_categ'=>1,'tarif'=>49.95)));

echo "finder en utilisant le mapper<br/>";
echo "tout les articles :<br/>";
$all = $map->_find();
foreach ($all as $a) { echo $a; echo "<br/>";}

$o=$all[0];
$id=$o->getOid();
//var_dump($o);

echo "find sur la clé : $id<br/>";
$all = $map->_find(intval($id));
foreach ($all as $a) { echo $a; echo "<br/>";}

//var_dump($o2[0]);
echo "find avec condition : le biclou<br/>";
$all= $map->_find(array('conditions'=>array('nom'=>'biclou')));
foreach ($all as $a) { echo $a; echo "<br/>";}


echo "find all avec order <br/>";
$all= $map->_find(array('orders'=>array('orderby'=>'id', 'ord'=>  \dice\mapper\SQLMapper::ORDER_DESC)));
foreach ($all as $a) { echo $a; echo "<br/>";}

echo "find avec condition : le biclou et order<br/>";
$all= $map->_find(array('conditions'=>array('nom'=>'biclou'),
                        'orders'=>array('orderby'=>'id', 'ord'=>  \dice\mapper\SQLMapper::ORDER_DESC)));
foreach ($all as $a) { echo $a; echo "<br/>";}



?>

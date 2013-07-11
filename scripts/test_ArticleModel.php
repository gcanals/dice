<?php

require '../vendor/autoload.php';
require '../src/dice/conf/DiceConfigure.php';
//DiceConfigure::autloadRegister();

require '../tests/mapper/ArticleMapper.php';
require '../tests/model/Article.php';
use \dice\model\ModelException ;

$map = new ArticleMapper(\dice\mapper\ConnectionFactory::makeConnection("TEST"));

$a= new Article($map);

$a->setAttr('nom', 'velo');
$a->setAttr('descr', 'beau velo de course rouge');
$a->setAttr('tarif', 59.95);

echo $a->json();
echo $a ;
var_dump($a);
try {
$a->setAttr('couleur', 'rouge');
} catch (ModelException $e) {
    echo $e->getMessage();
}

echo "testing getters : <br/>";
echo $a->getAttr('nom').'<br/>';
echo $a->getAttr('descr').'<br/>';
echo $a->getAttr('tarif').'<br/>';

$a2=new Article($map);
$a2->setAttr('nom', 'biclou');
$a2->setAttr('descr', 'beau velo de course bleu');
$a2->setAttr('tarif', 214.56);

echo "testing the insertion in the db <br/>";
try {

$map->_insert($a);

$a2->insert() ;
} catch (ModelException $e) {
    echo $e->getMessage();
}

echo "inserted in the db (no errors, check the rows in the tables)<br/>";

echo "updating in the db <br/>";


$a->setAttr('nom',"voiture");
$a->setAttr('descr',"belle voiture rouge");
//$a->update();
$map->_update($a);
$a->setAttr('tarif', 3456.67);
$a->update();
echo "finally deleting<br/>";

$map->_delete($a);
$a2->delete();






?>

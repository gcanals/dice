<?php

require '../vendor/autoload.php';
require '../src/dice/conf/DiceConfigure.php';
//DiceConfigure::autloadRegister();

require '../tests/mapper/ArticleMapper.php';
require '../tests/model/Article.php';
require '../tests/mapper/CategorieMapper.php';
require '../tests/model/Categorie.php';
use \dice\model\ModelException ;

DiceConfigure::setDefaultDBConf('TEST');

$a = Article::find_one(array('conditions'=>array('nom'=>'velo')));
$c = $a->getCategorie();

echo "categorie du velo : ". $c->json() . "<br/>";

$cat = Categorie::find_one(array('conditions'=>array('nom'=>'sport')));
$la = $cat->getArticles();

foreach ($la as $art) {
    echo "article de sport : ". $art->json() . "<br/>";
}

?>

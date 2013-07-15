<?php


/**
 * Description of Categorie
 *
 * @author canals
 */

class Categorie extends \dice\model\Model {
    protected static $_defaultMapperClass = 'CategorieMapper';
    
    public function __construct(\dice\mapper\iDataMapper $dm=null) {
        parent::__construct($dm);
        $this->_mname=__CLASS__;    
       
    }
    
    public function getArticles() {
        return Article::find_many(array('conditions'=>array('id_categ'=>$this->getOid())));
    }
}

?>

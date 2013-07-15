<?php

/**
 * Description of Article : an active record for the Article
 * table in the test map database
 *
 * @author canals
 */

class Article extends dice\model\Model {
    
    protected static $_defaultMapperClass = 'ArticleMapper';
    
    public function __construct(\dice\mapper\iDataMapper $dm=null) {
        parent::__construct($dm);
        $this->_mname=__CLASS__;        
    }
    
    public function getCategorie() {
        return Categorie::find_one(array('conditions'=> array('id'=> $this->getAttr('id_categ'))));
    }
   
}

?>

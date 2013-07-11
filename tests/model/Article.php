<?php

/**
 * Description of Article : an active record for the Article
 * table in the test map database
 *
 * @author canals
 */
//use dice\model ;

class Article extends dice\model\Model {
    
    protected static $_defaultMapperClass = 'ArticleMapper';
    
    public function __construct(\dice\mapper\iDataMapper $dm=null) {
        //self::setDefaultMapperClass('ArticleMapper');
        parent::__construct($dm);
        $this->_mname=__CLASS__;    
        $this->_a=array('id'=>'number','nom'=>'string', 
                          'descr'=>'string', 'tarif'=>'number',
                           'id_categ'=>'number');
       
    }
   
}

?>

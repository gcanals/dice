<?php


/**
 * Description of TmapMapper
 *
 * @author canals
 */
class ArticleMapper extends dice\mapper\SQLMapper{
    
    public function __construct($connection=null) {
        parent::__construct($connection);
        $this->_tname = 'article';
        $this->_a = array('id'=>'number','nom'=>'string', 
                          'descr'=>'string', 'tarif'=>'number',
                           'id_categ'=>'number');
        $this->_mname= 'Article' ;
    }
}

?>

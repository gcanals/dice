<?php


/**
 * Description of CategorieMapper
 *
 * @author canals
 */
class CategorieMapper extends dice\mapper\SQLMapper {
    
   public function __construct($connection=null) {
        parent::__construct($connection);
        $this->_tname = 'categorie';
        $this->_a = array('id'=>'number','nom'=>'string', 
                          'descr'=>'string');
        $this->_mname= 'Categorie' ;
    }
}

?>

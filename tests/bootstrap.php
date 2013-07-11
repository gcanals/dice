<?php
//require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/../src/dice/conf/DiceConfigure.php';//autoload.php';
DiceConfigure::autloadRegister();

require_once dirname(__FILE__).'/mapper/ArticleMapper.php';
require_once dirname(__FILE__).'/model/Article.php';
require_once dirname(__FILE__).'/model/Categorie.php';


/**
 * Mock version of a Mapper, used to test models
 */
class MockMapper implements dice\mapper\iDataMapper {
    
 public static function setDefaultDBConf($conf) { return 1;}
 public static function getDefaultDBConf() {return 'TEST';}
 
 public function _insert(\dice\model\Model $m) {return $m;}
 public function _find($args=null) {
     if (is_null($args)) return null;
     return array('a', 'b','c');
     }
 public function _update(\dice\model\Model $m) {return $m;}
 public function _delete(\dice\model\Model $m) {return $m;}
}

/**
 *
 * Mock version of the PDOStatement class.
 *
 */
class MockPDOStatement extends PDOStatement {

 
   /**
    * Return some dummy data
    */
   public function fetchAll($fetch_style=PDO::ATTR_DEFAULT_FETCH_MODE, $fetch_arg=null, $ctor_array=array()) {
       switch ($fetch_style) {
           case PDO::FETCH_ASSOC: 
               return array(array('id'=>1,'nom'=>'velo1','descr'=>'super velo1', 'tarif'=>51.55, 'id_categ'=>1),
                            array('id'=>2,'nom'=>'velo2','descr'=>'super velo2', 'tarif'=>52.55, 'id_categ'=>1),
                            array('id'=>3,'nom'=>'velo3','descr'=>'super velo3', 'tarif'=>53.55, 'id_categ'=>1),
                            array('id'=>4,'nom'=>'velo4','descr'=>'super velo4', 'tarif'=>54.55, 'id_categ'=>1),
                            array('id'=>5,'nom'=>'velo5','descr'=>'super velo5', 'tarif'=>55.55, 'id_categ'=>1)
                            
                            ); 
               break;
           case PDO::FETCH_NUM : 
               return array(array(1,'velo1','super velo1', 51.55, 1),
                            array(2,'velo2','super velo2', 52.55, 1),
                            array(3,'velo3','super velo3', 53.55, 1),
                            array(4,'velo4','super velo4', 54.55, 1),
                            array(5,'velo5','super velo5', 55.55, 1));
               break;
       }
   }
   public function execute($params=array()) {
       return true;
   }
   public function rowCount() {
       return 5;
   }
}

/**
 *
 * Mock database class implementing a subset
 * of the PDO API.
 *
 */
class MockPDO extends PDO {

   /**
    * Return a dummy PDO statement
    */
   public function prepare($statement, $driver_options=array()) {
       $this->last_query = new MockPDOStatement($statement);
       return $this->last_query;
   }
   public function lastInsertId($name = null) {
       return 1001;
   }
}


?>

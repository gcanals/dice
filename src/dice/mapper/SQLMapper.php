<?php
/**
   * File : SQLMapper.php
   *
   * @author Gerome Canals
   *
   *
   * @package mapper
   */

namespace dice\mapper ;

/**
 *  La classe SQLMapper
 *
 *  La Classe SQLMapper est un DAO générique pour une base SQL
 *  Les objets mappés doivent implanter l'interface iDataMappable

 *
 *  @package model
 */

abstract class SQLMapper implements iDataMapper {
    
    
    /**
     * _conf : store the name of the configuration to be used in the config file
     * @access protected
     * @var type String
     */
    protected static $_conf ;
    
    /**
     * _db : connexion to the database, typically a PDO instance
     * @access protected
     * @var type resssource
     */

    protected $_db ;
    
    /**
     *  Nom de la colonne Identifiant de l'objet dans la base
     *  @access protected
     *  @var string
     */
     protected $_toid ='id';

    /**
     *  Nom du model
     *  
     *  @access protected
     *  @var String
     */
    protected  $_mname  ;
        
    /**
     *  Nom de la table correspondant au model
     *  par défaut le nom de la classe
     *  @access protected
     *  @var String
     */
    protected  $_tname ;
        
    /**
     *   tableau des attributs : attname=>type
     *   valeur pour le type :
     *   'int', 'date' : traités sans changement
     *   'string' : autorise l'utilisation de % dans les critères de recherche
     */
    protected  $_a = array(); 
    
    /**
     * _last_query : dernère requête utilisée, utile pour logger
     * 
     * @var String
     */
    protected $_last_query = null;
    /**
     * _last_query_params : paramètres de la dernière requète, utile pour logger
     * 
     * @var Array
     */
    protected $_last_query_params=array();
    
    /**
     * Reference to previously used PDOStatement object to enable low-level access, if needed
     * e.g. rowCount()
     */
    protected $_last_statement = null;
     
        
        
    /**
     *  constantes pour paramétrer la recherche
     */
        const   ORDER_ASC = 'ASC';
        const   ORDER_DESC = 'DESC';
        const   SINGLE = 0;
        const   MULTI = 1;
        
    /**
     * the generic constructor: receives and store a connexion to the db or creates
     * it by calling the connexion factory
     * 
     * @param type $connexion a ressource link to the db
     */
    public function __construct($connexion=null) {
        if (!is_null($connexion)) {
            $this->_db=$connexion;
        }
	else {
            $conf = static::getDefaultDBConf();
            $this->_db = ConnectionFactory::makeConnection($conf);
        }
    }
    
    
   /**
    * static methods for DB configuration at the class level
    * useful to override the configuration at the Dice level (DiceConfigure)
    * and to define a per-class db connection
    * 
    * @api
    * @params String $conf le nom de la configuration 
    */
    
    public static function setDefaultDBConf($conf) {
        static::$_conf = $conf ;
    }
    public static function getDefaultDBConf() {
        if ( isset (static::$_conf)) return static::$_conf;
        if ( isset (self::$_conf)) return self::$_conf;
        return \DiceConfigure::getDefaultDBConf()  ;
    }
    
    
    /**
     * Teste la validité d'un nom d'attribut
     * en vérifiant sa présence dans le tableau des attributs
     * 
     * @api
     * @param String $attname
     * @return boolean true si le nom de l'attribut est correct, false sinon
     */
    public function isAValidAttributeName($attname) {
        if (array_key_exists( $attname, $this->_a)) return true;
        return false;
    }
    
    /**
     * returns the last executed query, as a string
     * useful for testing/debugging/logging
     * 
     * @api
     * @return String last executed query
     */
    public function get_last_query() {
        return $this->_last_query;
    }
    /**
     * returns the last executed query parameters,
     * 
     * @api 
     * @return Array last executed query parameters
     */
    public function get_last_query_params() {
        return $this->_last_query_params;
    }
    /**
     * returns the last PDOstatement, useful for
     * low level operations that are outside the mapper
     * e.g. rowCount()
     * 
     * @api
     * @return PDOStatement last statement
     */
    public function get_last_statement() {
        return $this->_last_statement;
    }
   
    /**
     * execute : execute a query with the given parameters
     * log it as a string if needed
     * 
     * @api
     * @param String $query the sql query to be executed, with placeholders 
     * @param Array $parameters the parameters to be used
     * @return boolean true or false
     */
    protected function _execute($query, $parameters) {
        
        $this->_last_query=$query;
        $this->_last_query_params=$parameters;
        $stmt=$this->_db->prepare($query);
        $result=$stmt->execute($parameters);
        $this->_last_statement=$stmt;
        return $result;
        
    }
    
    
  /**
   *   Insertion dans la base
   *
   *   Insère l'objet comme une nouvelle ligne dans la table
   *   
   *   @api
   *   @return iDataMappable objet métier inséré dans la base
   *   @param \dice\model\Model $m l'objet métier à insérer
   *   @thows MapperException si la requête échoue pur une raison quelconque
   */	

    public function _insert (\dice\model\Model $m) {

     $into_query = "insert into ". $this->_tname. " (" ;
     $values_query = "values (";
     foreach ($this->_a as $attname=>$attype) {
          $into_query .= $attname .",";
          $values_query .= " ? ,";
          $values_array[] = ( !is_null($m->getAttr($attname)) ? $m->getAttr($attname) : 'null');
          
      }
      
      // suppress the last comma
      $into_query = substr($into_query,0,-1);
      $values_query = substr($values_query,0,-1);
      // close parenthesis
      $into_query .= ")";  
      $values_query .= ")";  
      
     $insert_query = $into_query . " " . $values_query ;  
     try {
  
        $r = $this->_execute($insert_query, $values_array);
        $m->setOid( $this->_db->lastInsertId($this->_tname) );
    } catch (\PDOException $e)
      {
	throw new MapperException($e->getMessage());
      } 
      return $m;

  }

 /**
   *   Suppression dans la base
   *
   *   Supprime la ligne dans la table corrsepondant à l'objet passé
   *   L'objet doit posséder un OID
  * 
  *   @api
  *   @param \dice\model\Model $m the model to be deleted in the database
  *   @thows MaperException if the object id is undefined or if the delete query fails for some reason
   */
 public function _delete(\dice\model\Model $m) {

   if (is_null($m->getOid()) ) {
      throw new MapperException($this->_mname . ": Primary Key undefined : cannot delete");
    } 
    
    $del_query = "delete from ". $this->_tname ." where " . $this->_toid . "= ?"; 

    try {
        $r = $this->_execute($del_query,array($m->getOid() ));
    } catch (\PDOException $e)
      {
	echo $query . "<br>";
	throw new MapperException($e->getMessage());
      } 
        return $r;
    }
    
    
    
  /**
   *   Mises à jour dans la base
   *
   *   Update de la ligne de la base correspondant à  l'objet passé
   *   
   *   @return int nombre de lignes mises à jour 
   *   @param \dice\model\Model $m l'objet métier à mettre à jour
   *   @throws MapperException si l'objet n'a pas d'ID ou si la requête échoue 
   *   pour une raison quelconque 
   */							
 public function _update(\dice\model\Model $m) {
     
    if (is_null($m->getOid())) {
      throw new MapperException($this->_tname . ": Primary Key undefined : cannot update");
    } 
    $update_query = "update " . $this->_tname . " set ";
    
    foreach ($this->_a as  $table_column =>$attype) {  
      $update_query .= "$table_column = ? ,";
      $update_array[] = $m->getAttr($table_column) ;
    }

    $update_query = substr($update_query,0,-1);
    $update_query .= " where ".$this->_toid . " = ". $m->getOid();
    
    try {
        //$st = $this->_db->prepare($update_query) ;
        $r = $this->_execute($update_query,$update_array );

    } catch (\PDOException $e)
      {
	echo $query . "<br>";
	throw new MapperException($e->getMessage());
      } 
    
      
      return 1;

  } 
    
   /**
     * _find : recherche multi-critères
     * le paramètres contient des conditions de selection et d'ordonnancement du résultat
     * $params['conditions'] : array(  att => value, ... ))
     * $params['orders']['orderby'] = 'att1, att2 ..'
     * $params['orders']['ord'] = SQLMapper::ORDER_ASC / SQLMapper::ORDER_DESC
     * 
     * @api
     * @param Array $params 
     * @return Array renvoie le tableau d'objet correspondant au résultat de la requête
    *  @throws MapperException en cas d'erreur dans l'execution de la requête
     */
    
    
    public function _find ($args=null) {
        
        
        if (is_int($args)) {
            
            $params['conditions']=array($this->_toid => $args);
        } else $params=$args ;

        
        
        $query = "select * from ".$this->_tname ;
        $cond = ((is_array($params) && array_key_exists('conditions',$params ))?$params['conditions']:null);
        $orders =(is_array($params) && array_key_exists('orders',$params)?$params['orders']:null);
        $bind_val=array();
        if ( !is_null($cond)&& is_array($cond)) {
            $query .=  " where ";
            foreach ($cond as $att => $val) {
                switch ($this->_a[$att]) {
                    case 'string': { $query .= "$att LIKE ?" ;  break;}
                    default:   { $query .=  "$att = ?";  }
                }
                $bind_val[]=$val;
                $query .= " AND ";
            }
            $query = substr($query, 0, -5);
         
        }
        $orderby=null;
        $ord=null;
        if (!is_null($orders)) {
            $orderby=(is_array($params) && array_key_exists('orderby',$orders)?$orders['orderby']:null);
            $ord = (is_array($params) && array_key_exists('ord',$orders )?$orders['ord']:null);
        }
        if (!is_null($orderby)) {
            $query .= ' ORDER BY ' . $orderby . ' ';
            $query .= ( is_null($ord) ? SQLMapper::ORDER_ASC : $ord) ;
        }
         
        try{
            
            $this->_execute($query, $bind_val);
        }
        catch(\PDOException $e){
            echo $e->__toString();
            throw new MapperException($e->getMessage());
        }
	$all = array();
	if ($this->_last_statement->rowCount() < 1) return null ;
	
	foreach ( $this->_last_statement->fetchAll(\PDO::FETCH_ASSOC) as $i=>$row) {
            $r = new $this->_mname($this);
            foreach ($row as $tcolumn => $tval) {
               
               $r->setAttr($tcolumn, $tval);
            }
            $all[] = $r;
	}
	
        return $all; 
            
        
    }

     

}

<?php
/**
   * File : DBModel.php
   *
   * @author Gerome Canals
   *
   *
   * @package model
   */

namespace dice\model ;


/**
 *  La classe Model
 *
 *  La Classe DBModel réalise un Active Record Générique pour le stockage 
 * elle utilise un mapper pour l'interface avec le stockage
 *  Cette classe est faite pour être sous-classée
 *
 *  @package model
 */
abstract class Model {


	 /**
	 *  Nom du model
         *  
  	 *  @access protected
	 *  @var String
	 */
    
	protected  $_mname = __CLASS__ ;
        
        
        
        /**
	 *  type de mapper par défaut, a utiliser s'il 
         * n'est pas fourni au constructeur
         *  
  	 *  @access protected
	 *  @var String
	 */
	protected  static $_defaultMapperClass ;
	 
        /**
	 *  configuration pour l'accès au stockage à 
         * utiliser par défaut
         *  
  	 *  @access protected
	 *  @var String
	 */
        protected $_config_default ;
        
        /**
	 *  Mapper pour l'acces à la base
  	 *  @access protected
	 *  @var iDataMapper
	 */
	protected $_mapper ;
 
	/**#@+
	 *  @access protected
	 *  @var array
	 */ 
        
        /**
          *  tableau des attributs : attname=>type
          */
	protected $_a = array();

	 /**
          *  tableau des valeur : attname=>val
          */
	public $_v = array();

        /**#@-*/
        
        /**
	 *  attribut identifiant du model
         *  
  	 *  @access protected
	 *  @var String
	 */
        public $_oid ='id';
        


 


  /**
   *  Constructeur d'objet
   *
   *  fabrique un nouvel objet vide
   */
  public function __construct(\dice\mapper\iDataMapper $dm =null) {
       
       $this->_mapper = $dm ;
       if (is_null($this->_mapper)) {
        
              $mapperName=static::getDefaultMapperClass();
             
            $this->_mapper = new $mapperName();
        }
  }

  /**
   * static methods for default mapper management
   */
  public static function setDefaultMapperClass($classname){
      static::$_defaultMapperClass=$classname;
  }
  public static function getDefaultMapperClass(){
      return static::$_defaultMapperClass;
  }


  /**
   *  Magic pour imprimer
   *
   *  Fonction Magic retournant une chaine de caract?res imprimable
   *  pour imprimer facilement un model
   *
   *   @access public
   *   @return String
   */
  public function __toString() {
    $string=  "[". $this->_mname ."::". (isset($this->_v[$this->_oid])?$this->_v[$this->_oid]:null). "]" ; 
    $string .= $this->json();
    return $string ;
                                 
  }
  
  /**
   * json serialization
   * 
   * @access public
   * @return string
   */
  
  public function json() {
      return json_encode($this->_v);
  }

 /**
   *   Getter pour OID
   *
   *   retourne l'identifiant d'objet
   *   @access public
   *   @return int
   */
  public function getOid() {
      
      if (!array_key_exists($this->_oid, $this->_a))
          throw new ModelException("undefined object id for model ".
                                    $this->_mname, 128);
      if (!array_key_exists($this->_oid, $this->_v)) return null;
      
      return $this->_v[$this->_oid];
    } 
 /**
   *   Setter pour OID
   *
   *   retourne l'identifiant d'objet
   *   @access public
   */
  public function setOid($id) {
      if (!array_key_exists($this->_oid, $this->_a))
          throw new ModelException("undefined object id for model ".
                                    $this->_mname, 128);
	$this->_v[$this->_oid]=$id;
    } 
 /**
   *   Getter pour ModelName
   *
   *   retourne le nom du model
   *   @access public
   *   @return String
   */
  public function getModelName() {
      return $this->_mname;
    } 


/**
   *   Getter pour attributes
   *
   *   retourne lla liste des attributs du model
   *   @access public
   *   @return Array
   */
  public function getAttributes() {
      return $this->_a;
    } 
 
    /**
   *   Getter pour valeurs
   *
   *   retourne le tableau des valeurs de l'objet 
   *   @access public
   *   @return Array
   */
  public function getValues() {
      return $this->_v;
    } 

  /**
   *   Getter générique
   *
   *   fonction d'acc?s aux attributs d'un objet.
   *   Recoit en paramètre le nom de l'attribut accédé
   *   et retourne sa valeur.
   *  
   *   @access public
   *   @param String $attr_name attribute name 
   *   @return mixed
   */
  public function getAttr($attr_name) {
    if (array_key_exists( $attr_name, $this->_a)) { 
      return (array_key_exists($attr_name, $this->_v) ? $this->_v[$attr_name]:null);
    } 
    $emess = $this->_mname . ": unknown attribute $attr_name (getAttr)";
    throw new ModelException($emess, 45);
  }
  
    /**
   *   fonction magique __get
   *   Ca mange pas de pain et permet de faire un peu de magie
   *   pour permettre l'accès aux attributs d'un objet.
   *   Recoit en paramètre le nom de l'attribut accédé
   *   et retourne sa valeur.
   *  
   *   @access public
   *   @param String $attr_name attribute name 
   *   @return mixed
   */
  public function __get($attr_name) {
    if (array_key_exists( $attr_name, $this->_a)) { 
      return (array_key_exists($attr_name, $this->_v) ? $this->_v[$attr_name]:null);
    } 
    $emess = $this->_mname . ": unknown attribute $attr_name (getAttr)";
    throw new ModelException($emess, 45);
  }
  
  
  /**
   *   Setter générique
   *
   *   fonction de modification des attributs d'un objet.
   *   Re?oit en param?tre le nom de l'attribut modifi? et la nouvelle valeur
   *  
   *   @access public
   *   @param String $attr_name attribute name 
   *   @param mixed $attr_val attribute value
   *   @return mixed new attribute value
   */
  public function setAttr($attr_name, $attr_val) {
    if (array_key_exists( $attr_name, $this->_a)) {
      $this->_v[$attr_name]=$attr_val; 
      return $this->_v[$attr_name];
    } 
    $emess = $this->_mname . ": unknown attribute $attr_name (setAttr)";
    throw new ModelException($emess, 45);   
  }
  
   /**
   *   fonction magique __set
   *
   *   Ca mange pas de pain et permet de faire un peu de magie
   *   pour la modification des attributs d'un objet.
   *   Recoit en paramètre le nom de l'attribut modifié et la nouvelle valeur
   *  
   *   @access public
   *   @param String $attr_name attribute name 
   *   @param mixed $attr_val attribute value
   *   @return mixed new attribute value
   */
  public function __set($attr_name, $attr_val) {
    if (array_key_exists( $attr_name, $this->_a)) {
      $this->_v[$attr_name]=$attr_val;
      return $this->_v[$attr_name];
    } 
    $emess = $this->_mname . ": unknown attribute $attr_name (setAttr)";
    throw new ModelException($emess, 45);   
  }

 /**
   *   Suppression dans la base
   *
   *   Supprime la ligne dans la table corrsepondantà l'objet courant
   *   L'objet doit posséder un OID
   */
  public function delete() {
    
    if (!isset($this->_v[$this->_oid])) {
      throw new ModelException($this->_mname . ": Primary Key undefined : cannot delete");
    } 
    return $this->_mapper->_delete($this);
    }
    
  

  

  /**
   *   Insertion dans la base
   *
   *   Insère l'objet comme une nouvelle ligne dans la table
   *   
   *   @return int nombre de lignes insérées 
   */									
  public function insert() {

     return $this->_mapper->_insert($this);
  }
  /**
   *   Mises à jour dans la base
   *
   *   Update la ligne de la base correspondant à  l'objet courant
   *   
   *   @return int nombre de lignes insérées 
   */									
  public function update() {

    if (!isset($this->_v[$this->_oid])) {
      throw new ModelException($this->_tname . ": Primary Key undefined : cannot update");
    } 
    return $this->_mapper->_update($this);
    
    }
    
    
    
    /**
     * find : recherche multi-critères
     * 
     * find_many : retourne 1 tableau
     * find_one : retourne 1 objet
     * le paramètres contient des conditions de selection et d'ordonnancement du résultat
     * $params['conditions'] : array(  att => value, att =>value ... ))
     * $params['orders']['orderby'] = 'att1, att2 ..'
     * $params['orders']['ord'] = DBModel::ORDER_ASC / DBModel::ORDER_DESC
     * 
     * @param Array $params 
     * @return Array renvoie le tableau d'objet correspondant au résultat de la requête
     */
    
  
    
    public static function find_many ($params=null) {
        $mapperClass = static::getDefaultMapperClass();
        $mapper = new $mapperClass();
        $all = $mapper->_find($params);
        if (is_null($all)) return null;
        return $all;
    }

    public static function find_one ($params=null) {
        $mapperClass = static::getDefaultMapperClass();
        $mapper = new $mapperClass();
        $all = $mapper->_find($params);
        if (is_null($all)) return null;
        return $all[0];
    }
   /**
     *   Magic __call : pour traiter les finders findByAtt( .. )
     *                   et les getters getAtt(); 
     *
     *   Renvoie toutes les lignes de la table possédant la valeur 
     *   passée en paramètre de l'appel pour l'attribut apparaissant 
     *   dans le nom de la méthode,
     *   sous la forme d'un tableau d'objet
     *  
     *   @return mixed renvoie la valeur d'un attribut(getter) ou un tableau d'objets(finder)
     */
    
    public function __call($method, $args) {
        
       // premier cas : les getters getAtt();
       $p= strpos($method, 'get');

       if (! ($p===false) ) {
            $att = strtolower(substr($method, 3));
            if (array_key_exists( $att, $this->_a)) { 
             return $this->_v[$att];
            } else return null;
             
        }
  
        // maintenant les finders 
        
        //extraire le nom de l'attribut
	$p = strpos($method, 'findBy');
        if ($p === false) return null ;
            
            
        $att = strtolower(substr($method, 6)); 
        if (! array_key_exists( $att, $this->_a) ) {
            return null;
        }
        /* 
         * on a le nom de l'attribut clé : $att
         * on a la valeur : $args[0]
         * et d'eventuels arguments (orders)
         * on balance tou au mapper qui se débrouille comme un grand
         */
         
        return $this->_mapper->_find( array('conditions' => array($att=>$args[0]),
                                            'orders' => ((is_null($args[1]))?null:$args[1])));
  
        
        
    }
	
}

   

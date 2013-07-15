<?php
/**
   * File : iDataMapper.php
   *
   * @author Gerome Canals
   *
   *
   * @package mapper
   */
namespace dice\mapper ;

/**
 *  interface iDataMaper pour le mapping de stockage d'un model
 *
 *  Spécifie les methodes CRUD pour la persistence des objets
 *
 *  @package mapper
 */
interface iDataMapper {

 public static function setDefaultDBConf($conf) ;
 public static function getDefaultDBConf() ;
 
 public function isAValidAttributeName($attname);
 
 public function _insert(\dice\model\Model $m) ;
 public function _find($args=null) ;
 public function _update(\dice\model\Model $m) ;
 public function _delete(\dice\model\Model $m) ;

 
}

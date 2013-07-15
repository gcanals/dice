<?php
  /**
   * ConnectionFactory : fabrique des connections vers le stockage
   *  
   *
   * @author Gérome Canals
   * @package mapper
   */
namespace dice\mapper ;

/**
 *  La classe ConnectionFactory : fabrique des connexions vers 
 * le système de stockage
 * 
 *  
 */

class ConnectionFactory {


  /**
   *   makeConnection() : fabrique une instance PDO 
   *   Charge le fichier de configuration
   *   
   *   @api
   *   @access public
   *   @params String $conf : le nom de la configuration à utiliser dans le fichier de config
   *   @return une connexion :  un nouvel objet PDO 
   *                            ou un lien mongo
   *                            ou False en cas d'erreur
   **/  
  public static  function makeConnection($conf=null) {
    $configpath = \DiceConfigure::getConfigFile();
    $ini_array= parse_ini_file($configpath,true);
    
    if (is_null($conf)) {
        $config = array_shift ($ini_array);
    } else $config = $ini_array[$conf];
   
    if (!$config) throw new ConnectionException("ConnectionFactory::makeConnection: could not parse config file $configpath <br/>");
    $storagetype = $config['storage'];
    
    if ($storagetype == "SQL") {
    $dbtype=$config['db_driver'];$host=$config['host']; $dbname=$config['dbname'];
    $user=$config['db_user']; $pass=$config['db_password']; 
    $port=( (isset($config['dbport']))?$config['dbport']:null);
    $dsn="$dbtype:host=$host;";
    if (!empty($port)) $dsn.="port=$port;";
    $dsn.="dbname=$dbname";
    try {
        //echo "new pdo : ";
        $db = new \PDO($dsn, $user,$pass, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                                               \PDO::ATTR_PERSISTENT=>true  ));
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    } catch(PDOException $e) {
            
	    throw new ConnectionException("connection: $dsn  ".$e->getMessage(). '<br/>');
    }
    return $db;
    }
  }


 

}

?>
	


  

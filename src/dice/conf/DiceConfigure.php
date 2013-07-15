<?php



/**
 * DiceConfigure : configuration class for dice
 * -> autoloader registration if not installed with composer
 * -> configuration file + configuration chapter in the config file
 *
 * @author canals
 */

define ('DICE_CLASS_FILE_SUFFIX' , '.php');
define ('DICE_INSTALLATION_DIR' , dirname(__FILE__) 
                                       . DIRECTORY_SEPARATOR . '..'
                                       . DIRECTORY_SEPARATOR . '..');

require 'SplClassLoader.php';

class DiceConfigure {
    
    private static $_configFile ;
    private static $_conf;
   
    /*
     * autoloadRegister : registers the dice autoloader, 
     * used as an alternative to composer install and autoload
     * 
     * @api
     */
    public static function autloadRegister() {
        echo DICE_INSTALLATION_DIR;
      $classLoader = new SplClassLoader(null, DICE_INSTALLATION_DIR);
      $classLoader->register();
        
     
    }
     
    /**
     * setConfigFile : sets the config file to be used by dice
     * 
     * @api
     * @param String $fileloc : absolute path to the config file location
     */
     
     public static function setConfigFile($fileloc) {
         self::$_configFile=$fileloc;
         
     }
     
     /**
      * getConfigFile : returns the current config file location
      * 
      * @api
      * @return String : the absolute path to the config file
      */
     public static function getConfigFile() {
         if ( isset (self::$_configFile)) return self::$_configFile;
         return dirname(__FILE__) . DIRECTORY_SEPARATOR .'db.config.ini';
         
     }
    
     /**
     * setDefaultDBConf : sets the default DB conf chapter to be used in the config file
     * 
     * @api
     * @param String $conf : DB conf chapter 
     */
    public static function setDefaultDBConf($conf) {
        self::$_conf = $conf ;
    }
    
    /**
     * getDefaultDBConf : returns the actual DB conf chapter 
     * 
     * @api
     * @return string 
     */
    public static function getDefaultDBConf() {
        if (isset(self::$_conf)) return self::$_conf  ;
        return 'DEFAULT';
    }
 
 
    

}

?>

<?php



/**
 * DiceConfigure : configuration class for dice
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
   
    public static function autloadRegister() {
        echo DICE_INSTALLATION_DIR;
      $classLoader = new SplClassLoader(null, DICE_INSTALLATION_DIR);
      $classLoader->register();
        
     
    }
     
     
     public static function setConfigFile($fileloc) {
         self::$_configFile=$fileloc;
         
     }
     
     public static function getConfigFile() {
         if ( isset (self::$_configFile)) return self::$_configFile;
         return dirname(__FILE__) . DIRECTORY_SEPARATOR .'db.config.ini';
         
     }
 
    public static function setDefaultDBConf($conf) {
        self::$_conf = $conf ;
    }
    public static function getDefaultDBConf() {
        if (isset(self::$_conf)) return self::$_conf  ;
        return 'DEFAULT';
    }
 
 
    

}

?>

<?php
 /**
   * ConnectionException.php : Exceptions pour les accès au stockage
   *
   * @author Gérôme Canals
   * @package mapper
   */
namespace dice\mapper ;

class ConnectionException extends Exception {

public function __construct($message, $code = 0) {
       
       // make sure everything is assigned properly
       parent::__construct($message, $code);
   }

   // custom string representation of object
public function __toString() {
       return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
   }
}
?>

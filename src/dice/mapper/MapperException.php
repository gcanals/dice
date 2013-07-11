<?php
  /**
   * File : ModelException.php
   *
   * @author Jeremy Fix
   * @author Gerome Canals
   *
   *
   * @package model
   */

namespace dice\mapper;

class MapperException extends \Exception {

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

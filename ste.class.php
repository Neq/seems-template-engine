<?php

/**
 * 
 * Seems Template Engine
 * Easy to use Template Engine for PHP5 (because of easy Function-Overloading).
 * Just use the basic idea of PHP, to be a Template-Language by itself.  * 
 * 
 * 
 * @author: Patrick Freitag
 * @id: $id$
 * 
 *  
 *   
 */

class SeemsTemplate {

  // No constructor needed	
  private function __construct() {}
  
  /**
   * Function for overloading. Getting the pre-defined Template-Vars.
   * 
   * @return Mixed
   * @param $memberName String
   */
  private function __get($memberName) {
  
    return $this->$memberName;
    
  }
 
  /**
   * Function for overloading. Auto-defining the Template-Vars. 
   * 
   * @return Mixed
   * @param $memberName String
   * @param $value Mixed
   */
  private function __set($memberName, $value) {
  
    $this->$memberName = $value;
    
  } 
  
  /**
   * Function for parsing the given Template.   *  
   * 
   * @return 
   * @param $temp_file String
   */  
  public function display($temp_file) {
  	  	
	include $temp_file;
	
  } 
    
}

/* This is just a example. Uncomment this Lines to get the thing working.
$view = new SeemsTemplate;
$view->name = "Test";
$view->customer_name = "Hihi";
$view->rows = array("test", "hannes", "peter", "fritz");
$view->display("test.php");*/

?>
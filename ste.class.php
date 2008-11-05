<?php

/**
 * 
 * Seems Template Engine
 * Easy to use Template Engine for PHP5 (because of easy Function-Overloading).
 * Just use the basic idea of PHP, to be a Template-Language by itself.
 *  
 * @author: Patrick Freitag - http://www.produc.de
 * @download: http://www.produc.de/downloads/seems_template.zip
 * @id: $id$   
 */

class SeemsTemplate extends SeemsTemplateCache {

  /**
   * Is checking if the Configuration of the .ini-Parameter "short_open_tag" is turned on.
   * Otherwise, the short form to embedding PHP into HTML is not possible.
   * @return exception
   */
  public function __construct() {
  	
	if(ini_get("short_open_tag") == 0) {
	
		throw new Exception("The php.ini-Configuration of \"short_open_tag\" is set to false and I have no possibility to change this Configuration. Please contact your admin for further Informations");	
		
	}
	
  }
  
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
   * Function for parsing the given Template. 
   * 
   * @return 
   * @param $temp_file String
   */  
  public function display($temp_file) {
  	
	ob_start();  	  	
	include $temp_file;	
	$temp_file_content = ob_get_contents();	
	ob_end_clean();
	//echo $temp_file_content;
	//echo "<br/>######<br/>";
	
	if($this->isCached($temp_file, $temp_file_content) === false OR $this->checkCacheFile($temp_file, $temp_file_content) === false) {		
	  //echo "Not cached";
	  echo $temp_file_content;
	  $this->addCacheFile($temp_file, $temp_file_content);	  	  
	} else {
	  //echo "Load from cache";
	  //echo $this->checkCacheFile($temp_file, $temp_file_content);
	  echo $this->getCachedFile($temp_file);
	}
	
  } 
    
}

/**
 * SeemsTemplateCache
 * This Class is for handling the Cache-Function.
 * 
 * @todo:
 *  - Add possibility to turn the cache-function off 
 *  - Add possibility to cache single fragments you can define in the code
 * 
 */
class SeemsTemplateCache {
	
	/**
	 * $cache_dir
	 * This is the link to the cache-Dir you want to use for your cached Files.
	 * It'll never start with a "/" and always end with a "/"
	 */
	public $cache_dir = "cache/";
	
	// Constructor not needed here
	private function __construct() {}
	
	/**
	 * isCached() is just checking if the File is already in the Cache.
	 * 
	 * @return Boolean
	 * @param $temp_file String
	 * @param $temp_file_content String
	 */
	protected function isCached($temp_file, $temp_file_content) {
				
		if(!file_exists($this->cache_dir . $temp_file . ".ste")) {		 
		   return false;		  
		} else {
		   return true;
		}
		
	}
	
	/**
	 * checkCacheFile() checks if the parsed content and the cached content is equal.
	 * 
	 * @return Boolean
	 * @param $temp_file String
	 * @param $temp_file_content String
	 */
	protected function checkCacheFile($temp_file, $temp_file_content) {
	
		$cache_file_content = file_get_contents($this->cache_dir . $temp_file . ".ste");
		
		if(substr_compare($temp_file_content, $cache_file_content, 0) != 0) {
		
		  // delete cache file and add new
		  //$this->addCacheFile($temp_file, $temp_file_content);
		  return false;
			
		} else {

		  return true;
			
		}
		
	}
	
	/**
	 * addCacheFile() adds the cached File to the Cache-Dir, or sets a new content
	 * 
	 * @return 
	 * @param $temp_file String
	 * @param $temp_file_content String
	 */
	protected function addCacheFile($temp_file, $temp_file_content) {
	
		if(!file_exists($this->cache_dir))
		  mkdir($this->cache_dir);
		  
		$temp_file_split = explode("/", $temp_file);
		$temp_file_count = count($temp_file_split);
				
		if($temp_file_count > 0)
		  $temp_file = $temp_file_split[$temp_file_count - 1];
	
		$fp = fopen($this->cache_dir . $temp_file . ".ste","w");
		fwrite($fp,$temp_file_content);
		fclose($fp);
		
	}		
	
	/**
	 * getCachedFile() returns the content of the given filename from the Cache.
	 * 
	 * @return String
	 * @param $cache_file String
	 */
	protected function getCachedFile($cache_file) {
	
		return file_get_contents($this->cache_dir . $cache_file . ".ste");
		
	}
	
	/**
	 * deleteCacheFile() deletes the given cache file from the Cache.
	 * It have to be executed again to rebuild the Cache.
	 * 
	 * @return 
	 * @param $cache_file String
	 */
	protected function deleteCacheFile($cache_file) {
	
		if(file_exists($this->template_dir . $cache_file))
	      unlink($this->template_dir . $cache_file);
		  if(file_exists($this->template_dir . $cache_file))
		    throw new Exception($cache_file . " couldn't be deleted. Maybe you don't have enough rights for this action.");
		else
  		  throw new Exception("You can't delete the Cache-File " . $cache_file . ", because it doesn't exist anymore.");		
		
	}
	
	/**
	 * clearCache() is deleting all files from the defined cache directory. 
	 * @return 	 
	 */
	protected function clearCache() {
	
		$del_dir = dir($this->cache_dir);
		
	    while(false !== ($file = $del_dir->read())) {
    	    unlink($file);
	    }
    	
		$dir->close();
		
	}
	
}

?>
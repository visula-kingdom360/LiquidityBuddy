<?php 
namespace App\Controllers;

   class Cookies_Access extends BaseController { 
	
      function __construct() { 
         helper("cookie");
      }
  
      // store a cookie value
      public function temp_cookie($name, $value, $expire) {
            
         set_cookie($name, $value, $expire);
         return get_cookie($name); 
      }
  
      public function stedy_cookie($name, $value) {
         set_cookie($name, $value);
         return get_cookie($name); 
      }
  
      public function check_cookie($name) {
         if(is_null(get_cookie($name))){
            return false;
         }else{
            return true;
         }
      }
      
      // get cookie value
      public function display_cookie($name) { 
         return get_cookie($name); 
      }
  
      // remove cookie value
      public function remove_cookie($name) { 
         delete_cookie($name); 
      }
		
   } 
?>
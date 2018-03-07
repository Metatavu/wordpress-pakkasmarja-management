<?php
  namespace Metatavu\Pakkasmarja\Settings;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  require_once('settings-ui.php');  
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Settings\Settings' ) ) {

    class Settings {

      public static function getValue($name) {
        $options = get_option('pakkasmarja_management');
        if ($options) {
          return $options[$name];
        }

        return null;
      }
      
    }

  }
  

?>
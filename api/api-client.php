<?php
  namespace Metatavu\Pakkasmarja\Api;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Api\ApiClient' ) ) {
    
    class ApiClient {
      
      private $url;
      
      public function __construct() {
        $this->url = \Metatavu\Pakkasmarja\Settings\Settings::getValue("api-url");
      }
      
      public function listUserGroups() {
        return $this->doGet('/rest/v1/userGroups'); 
      }
      
      private function doGet($path) {
        error_log('REQEST:' . print_r($path, true));
        
        $response = wp_remote_get( $this->url . $path );
        if (is_array($response)) {
          $statusCode = $response['response']['code'];
          $statusMessage = $response['response']['message'];
          $ok = $statusCode >= 200 && $statusCode <= 299;
          
          return [              
            'response' => $response,
            'json' => $ok ? json_decode($response['body'], true) : null,
            'ok' => $ok,
            'message' => $statusMessage
          ];
        }
        
        return [];
      }
    }
  }
  
?>
<?php
  namespace Metatavu\Pakkasmarja\Api;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Api\ApiClient' ) ) {
    
    class ApiClient {
      
      private $url;
      private $clientId;
      private $clientSecret;
      
      public function __construct() {
        $this->url = \Metatavu\Pakkasmarja\Settings\Settings::getValue("api-url");
        $this->clientId = \Metatavu\Pakkasmarja\Settings\Settings::getValue("client-id");
        $this->clientSecret = \Metatavu\Pakkasmarja\Settings\Settings::getValue("client-secret");
      }
      
      public function listUserGroups() {
        return $this->doGet('/rest/v1/userGroups'); 
      }
      
      private function getAuthorization() {
        $basic = \base64_encode("$this->clientId:$this->clientSecret");
        return "Basic $basic";
      }
      
      private function getHeaders() {
        $authorization = $this->getAuthorization();
        return [
          "Authorization" => $authorization
        ];
      }
      
      private function doGet($path) {
        $response = wp_remote_get( $this->url . $path, [
            headers => $this->getHeaders() 
        ]);
        
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
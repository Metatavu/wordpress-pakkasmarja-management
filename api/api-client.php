<?php
  namespace Metatavu\Pakkasmarja\Api;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../vendor/autoload.php');
  
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

      /**
       * Returns new instance of ContactsApi
       * 
       * @return \Metatavu\Pakkasmarja\Api\ContactsApi
       */
      public static function getContactsApi() {
        return new \Metatavu\Pakkasmarja\Api\ContactsApi(null, self::getConfiguration());
      }

      /**
       * Returns new instance of ContractsApi
       * 
       * @return \Metatavu\Pakkasmarja\Api\ContractsApi
       */
      public static function getContractsApi() {
        return new \Metatavu\Pakkasmarja\Api\ContractsApi(null, self::getConfiguration());
      }

      /**
       * Returns new instance of ItemGroupsApi
       * 
       * @return \Metatavu\Pakkasmarja\Api\ItemGroupsApi
       */
      public static function getItemGroupsApi() {
        return new \Metatavu\Pakkasmarja\Api\ItemGroupsApi(null, self::getConfiguration());
      }

      /**
       * Returns new instance of OperationReportsApi
       * 
       * @return \Metatavu\Pakkasmarja\Api\OperationReportsApi
       */
      public static function getOperationReportsApi() {
        $result = new \Metatavu\Pakkasmarja\Api\OperationReportsApi(null, self::getConfiguration());
        return $result;
      }

      /**
       * Returns new instance of OperationsApi
       * 
       * @return \Metatavu\Pakkasmarja\Api\OperationsApi
       */
      public static function getOperationsApi() {
        return new \Metatavu\Pakkasmarja\Api\OperationsApi(null, self::getConfiguration());
      }

      /**
       * @deprecated
       */
      public function listUserGroups() {
        return $this->doGet('/rest/v1/userGroups'); 
      }
      
      /**
       * @deprecated
       */
      private function getAuthorization() {
        $basic = \base64_encode("$this->clientId:$this->clientSecret");
        return "Basic $basic";
      }
      
      /**
       * @deprecated
       */
      private function getHeaders() {
        $authorization = $this->getAuthorization();
        return [
          "Authorization" => $authorization
        ];
      }
      
      /**
       * @deprecated
       */
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

      /**
       * Returns client configuration
       * 
       * @returns \Metatavu\Pakkasmarja\Configuration
       */
      private static function getConfiguration() {
       $result = \Metatavu\Pakkasmarja\Configuration::getDefaultConfiguration();
       $result->setHost(\Metatavu\Pakkasmarja\Settings\Settings::getValue("api-url"));
       $result->setApiKey("Authorization", "Bearer " . self::getAccessToken());
       return $result;
      }

      private static function getAccessToken() {
        $userId = wp_get_current_user()->ID;
        $tokenResponse = get_user_meta($userId, 'openid-connect-generic-last-token-response', true);
        
        // TODO: Validate, refresh...
        if (isset($tokenResponse)) {
          return $tokenResponse['access_token'];
        }

        return null;
      }
      
    }
  }
  
?>
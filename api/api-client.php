<?php
  namespace Metatavu\Pakkasmarja\Api;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../vendor/autoload.php');
  require_once( __DIR__ . '/contracts-api-ext.php');

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
        return new \Metatavu\Pakkasmarja\Api\ContractsApiExt(null, self::getConfiguration());
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
       * Returns new instance of DeliveryPlacesApi
       * 
       * @return \Metatavu\Pakkasmarja\Api\DeliveryPlacesApi
       */
      public static function getDeliveryPlacesApi() {
        return new \Metatavu\Pakkasmarja\Api\DeliveryPlacesApi(null, self::getConfiguration());
      }

      /**
       * @deprecated
       */
      public function listUserGroups() {
        return $this->doGet('/userGroups'); 
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
        $response = wp_remote_get($this->url . $path, [
          'headers' => $this->getHeaders() 
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

      /**
       * Returns access token for logged user. 
       * 
       * Token is retrived from previously stored values from OpenID Connect Generic -plugin.
       * 
       * @return string access token for logged user
       */
      private static function getAccessToken() {
        if (!is_user_logged_in()) {
          return null;
        }

        $userId = wp_get_current_user()->ID;

        self::ensureFreshToken($userId);
        $tokenResponse = get_user_meta($userId, 'openid-connect-generic-last-token-response', true);
        
        if (isset($tokenResponse)) {
          return $tokenResponse['access_token'];
        }

        return null;
      }

      /**
       * Ensures that user has valid access token 
       */
      private static function ensureFreshToken($userId) {
        $sessionTokens = \WP_Session_Tokens::get_instance($userId);
        $session = $sessionTokens->get(wp_get_session_token());
        
        if (!isset($session)) {
          error_log("Failed to resolve session, could not refresh token");
          return;
        }

        $refreshInfo = $session["openid-connect-generic-refresh"];
        if (!isset($refreshInfo)) {
          error_log("Failed to resolve session refresh info, could not refresh token");
          return;
        }

        $now = current_time('timestamp', true);
        $refreshTime = $refreshInfo['next_access_token_refresh_time'];
        if ($now < $refreshTime) {
          // Token is still valid, no need to refresh
          return;
        }

        $refreshToken = $refreshInfo['refresh_token'];
        $refreshExpires = $refreshInfo['refresh_expires'];

        if (!$refreshToken || ($refreshExpires && $now > $refreshExpires)) {
          error_log("Failed to resolve refresh token, logout from the Wordpress");
          wp_logout();
          return;
        }

        $tokenResponse = self::refreshAccessToken($refreshToken);
        if (!isset($tokenResponse)) {
          error_log("Failed to refresh access token, logout from the Wordpress");
          wp_logout();
          return;
        }

        self::saveAccessToken($userId, $refreshToken, $tokenResponse);
      }

      /**
       * Saves new access token
       * 
       * @param int $userId user id 
       * @param string $refreshToken previous refresh token
       * @param array $tokenResponse token response
       */
      private static function saveAccessToken($userId, $refreshToken, $tokenResponse) {
        $sessionTokens = \WP_Session_Tokens::get_instance($userId);
        $session = $sessionTokens->get(wp_get_session_token());
        
        $now = current_time('timestamp' , true);
        $session["openid-connect-generic-refresh"] = [
          'next_access_token_refresh_time' => $tokenResponse['expires_in'] + $now,
          'refresh_token' => isset($tokenResponse['refresh_token']) ? $tokenResponse : $refreshToken,
          'refresh_expires' => false
        ];

        $session = $sessionTokens->get($token);
        $sessionTokens->update($sessionToken, $session);

        update_user_meta($userId, 'openid-connect-generic-last-token-response', $tokenResponse);
      }

      /**
       * Refreshes access token
       * 
       * @param String $refreshToken refresh token
       * @return array token response 
       */
      private static function refreshAccessToken($refreshToken) {
        $settings = self::getOpenIdSettings();

        $clientId = $settings["client_id"];
        $clientSecret = $settings["client_secret"];
        $tokenEndpoint = $settings['endpoint_token']; 

        $request = [
          'body' => [
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'refresh_token'
          ]
        ];

        $response = wp_remote_post($tokenEndpoint, $request);
        if (is_wp_error($response)) {
          error_log("Failed to refresh token: " . print_r($response, true));
          return null;
        }

        return json_decode($response['body'], true);
      }

      /**
       * Returns OpenID Connect Generic -plugin settings
       * 
       * @return array OpenID Connect Generic -plugin settings
       */
      private static function getOpenIdSettings() {
        return get_option('openid_connect_generic_settings');
      }

    }
  }
  
?>
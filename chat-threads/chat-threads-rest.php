<?php
  namespace Metatavu\Pakkasmarja\ChatThreads;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( 'Metatavu\Pakkasmarja\ChatThreads\ChatThreadsRest' ) ) {
    
    class ChatThreadsRest {
      
      public function __construct() {
        register_rest_field( 'chat-thread', 'user-group-setings', [
          'get_callback' => [$this, 'getUserGroupsMeta'],
          'update_callback' => null,
          'schema' => [
            "type" => "array",
        	  "description" => "User group settings",
            "items" => [
              "type" => "object",
              "properties" => [
                "id" => [
                  "description" => "Id of user group",
                  "type" => "string",
                  "format" => "uuid"
                ],
                "role" => [
                  "description" => "Role of user group in a thread",
                  "type" => "string"
                ]
              ]
            ] 
          ]
        ]);
      }

      public function getUserGroupsMeta($object) {
        $result = [];
        
        $options = get_post_meta($object[ 'id' ], 'pm-user-group-options', true);
        
        foreach ($options as $id => $userGroupOptions) {
          if ($userGroupOptions['allowed'] === true) {
            $role = $userGroupOptions['role'];
            $result[] = [
              "id" => $id,
              "role" => $role
            ];
          }
        }
        
      	return $result;
      }

    }
  
  }
  
  add_action('rest_api_init', function () {
    new ChatThreadsRest();
  });
  
?>
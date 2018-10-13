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

        register_rest_field( 'chat-thread', 'predefined-texts', [
          'get_callback' => [$this, 'getPredefinedTexts'],
          'update_callback' => null,
          'schema' => [
            "type" => "array",
        	  "description" => "Array of predefined texts",
            "items" => [
              "text" => [
                "description" => "Predefined text",
                "type" => "string"
              ]
            ]
          ]
        ]);

        register_rest_field('chat-thread', 'answer-type', [
          'get_callback' => [$this, 'getAnswerType'],
          'update_callback' => null,
          'schema' => [
            "type" => "string",
        	  "description" => "Answer type"
          ]
        ]);

        register_rest_field('chat-thread', 'expires', [
          'get_callback' => [$this, 'getExpires'],
          'update_callback' => null,
          'schema' => [
            "type" => "string",
        	  "description" => "Expire time"
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

      /**
       * Returns predefined texts for REST field
       * @return String[] array of predefined texts
       */
      public function getPredefinedTexts($object) {
        $texts = get_post_meta($object[ 'id' ], 'pm-predefined-texts');
        return empty($texts) ? [] : $texts;
      }

      /**
       * Returns answer type for REST field
       * @return String answer type
       */
      public function getAnswerType($object) {
        return get_post_meta($object[ 'id' ], 'pm-answer-type', true);
      }

      /**
       * Returns expires for REST field
       * @return String expires
       */
      public function getExpires($object) {
        return get_post_meta($object[ 'id' ], 'pm-expires', true);
      }

    }
  
  }
  
  add_action('rest_api_init', function () {
    new ChatThreadsRest();
  });
  
?>
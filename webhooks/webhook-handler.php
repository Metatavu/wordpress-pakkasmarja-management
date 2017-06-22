<?php
  namespace Metatavu\Pakkasmarja\Webhooks;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Webhooks\WebhookHandler' ) ) {
    
    class WebhookHandler {
      
      private $url;
      
      public function __construct() {
        $apiUrl = \Metatavu\Pakkasmarja\Settings\Settings::getValue("api-url");
        $this->url = "$apiUrl/webhooks/management";
        add_action('edit_post', [$this, "onEditPost"]);
      }
      
      public function onEditPost($id) {
        $post = get_post($id);
        $status = $post->post_status;
        $type = $post->post_type;
        $this->doPostRequest("ID=$id&post_status=$status&post_type=$type&hook=edit_post");
      }
      
      private function doPostRequest($body) {
        $bg = " > /dev/null 2>&1 &";
        $command = "curl -X POST -H 'Content-Type: application/x-www-form-urlencoded' '$this->url' -d '$body'$bg"; 
        exec($command);
      }
      
    }
  
  }
  
  add_action('init', function () {  
    new WebhookHandler();
  });
  
?>
<?php

  namespace Metatavu\LinkedEvents\Wordpress\UI;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  require_once( __DIR__ . '/../api/api-client.php');
  
  add_action('wp_ajax_pakkasmarja_operation_create', function () {
    /** TODO: Capability
    if (!current_user_can('pakkasmarja_operation_create')) {
      wp_die("User does not have permission to create operations", 403);
      return;
    }
    */
    $operationsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getOperationsApi();
    
    $type = $_GET['type'];
    $body = new \Metatavu\Pakkasmarja\Api\Model\Operation([
      "type" => $type
    ]);

    $operationsApi->createOperation($body);

    wp_die();
  });
  
?>
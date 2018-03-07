<?php
  
  namespace Metatavu\Pakkasmarja\Contracts;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../api/api-client.php');

  if (!class_exists( '\Metatavu\Pakkasmarja\Contracts\Xlsx' ) ) {
    
    class Xlsx {

      public function __construct() {
        add_action( 'plugins_loaded', function () {
          $page = $_GET['page'];
          $action = $_GET['action'];

          if (current_user_can('pakkasmarja_contracts_view') && $page === 'contract.php' && $action === 'xlsx') {
            $xlsxResponse = \Metatavu\Pakkasmarja\Api\ApiClient::getContractsApi()->listContractsXLSX();
            $body = $xlsxResponse->getBody();
            $contentType = $xlsxResponse->getHeader('Content-Type')[0];
            $contentDisposition = $xlsxResponse->getHeader('Content-Disposition')[0];  
            header(sprintf("Content-type: %s", $contentType));
            header(sprintf("Content-Disposition: %s", $contentDisposition));
            echo $body; 
            exit;
          }
        });
      }
      
    }
    
  }

  if (is_admin()) {
    new Xlsx();    
  }
    
?>
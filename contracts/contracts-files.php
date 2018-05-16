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

          if (current_user_can('pakkasmarja_contracts_view') && $page === 'contract.php') {
            switch ($action) {
              case 'xlsx':
                $firstResult = 0;
                $maxResults = 1000;
                $accept = null;
                $listAll = "true";
                $itemGroupCategory = null;
                $itemGroupId = sanitize_text_field($_REQUEST["item-group-id"]);
                $year = sanitize_text_field($_REQUEST["year"]);
                $status = sanitize_text_field($_REQUEST["status"]);

                if (!$year) {
                  $year = intval(date("Y"));
                }

                if ($itemGroupId === "all") {
                  $itemGroupId = null;
                }

                if ($year === "all") {
                  $year = null;
                }

                if ($status === "all") {
                  $status = null;
                }

                $xlsxResponse = \Metatavu\Pakkasmarja\Api\ApiClient::getContractsApi()->listContractsXLSX($accept, $listAll, $itemGroupCategory, $itemGroupId, $year, $status, $firstResult, $maxResults);
                $body = $xlsxResponse->getBody();
                $contentType = $xlsxResponse->getHeader('Content-Type')[0];
                $contentDisposition = $xlsxResponse->getHeader('Content-Disposition')[0];  
                header(sprintf("Content-type: %s", $contentType));
                header(sprintf("Content-Disposition: %s", $contentDisposition));
                echo $body; 
                exit;
              break;
              case 'single-pdf':
                $id = $_GET['id'];
                $type = $_GET['type'];
                $pdfResponse = \Metatavu\Pakkasmarja\Api\ApiClient::getContractsApi()->getContractDocumentWithHttpInfo($id, $type, "PDF");
                $body = $pdfResponse[0];
                $headers = $pdfResponse[2];
                $contentType = $headers['Content-Type'];
                $contentDisposition = $headers['Content-Disposition'];  
                header(sprintf("Content-type: %s", $contentType));
                header(sprintf("Content-Disposition: %s", $contentDisposition));
                echo $body;
                exit;
              break;
            }
          }
        });
      }
      
    }
    
  }

  if (is_admin()) {
    new Xlsx();    
  }
    
?>
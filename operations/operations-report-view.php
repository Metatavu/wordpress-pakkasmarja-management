<?php
  
  namespace Metatavu\Pakkasmarja\Operations;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/operation-formatter.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Operations\OperationReportView' ) ) {
    
    class OperationReportView {

      // TODO: Custom capability
      private $capability = 'manage_options';
            
      public function __construct() {
        $this->operationReportsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getOperationReportsApi();
        
        add_action( 'admin_menu', function () {
          add_submenu_page(NULL, __('View Operation', 'pakkasmarja_management'), __('View Operation', 'pakkasmarja_management'), $this->capability, 'pakkasmarja-operation-report-view.php', [ $this, 'renderOperationReportView' ]);
        });
      }

      /**
       * Renders operation report view
       */
      public function renderOperationReportView() {
        $id = sanitize_text_field($_GET['id']);

        echo '<div class="wrap">';
        $operationReport = $this->findOperationReport($id);
        $items = $this->listOperationReportItems($id);
        $backLink = sprintf('<a href="%s" class="page-title-action">%s</a>', "?page=operation.php", __('Back', 'pakkasmarja_management'));

        echo sprintf('<h1 class="wp-heading-inline">%s - %s %s</h1><br/><br/>', Formatter::formatOperationType($operationReport->getType()), Formatter::formatDateTime($operationReport->getStarted()), $backLink);
        echo sprintf('<table class="wp-list-table widefat">');
        echo sprintf('<thead><tr><th>%s</th><th>%s</th></tr></thead>', __('Status', 'pakkasmarja_management'), __('Message', 'pakkasmarja_management'));
        echo '<tbody>';
        foreach ($items as $item) {
          echo sprintf('<tr><td>%s</td><td>%s</td></tr>', $this->getStatus($item->getStatus()), $item->getMessage());
        }

        echo '</tbody></table>';
        echo '</div>';
      }

      private function getStatus($status) {
        return Formatter::formatOperationItemStatus($status);
      }

      private function findOperationReport($operationReportId) {
        try {
          return $this->operationReportsApi->findOperationReport($operationReportId);
        } catch (\Metatavu\Pakkasmarja\ApiException $e) {
          echo '<div class="error notice">';
          if ($e->getResponseBody()) {
            echo print_r($e->getResponseBody());
          } else {
            echo $e;
          }

          echo '</div>';
        }
      }

      private function listOperationReportItems($operationReportId) {
        try {
          return $this->operationReportsApi->listOperationReportItems($operationReportId);
        } catch (\Metatavu\Pakkasmarja\ApiException $e) {
          echo '<div class="error notice">';
          if ($e->getResponseBody()) {
            echo print_r($e->getResponseBody());
          } else {
            echo $e;
          }

          echo '</div>';
        }
      }
      
    }
    
  }
  
  add_action('init', function () {
    if (is_admin()) {
      new OperationReportView();
    }
  });

  
    
?>
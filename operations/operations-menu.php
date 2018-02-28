<?php
  
  namespace Metatavu\Pakkasmarja\Operations;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/operation-reports-table.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Operations\Menu' ) ) {
    
    class Menu {

      // TODO: Custom capability
      private $capability = 'manage_options';
            
      public function __construct() {
        add_action( 'admin_menu', function () {
          add_menu_page(__('Operations', 'pakkasmarja_management'), __('Operations', 'pakkasmarja_management'), $this->capability, 'operation.php', [ $this, 'renderOperationPage' ], 'dashicons-update', 50);
        });
      }
      
      /**
       * Renders operations table
       */
      public function renderOperationPage() {
        echo '<div class="wrap">';

        echo sprintf('<h1 class="wp-heading-inline">%s</h1>', __('Operations', 'pakkasmarja_management'));

        $table = new OperationReportsTable();
        $table->prepare_items();
        $table->display();

        echo '</div>';
      }

    }
    
  }
  
  add_action('init', function () {
    if (is_admin()) {
      new Menu();
    }
  });

  
    
?>
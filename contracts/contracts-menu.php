<?php
  
  namespace Metatavu\Pakkasmarja\Contracts;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/contracts-table.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\Contracts\Menu' ) ) {
    
    class Menu {

      private $capability = 'pakkasmarja_contracts_view';
            
      public function __construct() {
        add_action( 'admin_menu', function () {
          add_menu_page(__('Contracts', 'pakkasmarja_management'), __('Contracts', 'pakkasmarja_management'), $this->capability, 'contract.php', [ $this, 'renderContractsPage' ], 'dashicons-admin-customizer', 50);
        });
      }
      
      /**
       * Renders contracts table
       */
      public function renderContractsPage() {
        echo '<div class="wrap">';

        $newUrl = "admin.php?page=pakkasmarja-contract-edit-view.php&action=edit&id=NEW";
        echo sprintf('<h1 class="wp-heading-inline">%s <a href="%s" class="page-title-action">%s</a></h1>', __('Contracts', 'pakkasmarja_management'), $newUrl, __('New Contract', 'pakkasmarja_management'));
        
        $table = new ContractsTable();
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
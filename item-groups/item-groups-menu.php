<?php
  
  namespace Metatavu\Pakkasmarja\ItemGroups;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/item-groups-table.php');
  
  if (!class_exists( '\Metatavu\Pakkasmarja\ItemGroups\Menu' ) ) {
    
    class Menu {

      private $capability = 'pakkasmarja_item_groups_view';
            
      public function __construct() {
        add_action( 'admin_menu', function () {
          add_menu_page(__('Item Groups', 'pakkasmarja_management'), __('Item Groups', 'pakkasmarja_management'), $this->capability, 'item-group.php', [ $this, 'renderItemGroupsPage' ], 'dashicons-admin-customizer', 50);
        });
      }
      
      /**
       * Renders item-groups table
       */
      public function renderItemGroupsPage() {
        echo '<div class="wrap">';

        echo sprintf('<h1 class="wp-heading-inline">%s</h1>', __('Item Groups', 'pakkasmarja_management'));

        $table = new ItemGroupsTable();
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
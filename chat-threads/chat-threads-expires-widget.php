<?php
  namespace Metatavu\Pakkasmarja\ChatThreads;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\ChatThreads\ExpiresWidget' ) ) {
    
    /**
     * ExpiresWidget
     */
    class ExpiresWidget {
      
      /**
       * Constructor
       */
      public function __construct() {
        add_action ('add_meta_boxes', [$this, 'addMetaBoxes'], 9999, 2 );
        add_action ('save_post', [$this, 'saveExpires']);
      }
      
      /**
       * Adds predefined texts metabox
       */
      public function addMetaBoxes() {
        $metaboxTitle = __('Expires', 'pakkasmarja_management');
        
      	add_meta_box('chat-thread-expires-meta-box', $metaboxTitle, [$this, 'renderExpiresMetaBox'], 'chat-thread', 'side', 'default');
      }
      
      /**
       * Renders predefined texts metabox
       */
      public function renderExpiresMetaBox($chatThread) {
        global $wp_locale;

        $chatThreadId = $chatThread->ID;
        $expires = get_post_meta($chatThreadId, 'pm-expires', true);
        wp_enqueue_script('chat-threads-expires-widget', plugin_dir_url(__FILE__) . 'chat-threads-expires-widget.js', null, ['jquery-ui-datepicker']);
        
        $dateFormat = get_option('date_format');
        $datepickerDateFormat = \str_replace([ 'd', 'j', 'l', 'z', 'F', 'M', 'n', 'm', 'Y', 'y' ], [ 'dd', 'd', 'DD', 'o', 'MM', 'M', 'm', 'mm', 'yy', 'y' ], $dateFormat );
        $expireDate = !empty($expires) ? new \DateTime($expires) : null;
        $expireDateFormatted = !empty($expires) ? $expireDate->format($dateFormat) : "";

        wp_localize_script('chat-threads-expires-widget', 'locales', [
          'monthNames'        => \array_values( $wp_locale->month ),
          'monthNamesShort'   => \array_values( $wp_locale->month_abbrev ),
          'dayNames'          => \array_values( $wp_locale->weekday ),
          'dayNamesShort'     => \array_values( $wp_locale->weekday_abbrev ),
          'dayNamesMin'       => \array_values( $wp_locale->weekday_initial ),
          'dateFormat'        => $datepickerDateFormat,
          'firstDay'          => get_option('start_of_week'),
          'isRTL'             => $wp_locale->is_rtl(),
        ]);
        

        echo sprintf('<input name="expires" type="hidden" value="%s"/>', empty($expires) ? "" : $expires);
        echo '<div style="width: 100%; position: relative">';
        echo sprintf('<input name="expires-dp" readonly="readonly" style="width:calc(100%% - 20px); " value="%s"/>', $expireDateFormatted);
        echo sprintf('<a class="expires-clear" style="display: inline-block; position: absolute; right: 0px; margin-top: 4px; cursor: pointer;">X</a>');
        echo "</div>";
      }

      /**
       * Saves expires value
       */
      public function saveExpires($chatThreadId) {
        $expires = filter_input(INPUT_POST, 'expires');
        update_post_meta($chatThreadId, 'pm-expires', $expires);      
      }
      
    }
  
  }
  
  add_action('init', function () {
    new ExpiresWidget();
  });
  
?>

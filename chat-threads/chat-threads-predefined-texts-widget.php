<?php
  namespace Metatavu\Pakkasmarja\ChatThreads;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\ChatThreads\PredefinedTextsWidget' ) ) {
    
    /**
     * PredefinedTextsWidget
     */
    class PredefinedTextsWidget {
      
      /**
       * Constructor
       */
      public function __construct() {
        add_action ('add_meta_boxes', [$this, 'addMetaBoxes'], 9999, 2 );
        add_action ('save_post', [$this, 'savePredefinedTexts']);
      }
      
      /**
       * Adds predefined texts metabox
       */
      public function addMetaBoxes() {
        $metaboxTitle = __('Poll answer options', 'pakkasmarja_management');
      	add_meta_box('chat-thread-predefined-texts-meta-box', $metaboxTitle, [$this, 'renderPredefinedTextsMetaBox'], 'chat-thread', 'normal', 'default');
      }
      
      /**
       * Renders predefined texts metabox
       */
      public function renderPredefinedTextsMetaBox($chatThread) {        
        $chatThreadId = $chatThread->ID;

        $allowOther = get_post_meta($chatThreadId, 'pm-poll-allow-other', true) == "true";

        echo "<p>";
        echo sprintf('<input id="poll-Allow-other" name="poll-Allow-other" value="true" type="checkbox" %s/>', $allowOther ? "checked" : "");
        echo sprintf('<label style="vertical-align:top" for="poll-Allow-other">%s</label>', __('Allow other poll answers', 'pakkasmarja_management'));
        echo "</p>";

        wp_enqueue_script('chat-threads-predefined-texts-widget', plugin_dir_url(__FILE__) . 'chat-threads-predefined-texts-widget.js', null, []);
        $texts = get_post_meta($chatThreadId, 'pm-predefined-texts')[0];
        $helpText = __('Enter the poll answer options into the text box below.', 'pakkasmarja_management');
        echo sprintf('<p>%s</p>', $helpText);

        if (empty($texts)) {
          echo '<input name="predefined-texts[]" style="width:100%"/>';
        } else {
          foreach ($texts as $text) {
            echo sprintf('<input name="predefined-texts[]" value="%s" style="width:100%%"/>', $text);
          }
        }

      }

      /**
       * Saves predefined texts value
       */
      public function savePredefinedTexts($chatThreadId) {
        $predefinedTexts = array_filter($_POST['predefined-texts']);
        $allowOther = filter_input(INPUT_POST, 'poll-Allow-other');

        update_post_meta($chatThreadId, 'pm-predefined-texts', $predefinedTexts);      
        update_post_meta($chatThreadId, 'pm-poll-allow-other', $allowOther);      
      }
      
    }
  
  }
  
  add_action('init', function () {
    new PredefinedTextsWidget();
  });
  
?>
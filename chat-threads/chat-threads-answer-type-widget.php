<?php
  namespace Metatavu\Pakkasmarja\ChatThreads;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\ChatThreads\AnswerTypeWidget' ) ) {
    
    /**
     * AnswerTypeWidget
     */
    class AnswerTypeWidget {
      
      /**
       * Constructor
       */
      public function __construct() {
        add_action ('add_meta_boxes', [$this, 'addMetaBoxes'], 9999, 2 );
        add_action ('save_post', [$this, 'saveAnswerType']);
      }
      
      /**
       * Adds answer type metabox
       */
      public function addMetaBoxes() {
        $metaboxTitle = __('Answer Type', 'pakkasmarja_management');
      	add_meta_box('chat-thread-answer-type-meta-box', $metaboxTitle, [$this, 'renderAnswerTypeMetaBox'], 'chat-thread', 'side', 'default');
      }
      
      /**
       * Renders answer type metabox
       */
      public function renderAnswerTypeMetaBox($chatThread) {
        $chatThreadId = $chatThread->ID;
        $answerType = get_post_meta($chatThreadId, 'pm-answer-type', true);
        echo sprintf('<select style="width:100%%" name="answer-type">');
        echo sprintf('<option value="TEXT">%s</option>', __('Text', 'pakkasmarja_management'));
        echo sprintf('<option value="POLL"%s>%s</option>', $answerType == "POLL" ? "selected" : "", __('Poll', 'pakkasmarja_management'));
        echo sprintf('</select>');
      }

      /**
       * Saves predefined texts value
       */
      public function saveAnswerType($chatThreadId) {
        $answerType = filter_input(INPUT_POST, 'answer-type');
        update_post_meta($chatThreadId, 'pm-answer-type', $answerType);      
      }
      
    }
  
  }
  
  add_action('init', function () {
    new AnswerTypeWidget();
  });
  
?>
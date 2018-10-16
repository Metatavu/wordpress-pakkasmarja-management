<?php
  namespace Metatavu\Pakkasmarja\ChatThreads;
  
  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );

  require_once( __DIR__ . '/../api/api-client.php');

  if (!class_exists( '\Metatavu\Pakkasmarja\ChatThreads\Type' ) ) {
  
    /**
     * Custom post type for exports 
     */
    class Type {
      
      /**
       * Constructor
       */
      public function __construct() {
        $this->registerType();
        add_action('admin_init',[$this, "adminInit"]);
        add_filter('post_row_actions', [$this, "postRowActionsFilter"], 10, 2);
      }

      /**
       * Admin init action
       */
      public function adminInit() {
        if (isset($_REQUEST['action']) && 'summary-report' == $_REQUEST['action']) {
          $chatThreadsApi = \Metatavu\Pakkasmarja\Api\ApiClient::getChatThreadsApi();
          $originId = intval(sanitize_text_field($_REQUEST['post']));
          $chatThread = $chatThreadsApi->listChatThreads($originId)[0];
          
          if ($chatThread) {
            $response = $chatThreadsApi->getChatThreadReportXLSX($chatThread->getId(), "summaryReport");
            $body = $response->getBody();
            $contentType = $response->getHeader('Content-Type')[0];
            $contentDisposition = $response->getHeader('Content-Disposition')[0];  
            header(sprintf("Content-type: %s", $contentType));
            header(sprintf("Content-Disposition: %s", $contentDisposition));
            echo $body; 
          }

          exit;
        }
      }
      
      /**
       * Registers a custom type
       */
      public function registerType() {
        register_post_type('chat-thread', [
          'labels' => [
            'name'               => __( 'Chat Threads', 'pakkasmarja_management'),
            'singular_name'      => __( 'Chat Thread', 'pakkasmarja_management'),
            'add_new'            => __( 'Add Chat Thread', 'pakkasmarja_management'),
            'add_new_item'       => __( 'Add Chat Thread', 'pakkasmarja_management'),
            'edit_item'          => __( 'Edit Chat Thread', 'pakkasmarja_management'),
            'new_item'           => __( 'New Chat Thread', 'pakkasmarja_management'),
            'view_item'          => __( 'View Chat Thread', 'pakkasmarja_management'),
            'search_items'       => __( 'Search Chat Threads', 'pakkasmarja_management'),
            'not_found'          => __( 'No Chat Threads found', 'pakkasmarja_management'),
            'not_found_in_trash' => __( 'No Chat Threads in trash', 'pakkasmarja_management'),
            'menu_name'          => __( 'Chat Threads', 'pakkasmarja_management'),
            'all_items'          => __( 'Chat Threads', 'pakkasmarja_management')
          ],
          'menu_icon' => 'dashicons-testimonial',
          'public' => true,
          'has_archive' => true,
          'show_in_rest' => true,
          'supports' => [
            'title',
            'editor',
            'thumbnail'
            ]
        ]);
      }

      /**
       * Registers extra actions into chat thread post type
       * 
       * @param {Array} $actions actions
       * @param {\WP_Post} $post post
       */
      public function postRowActionsFilter($actions, $post) {
        if ($post->post_type == "chat-thread") {
          if (get_post_meta($post->ID, 'pm-answer-type', true) === "POLL") {
            $url = add_query_arg(['post' => $post->ID, 'action' => 'summary-report']);
            $summaryReportLink = add_query_arg(['action' => 'summary-report'], $url);
            $actions["summary-report"] = sprintf('<a href="%1$s">%2$s</a>', $summaryReportLink, esc_html(__( 'Summary Report', 'pakkasmarja_management')));
          }
        }

        return $actions;
      }

    }
  }

  add_action ('init', function () {
    new Type();
  });

?>
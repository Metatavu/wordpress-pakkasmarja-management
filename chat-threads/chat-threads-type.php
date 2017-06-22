<?php
  namespace Metatavu\Pakkasmarja\ChatThreads;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  add_action ('init', function () {
    register_post_type ( 'chat-thread', array (
      'labels' => array (
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
      ),
      'menu_icon' => 'dashicons-testimonial',
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true,
      'supports' => array (
        'title',
        'editor',
        'thumbnail'
      )
    ));
  });
  
?>
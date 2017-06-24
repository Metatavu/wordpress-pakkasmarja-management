<?php
  namespace Metatavu\Pakkasmarja\QuestionGroups;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  add_action ('init', function () {
    register_post_type ( 'question-group', array (
      'labels' => array (
        'name'               => __( 'Question Groups', 'pakkasmarja_management'),
        'singular_name'      => __( 'Question Group', 'pakkasmarja_management'),
        'add_new'            => __( 'Add Question Group', 'pakkasmarja_management'),
        'add_new_item'       => __( 'Add Question Group', 'pakkasmarja_management'),
        'edit_item'          => __( 'Edit Question Group', 'pakkasmarja_management'),
        'new_item'           => __( 'New Question Group', 'pakkasmarja_management'),
        'view_item'          => __( 'View Question Group', 'pakkasmarja_management'),
        'search_items'       => __( 'Search Question Groups', 'pakkasmarja_management'),
        'not_found'          => __( 'No Question Groups found', 'pakkasmarja_management'),
        'not_found_in_trash' => __( 'No Question Groups in trash', 'pakkasmarja_management'),
        'menu_name'          => __( 'Question Groups', 'pakkasmarja_management'),
        'all_items'          => __( 'Question Groups', 'pakkasmarja_management')
      ),
      'menu_icon' => 'dashicons-phone',
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
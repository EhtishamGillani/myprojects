<?php
/*
Plugin Name: My Projects Plugin
Description: Creates a custom post type called Projects and displays them on a website using shortcodes.
Version: 1.0
Author: project
*/

// Register the custom post type
function my_projects_plugin_register_post_type() {
  register_post_type( 'projects', array(
    'labels' => array(
      'name' => 'Projects',
      'singular_name' => 'Project',
    ),
    'public' => true,
    'has_archive' => true,
    'supports' => array( 'title', 'editor', 'thumbnail', 'taxonomy' ),
    'taxonomies' => array( 'project_categories' ),
  ) );
}
add_action( 'init', 'my_projects_plugin_register_post_type' );

// Register the custom taxonomy
function my_projects_plugin_register_taxonomy() {
  register_taxonomy( 'project_categories', array( 'projects' ), array(
    'labels' => array(
      'name' => 'Project Categories',
      'singular_name' => 'Project Category',
    ),
    'hierarchical' => true,
  ) );
}
add_action( 'init', 'my_projects_plugin_register_taxonomy' );

// Create a shortcode to display a list of all projects
function my_projects_plugin_shortcode() {
  $args = array(
    'post_type' => 'projects',
    'posts_per_page' => -1,
  );

  $query = new WP_Query( $args );

  if ( $query->have_posts() ) {
    $output = '<ul>';

    while ( $query->have_posts() ) {
      $query->the_post();

      $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
    }

    wp_reset_postdata();

    $output .= '</ul>';

    return $output;
  } else {
    return '<p>No projects found.</p>';
  }
}
add_shortcode( 'my_projects', 'my_projects_plugin_shortcode' );


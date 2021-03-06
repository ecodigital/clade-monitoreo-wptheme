<?php

/*
 * Required plugins
 */
require_once(TEMPLATEPATH . '/inc/class-tgm-plugin-activation.php');
function clade_register_required_plugins() {
  $plugins = array();
  if(defined('ACF_PRO_KEY')) {
    $plugins[] = array(
      'name' => 'Advanced Custom Fields PRO',
      'slug' => 'advanced-custom-fields-pro',
      'required' => true,
      'force_activation' => true,
      'source' => 'https://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=' . ACF_PRO_KEY
    );
    $plugins[] = array(
      'name' => 'ACF: Advanced Taxonomy Selector',
      'slug' => 'acf-advanced-taxonomy-selector',
      'required' => true,
      'force_activation' => true
    );
    $plugins[] = array(
      'name' => 'Advanced Custom Fields: Tag It Field',
      'slug' => 'advanced-custom-fields-tag-it',
      'required' => true,
      'force_activation' => true
    );
    $plugins[] = array(
      'name' => 'Advanced Custom Fields: Font Awesome',
      'slug' => 'advanced-custom-fields-font-awesome',
      'required' => true,
      'force_activation' => true
    );
  }
  $options = array(
    'default_path'  => '',
    'menu'      => 'clade-install-plugins',
    'has_notices'  => true,
    'dismissable'  => true,
    'dismiss_msg'  => '',
    'is_automatic'  => false,
    'message'    => ''
  );
  tgmpa($plugins, $options);
}
add_action('tgmpa_register', 'clade_register_required_plugins');

function clade_setup_theme() {

  load_theme_textdomain('clade', get_template_directory() . '/languages');

  add_theme_support( 'custom-header', array(
    'width' => 1066,
    'height' => 600
  ) );
  add_theme_support( 'post-thumbnails' );

  // add_image_size('wide-thumbnail', 400, 225, true);
  // add_image_size('highlight', 860, 392, true);

  register_nav_menus(array(
    'header_nav' => __('Header navigation', 'clade'),
    'footer_nav' => __('Footer navigation', 'clade')
  ));

}
add_action('after_setup_theme', 'clade_setup_theme');

function clade_widgets_init() {

  register_sidebar(array(
    'name' => __('Footer widgets', 'clade'),
    'id' => 'footer_widgets',
    'before_widget' => '<li class="widget">',
    'after_widget' => '</li>',
    'before_title' => '<h2>',
    'after_title' => '</h2>'
  ));

}
add_action('widgets_init', 'clade_widgets_init');

function clade_header_scripts() {

  wp_register_style('webfonts', 'https://fonts.googleapis.com/css?family=Codystar|Ubuntu:300,400,400i,500,700');
  wp_register_style('normalize', get_template_directory_uri() . '/assets/skeleton/css/normalize.css');
  wp_register_style('skeleton', get_template_directory_uri() . '/assets/skeleton/css/skeleton.css');
  wp_register_style('fontawesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');
  wp_register_style('main', get_template_directory_uri() . '/css/main.css', array('webfonts', 'normalize', 'skeleton', 'fontawesome'), '0.0.10');
  wp_register_style('responsive', get_template_directory_uri() . '/css/responsive.css', array('main'), '0.0.2');

  wp_enqueue_style('main');
  wp_enqueue_style('responsive');

  wp_register_script('highcharts', get_template_directory_uri() . '/assets/highcharts/highcharts.js', array('jquery'));
  wp_register_script('highcharts-more', get_template_directory_uri() . '/assets/highcharts/highcharts-more.js', array('highcharts'));
  wp_register_script('highcharts.data', get_template_directory_uri() . '/assets/highcharts/modules/data.js', array('highcharts'));
  wp_register_script('highcharts.export', get_template_directory_uri() . '/assets/highcharts/modules/exporting.js', array('highcharts'));
  wp_register_script('fitvids', get_template_directory_uri() . '/assets/jquery.fitvids/jquery.fitvids.js', array('jquery'));

  wp_register_script('chart', get_template_directory_uri() . '/js/chart.js', array('jquery', 'highcharts', 'highcharts.data', 'highcharts.export'), '0.0.8');

  wp_enqueue_script('chart');


}
add_action('wp_enqueue_scripts', 'clade_header_scripts');

function clade_footer_scripts() {

  wp_register_script('site', get_template_directory_uri() . '/js/site.js', array('jquery', 'fitvids'), '0.0.1');

  wp_register_script('theme', get_template_directory_uri() . '/js/theme.js', array('jquery'), '0.0.5');
  wp_register_script('table', get_template_directory_uri() . '/js/table.js', array('jquery'), '0.0.2');

  wp_enqueue_script('site');

  wp_enqueue_script('theme');
  wp_enqueue_script('table');

}
add_action('wp_footer', 'clade_footer_scripts');

/**
 * Include features
 */
require_once(TEMPLATEPATH . '/inc/data-collections.php');
require_once(TEMPLATEPATH . '/inc/themes.php');
require_once(TEMPLATEPATH . '/inc/countries.php');
require_once(TEMPLATEPATH . '/inc/theme-query.php');
require_once(TEMPLATEPATH . '/inc/field-groups.php');

/**
 * Custm mime types
 */
function clade_mime_types($types) {
  $types['csv'] = 'text/csv';
  return $types;
}
add_filter('upload_mimes', 'clade_mime_types');


/**
 * Get first paragraph from a WordPress post. Use inside the Loop.
 *
 * @return string
 */
function get_first_paragraph() {
  global $post;

  $str = apply_filters( 'the_content', get_the_content() );
  $str = substr( $str, 0, strpos( $str, '</p>' ) + 4 );
  $str = strip_tags($str, '<a><strong><em>');
  return '<p>' . $str . '</p>';
}

/**
 * Get WordPress post content without the first paragraph. Use inside the Loop.
 *
 * @return string
 */
function get_content_without_first_paragraph() {
  global $post;
  $content = apply_filters('the_content', $post->post_content);
  return str_replace(get_first_paragraph(), '', $content);
}

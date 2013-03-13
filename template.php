<?php
/**
 * @file
 * OpenASU Bootstrap's primary theme functions and alterations.
 */

/**
 * Load Kalatheme dependencies.
 *
 * Implements template_preprocess_html().
 */
function openasu_bootstrap_preprocess_html(&$variables) {
  // Set the header color
  if (module_exists('asu_brand')) {
    drupal_add_css(drupal_get_path('theme', 'openasu_bootstrap') . '/css/header/' .
      variable_get('asu_brand_header_template', ASU_BRAND_HEADER_TEMPLATE_DEFAULT) .  '.css');
  }
  // Load student CSS if this is a student template
  if (variable_get('asu_brand_is_student', 'default') == 'student') {
    drupal_add_css(drupal_get_path('theme', 'openasu_bootstrap') . '/css/student/' .
      variable_get('asu_brand_is_student', 'default') .  '.css', array(
      'group' => CSS_THEME,
      'media' => 'screen',
      'weight' => '100',
      )
    );
    // Load menu CSS for student header
    if (variable_get('asu_brand_student_color', 'black') != 'black') {
      drupal_add_css(drupal_get_path('theme', 'openasu_bootstrap') . '/css/student/menu/' .
        variable_get('asu_brand_student_color', 'black') .  '.css', array(
        'group' => CSS_THEME,
        'media' => 'screen',
        'weight' => '200',
        )
      );
    }
  }
}

/**
 * Implements hook_ctools_plugin_post_alter()
 */
function openasu_bootstrap_ctools_plugin_post_alter(&$plugin, &$info) {
  if ($info['type'] == 'styles') {
    if ($plugin['name'] == 'kalacustomize') {
      $plugin['title'] = 'ASU Customize';
    }
  }
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function openasu_bootstrap_form_panels_edit_style_settings_form_alter(&$form, &$form_state) {
  // Add some extra ASU styles if extra styles are on
  if (isset($form['general_settings']['settings']['title'])) {
    $styles = array('title', 'content');
    foreach ($styles as $style) {
      $form['general_settings']['settings'][$style]['attributes']['#options'] += array(
        'featured-text' => 'ASU FEATURED TEXT',
      );
    }
  }
}

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
 * Override or insert variables into the page template.
 *
 * Implements template_process_page().
 */
function openasu_bootstrap_preprocess_page(&$variables) {
  $variables['asu_picture'] = '';
  if (theme_get_setting('default_picture', 'openasu_bootstrap')) {
    $variables['asu_picture'] = theme('image_style', array(
      'style_name' => 'panopoly_image_full',
      'path' => theme_get_setting('picture_path', 'openasu_bootstrap'),
    )
    );
  }
}

/**
 * Override or insert variables into the page template.
 *
 * Implements template_process_page().
 */
function openasu_bootstrap_preprocess_block(&$variables) {
  $block = $variables['block'];
  if ($block->delta == 'main-menu' && $block->module == 'system' && $block->status == 1 && $block->theme = 'openasu_bootstrap') {
    // Get the entire main menu tree.
    $main_menu_tree = array();
    $main_menu_tree = menu_tree_all_data('main-menu', NULL, 2);
    // Add the rendered output to the $main_menu_expanded variable.
    $main_menu_asu = menu_tree_output($main_menu_tree);
    $variables['content'] = theme('links__system_main_menu', array(
      'links' => $main_menu_asu,
      'attributes' => array(
        'class' => array('nav pull-left'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      ),));
      $block->subject = '';
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

 'content');
    foreach ($styles as $style) {
      $form['general_settings']['settings'][$style]['attributes']['#options'] += array(
        'featured-text' => 'ASU FEATURED TEXT',
      );
    }
  }
}


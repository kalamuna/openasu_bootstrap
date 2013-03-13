<?php

/**
 * @file
 * Theme setting callbacks for open_asu.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 */
function openasu_bootstrap_form_system_theme_settings_alter(&$form, &$form_state) {
  // Build the config form
  $form['theme_configuration'] = array(
    '#title' => t('OpenASU Theme Settings'),
    '#type' => 'fieldset',
  );

  $form['theme_configuration']['asu_brand_header_template'] = array(
    '#title' => t('Color Scheme'),
    '#type' => 'radios',
    '#options' => array(
      'default' => t('Gold'),
      'default_maroon' => t('Maroon'),
      'default_white' => t('White'),
    ),
    '#default_value' => variable_get('asu_brand_header_template', ASU_BRAND_HEADER_TEMPLATE_DEFAULT),
  );

  $form['theme_configuration']['asu_brand_is_student'] = array(
    '#title' => t('Footer Type'),
    '#type' => 'select',
    '#options' => array(
      'default' => t('Default Footer'),
      'student' => t('Student Footer'),
    ),
    '#default_value' => variable_get('asu_brand_is_student', 'student'),
    '#access' => FALSE,
  );

  $form['theme_configuration']['asu_brand_student_color'] = array(
    '#title' => t('Menu Color'),
    '#type' => 'radios',
    /*'#states' => array(
     'visible' => array(
       ':input[name="asu_brand_is_student"]' => array('value' => 'student'),
     ),
    ),*/
    '#options' => array(
      'black' => t('Black'),
      'gold' => t('Gold'),
      'grey' => t('Grey'),
    ),
    '#default_value' => variable_get('asu_brand_student_color', 'black'),
  );

  // Picture settings
  $form['theme_configuration']['picture'] = array(
    '#type' => 'fieldset',
    '#title' => t('Featured Image'),
    '#description' => t('If toggled on, the following image will be displayed.'),
    '#attributes' => array('class' => array('theme-settings-bottom')),
  );
  $form['theme_configuration']['picture']['default_picture'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use the default image'),
    '#default_value' => theme_get_setting('default_picture'),
    '#tree' => FALSE,
    '#description' => t('Check here if you want the theme to use the image supplied with it.')
  );
  $form['theme_configuration']['picture']['settings'] = array(
    '#type' => 'container',
    '#states' => array(
      // Hide the logo settings when using the default logo.
      'invisible' => array(
        'input[name="default_picture"]' => array('checked' => TRUE),
      ),
    ),
  );
  $form['theme_configuration']['picture']['settings']['picture_path'] = array(
    '#type' => 'textfield',
    '#title' => t('Path to custom image'),
    '#description' => t('The path to the file you would like to use as your image file instead of the default image.'),
    '#default_value' => theme_get_setting('picture_path'),
  );
  $form['theme_configuration']['picture']['settings']['picture_upload'] = array(
    '#type' => 'file',
    '#title' => t('Upload logo image'),
    '#maxlength' => 40,
    '#description' => t("If you don't have direct file access to the server, use this field to upload your logo.")
  );

  $form['#submit'][] = 'openasu_bootstrap_settings_submit';
}

function openasu_bootstrap_settings_submit($form, &$form_state) {
  // Set the variables, need to use this instead of theme_get_settings
  // because the scop of the vars is more global.
  variable_set('asu_brand_header_template', $form_state['values']['asu_brand_header_template']);
  variable_set('asu_brand_is_student', $form_state['values']['asu_brand_is_student']);
  variable_set('asu_brand_student_color', $form_state['values']['asu_brand_student_color']);

  // ASU header needs a cache_clear
  if (module_exists('asu_brand')) {
    asu_brand_cache_clear();
  }
}

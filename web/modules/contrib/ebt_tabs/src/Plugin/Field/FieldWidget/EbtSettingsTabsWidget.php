<?php

namespace Drupal\ebt_tabs\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ebt_core\Plugin\Field\FieldWidget\EbtSettingsDefaultWidget;

/**
 * Plugin implementation of the 'ebt_settings_tabs' widget.
 *
 * @FieldWidget(
 *   id = "ebt_settings_tabs",
 *   label = @Translation("EBT Tabs settings"),
 *   field_types = {
 *     "ebt_settings"
 *   }
 * )
 */
class EbtSettingsTabsWidget extends EbtSettingsDefaultWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['ebt_settings']['pass_options_to_javascript'] = [
      '#type' => 'hidden',
      '#value' => TRUE,
    ];

    $element['ebt_settings']['styles'] = [
      '#title' => $this->t('Styles'),
      '#type' => 'radios',
      '#options' => [
        'default' => $this->t('Default'),
        'without_header_background' => $this->t('Without header background'),
        'minimalist_tabs' => $this->t('Minimalist tabs'),
        'tabs_like_buttons' => $this->t('Tabs like buttons'),
        'vertical_tabs' => $this->t('Vertical tabs'),
        'vertical_tabs_rotated' => $this->t('Vertical tabs rotated'),
      ],
      '#default_value' => $items[$delta]->ebt_settings['styles'] ?? 'default',
    ];

    // Get the path of image helper.
    $imageHelpPath = '/' . \Drupal::service('extension.path.resolver')->getPath('module', 'ebt_tabs') . '/images/help/';

    // Define the field help text.
    $description = $this->t('Select predefined styles for tabs. You can see some examples below:');
    $description .= '<ul>';
    $description .= '<li>' . $this->t('<a href=":default_example">Default</a>', [':default_example' => $imageHelpPath . '/default.png']) . '</li>';
    $description .= '<li>' . $this->t('<a href=":without_header_background_example">Without header background</a>', [':without_header_background_example' => $imageHelpPath . '/without-header-background.png']) . '</li>';
    $description .= '<li>' . $this->t('<a href=":minimalist_tabs_example">Minimalist tabs</a>', [':minimalist_tabs_example' => $imageHelpPath . '/minimalist-tabs.png']) . '</li>';
    $description .= '<li>' . $this->t('<a href=":tabs_like_buttons_example">Plus/Minus icons on the left</a>', [':tabs_like_buttons_example' => $imageHelpPath . '/tabs-like-buttons.png']) . '</li>';
    $description .= '<li>' . $this->t('<a href=":vertical_tabs_example">Vertical tabs</a>', [':vertical_tabs_example' => $imageHelpPath . '/vertical-tabs.png']) . '</li>';
    $description .= '<li>' . $this->t('<a href=":vertical_tabs_rotated_example">Vertical tabs rotated</a>', [':vertical_tabs_rotated_example' => $imageHelpPath . '/vertical-tabs-rotated.png']) . '</li>';
    $description .= '<ul>';

    // Set the help text in the field description.
    $element['ebt_settings']['styles']['#description'] = $description;

    $element['ebt_settings']['active'] = [
      '#title' => $this->t('Active section'),
      '#type' => 'number',
      '#default_value' => $items[$delta]->ebt_settings['active'] ?? NULL,
      '#description' => $this->t('The zero-based index of the panel that is active (open). A negative value selects panels going backward from the last panel.'),
    ];

    $element['ebt_settings']['collapsible'] = [
      '#title' => $this->t('Collapsible'),
      '#type' => 'checkbox',
      '#default_value' => $items[$delta]->ebt_settings['collapsible'] ?? NULL,
      '#description' => $this->t('Whether all the sections can be closed at once. Allows collapsing the active section.'),
    ];

    $element['ebt_settings']['closed'] = [
      '#title' => $this->t('All closed'),
      '#type' => 'checkbox',
      '#default_value' => $items[$delta]->ebt_settings['closed'] ?? NULL,
      '#description' => $this->t('Collapses all panels'),
    ];

    $element['ebt_settings']['disable'] = [
      '#title' => $this->t('Disable'),
      '#type' => 'checkbox',
      '#default_value' => $items[$delta]->ebt_settings['disable'] ?? NULL,
      '#description' => $this->t('Disables the tabs.'),
    ];

    $element['ebt_settings']['heightStyle'] = [
      '#title' => $this->t('Height style'),
      '#type' => 'radios',
      '#options' => [
        'auto' => $this->t('Auto'),
        'fill' => $this->t('Fill'),
        'content' => $this->t('Content'),
      ],
      '#default_value' => $items[$delta]->ebt_settings['heightStyle'] ?? 'content',
      '#description' => $this->t('Controls the height of the accordion and each panel.'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      $value += ['ebt_settings' => []];
    }
    return $values;
  }

}

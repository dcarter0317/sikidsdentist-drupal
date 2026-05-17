<?php

namespace Drupal\ept_tiles\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\ept_core\Plugin\Field\FieldWidget\EptSettingsDefaultWidget;

/**
 * Plugin implementation of the 'ept_settings_stats' widget.
 *
 * @FieldWidget(
 *   id = "ept_settings_tiles",
 *   label = @Translation("EPT Tiles settings"),
 *   field_types = {
 *     "ept_settings"
 *   }
 * )
 */
class EptSettingsTilesWidget extends EptSettingsDefaultWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $element['ept_settings']['styles'] = [
      '#title' => $this->t('Styles'),
      '#type' => 'radios',
      '#options' => [
        'one_column' => $this->t('One column'),
        'two_columns' => $this->t('Two columns'),
        'three_columns' => $this->t('Three columns'),
        'four_columns' => $this->t('Four columns'),
      ],
      '#default_value' => $items[$delta]->ept_settings['styles'] ?? 'three_columns',
    ];

    $element['ept_settings']['links'] = [
      '#type' => 'details',
      '#title' => $this->t('Links'),
      '#open' => TRUE,
    ];

    $element['ept_settings']['links']['link_in_a_new_tab'] = [
      '#title' => $this->t('Open links in a new tab'),
      '#type' => 'checkbox',
      '#default_value' => $items[$delta]->ept_settings['links']['link_in_a_new_tab'] ?? FALSE,
    ];

    $element['ept_settings']['links']['add_nofollow'] = [
      '#title' => $this->t('Add "nofollow" option to the link'),
      '#type' => 'checkbox',
      '#default_value' => $items[$delta]->ept_settings['links']['add_nofollow'] ?? NULL,
      '#description' => $this->t('The nofollow attribute is an HTML attribute in the link tag to tell search engines not to follow the link when crawling the web page'),
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      $value += ['ept_settings' => []];
    }
    return $values;
  }

}

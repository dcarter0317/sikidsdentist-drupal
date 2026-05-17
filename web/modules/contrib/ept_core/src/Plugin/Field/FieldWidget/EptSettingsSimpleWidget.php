<?php

namespace Drupal\ept_core\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'ept_settings_simple' widget.
 *
 * @FieldWidget(
 *   id = "ept_settings_simple",
 *   label = @Translation("EPT Simple settings"),
 *   field_types = {
 *     "ept_settings"
 *   }
 * )
 */
class EptSettingsSimpleWidget extends EptSettingsDefaultWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    unset($element['ept_settings']['design_options']['box1']);
    unset($element['ept_settings']['design_options']['other_settings']['border_color']);
    unset($element['ept_settings']['design_options']['other_settings']['border_style']);
    unset($element['ept_settings']['design_options']['other_settings']['border_radius']);
    unset($element['ept_settings']['design_options']['other_settings']['background_color']);
    unset($element['ept_settings']['design_options']['other_settings']['background_media']);
    unset($element['ept_settings']['design_options']['other_settings']['background_image_style']);
    unset($element['ept_settings']['design_options']['other_settings']['background_video_settings']);

    $element['ept_settings']['design_options']['#open'] = TRUE;
    $element['ept_settings']['design_options']['other_settings']['spacing'] = [
      '#type' => 'select',
      '#title' => $this->t('Spacing'),
      '#options' => [
        'spacing-none' => $this->t('None'),
        'spacing-sm' => $this->t('Small'),
        'spacing-md' => $this->t('Medium'),
        'spacing-lg' => $this->t('Large'),
        'spacing-xl' => $this->t('Extra Large'),
        'spacing-xxl' => $this->t('Double Extra Large'),
      ],
      '#default_value' => $items[$delta]->ept_settings['design_options']['other_settings']['spacing'] ?? 'spacing-none',
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

<?php

namespace Drupal\ept_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'ept_settings_default' formatter.
 *
 * @FieldFormatter(
 *   id = "ept_settings_default",
 *   label = @Translation("EPT paragraph settings default"),
 *   field_types = {
 *     "ept_settings"
 *   }
 * )
 */
class EptSettingsDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'ept_settings_default',
        '#ept_settings' => $item->ept_settings,
      ];
    }

    return $elements;
  }

}

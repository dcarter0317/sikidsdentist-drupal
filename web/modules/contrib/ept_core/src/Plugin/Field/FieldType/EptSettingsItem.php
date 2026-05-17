<?php

namespace Drupal\ept_core\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\MapDataDefinition;

/**
 * Plugin implementation of the 'settings' field type.
 *
 * @FieldType(
 *   id = "ept_settings",
 *   label = @Translation("EPT Settings"),
 *   description = @Translation("This field stores EPT paragraph settings in the database."),
 *   default_widget = "ept_settings_default",
 *   default_formatter = "ept_settings_default"
 * )
 */
class EptSettingsItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field) {
    return [
      'columns' => [
        'ept_settings' => [
          'description' => 'Serialized paragraph settings data',
          'type' => 'blob',
          'serialize' => TRUE,
          'size' => 'big',
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('ept_settings')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['ept_settings'] = MapDataDefinition::create()
      ->setLabel(t('EPT settings'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    // A map item has no main property.
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function setValue($values, $notify = TRUE) {
    if (isset($values)) {
      $values += [
        'ept_settings' => [],
      ];
    }

    parent::setValue($values, $notify);
  }

}

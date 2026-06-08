<?php

declare(strict_types=1);

namespace Drupal\ckeditor5_custom_paste\Plugin\CKEditor5Plugin;

use Drupal\ckeditor5\Plugin\CKEditor5PluginConfigurableInterface;
use Drupal\ckeditor5\Plugin\CKEditor5PluginConfigurableTrait;
use Drupal\ckeditor5\Plugin\CKEditor5PluginDefault;
use Drupal\ckeditor5\Plugin\CKEditor5PluginElementsSubsetInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\EditorInterface;

/**
 * CKEditor 5 Custom PasteFilter plugin.
 */
class PasteFilter extends CKEditor5PluginDefault implements CKEditor5PluginConfigurableInterface, CKEditor5PluginElementsSubsetInterface {

  use CKEditor5PluginConfigurableTrait;

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'enabled' => FALSE,
      'excluded_tags' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getElementsSubset(): array {
    return ['<p>'];
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration): void {
    if (empty($this->configuration)) {
      $this->configuration = $this->defaultConfiguration();
    }
    else {
      $this->configuration = $configuration;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable CKEditor5 custom paste'),
      '#default_value' => (bool) $this->configuration['enabled'] ?? FALSE,
    ];
    $form['excluded_tags'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Excluded tags'),
      '#description' => $this->t('Enter a comma-separated list of HTML tag names that should be preserved when pasting content into CKEditor 5. Tags listed here will maintain their original structure without style transformations. For example: "table, tr, td".'),
      '#default_value' => $this->configuration['excluded_tags'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration = [
      'enabled' => (bool) $form_state->getValue('enabled'),
      'excluded_tags' => $form_state->getValue('excluded_tags'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getDynamicPluginConfig(array $static_plugin_config, EditorInterface $editor): array {
    // Return false if the plugin is not enabled, or there are no filters
    // configured.
    if (!empty($this->configuration['excluded_tags'])) {
      $excluded_tags = explode(',', $this->configuration['excluded_tags']);
    }
    return [
      'pastefilter' => [
        'enabled' => $this->configuration['enabled'],
        'excluded_tags' => $excluded_tags ?? FALSE,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state) {
    // Ensure 'enabled' is a boolean.
    $form_state->setValue('enabled', (bool) $form_state->getValue('enabled'));

    // Validate 'excluded_tags' to
    // Ensure it contains valid tag names separated by commas.
    $excludedTagsInput = $form_state->getValue('excluded_tags');
    $excludedTags = array_filter(array_map('trim', explode(',', $excludedTagsInput)), function ($tag) {
      // Validate each tag to ensure it's a simple HTML tag name.
      return preg_match('/^[a-zA-Z0-9-]+$/', $tag);
    });
    $form_state->setValue('excluded_tags', implode(',', $excludedTags));
  }

}

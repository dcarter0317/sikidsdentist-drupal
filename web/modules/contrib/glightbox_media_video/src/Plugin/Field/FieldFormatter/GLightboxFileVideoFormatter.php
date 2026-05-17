<?php

namespace Drupal\glightbox_media_video\Plugin\Field\FieldFormatter;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Drupal\file\Plugin\Field\FieldFormatter\FileMediaFormatterBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'file_video' formatter.
 *
 * @FieldFormatter(
 *   id = "glightbox_file_video",
 *   label = @Translation("GLightbox Video Popup"),
 *   description = @Translation("Display thumbnail and opens video in GLightbox popup."),
 *   field_types = {
 *     "file"
 *   }
 * )
 */
class GLightboxFileVideoFormatter extends FileMediaFormatterBase {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The image style entity storage.
   *
   * @var \Drupal\image\ImageStyleStorageInterface
   */
  protected $imageStyleStorage;

  /**
   * The field formatter plugin instance for videos.
   *
   * @var \Drupal\Core\Field\FormatterInterface
   */
  protected $videoFormatter;

  /**
   * Allow us to attach glightbox settings to our element.
   *
   * @var \Drupal\glightbox\ElementAttachmentInterface
   */
  protected $glightboxAttachment;

  /**
   * The entity field manager.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * Constructs a new instance of the plugin.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Third party settings.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Entity\EntityStorageInterface $image_style_storage
   *   The image style storage.
   * @param \Drupal\Core\Field\FormatterInterface $video_formatter
   *   The field formatter for videos.
   * @param \Drupal\glightbox\ElementAttachmentInterface|null $glightbox_attachment
   *   The glightbox attachment if glightbox is enabled.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, AccountInterface $current_user,  EntityStorageInterface $image_style_storage, FormatterInterface $video_formatter, $glightbox_attachment, EntityFieldManagerInterface $entity_field_manager) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->glightboxAttachment = $glightbox_attachment;
    $this->currentUser = $current_user;
    $this->imageStyleStorage = $image_style_storage;
    $this->videoFormatter = $video_formatter;
    $this->entityFieldManager = $entity_field_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $formatter_manager = $container->get('plugin.manager.field.formatter');
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('current_user'),
      $container->get('entity_type.manager')->getStorage('image_style'),
      $formatter_manager->createInstance('oembed', $configuration),
      $container->get('glightbox.attachment'),
      $container->get('entity_field.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function getMediaType() {
    return 'video';
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'muted' => FALSE,
      'width' => 640,
      'height' => 480,
      'display' => 'thumbnail',
      'link_text' => 'View Video',
      'image_style' => 'thumbnail',
      'glightbox_gallery' => 'post',
      'glightbox_gallery_custom' => '',
      'glightbox_caption' => 'auto',
      'glightbox_caption_custom' => '',
      'thumbnail_source_field' => '',
      'thumbnail_source_image_style' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element = parent::settingsForm($form, $form_state);

    $element['muted'] = [
      '#title' => $this->t('Muted'),
      '#type' => 'checkbox',
      '#default_value' => $this->getSetting('muted'),
    ];
    $element['width'] = [
      '#type' => 'number',
      '#title' => $this->t('Width'),
      '#default_value' => $this->getSetting('width'),
      '#size' => 5,
      '#maxlength' => 5,
      '#field_suffix' => $this->t('pixels'),
      '#min' => 0,
      '#required' => TRUE,
    ];
    $element['height'] = [
      '#type' => 'number',
      '#title' => $this->t('Height'),
      '#default_value' => $this->getSetting('height'),
      '#size' => 5,
      '#maxlength' => 5,
      '#field_suffix' => $this->t('pixels'),
      '#min' => 0,
      '#required' => TRUE,
    ];

    // Build the thumbnail source field options by inspecting the fields on the
    // target entity type / bundle (e.g. media:video).
    $thumbnail_field_options = ['' => $this->t('- Default (auto thumbnail / icon) -')];
    $entity_type_id = $this->fieldDefinition->getTargetEntityTypeId();
    $bundle = $this->fieldDefinition->getTargetBundle();
    if ($entity_type_id && $bundle) {
      $field_definitions = $this->entityFieldManager->getFieldDefinitions($entity_type_id, $bundle);
      foreach ($field_definitions as $field_name => $field_def) {
        $field_type = $field_def->getType();
        if ($field_type === 'image') {
          $thumbnail_field_options[$field_name] = $this->t('@label (Image field)', ['@label' => $field_def->getLabel()]);
        }
        elseif ($field_type === 'entity_reference') {
          $target_type = $field_def->getSetting('target_type');
          if ($target_type === 'media') {
            $handler_settings = $field_def->getSetting('handler_settings') ?? [];
            $target_bundles = $handler_settings['target_bundles'] ?? [];
            // Include if target bundles are not restricted or include 'image'.
            if (empty($target_bundles) || isset($target_bundles['image'])) {
              $thumbnail_field_options[$field_name] = $this->t('@label (Media image field)', ['@label' => $field_def->getLabel()]);
            }
          }
        }
      }
    }

    $element['thumbnail_source_field'] = [
      '#type' => 'select',
      '#title' => $this->t('Thumbnail source field'),
      '#default_value' => $this->getSetting('thumbnail_source_field'),
      '#options' => $thumbnail_field_options,
      '#description' => $this->t('Select an Image or Media (image) field from this media type to use as the video thumbnail. When the selected field is empty, falls back to the default thumbnail/icon behavior.'),
    ];

    $image_styles = image_style_options(FALSE);
    $description_link = Link::fromTextAndUrl(
      $this->t('Configure Image Styles'),
      Url::fromRoute('entity.image_style.collection')
    );
    $element['thumbnail_source_image_style'] = [
      '#title' => $this->t('Thumbnail image style'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('thumbnail_source_image_style'),
      '#empty_option' => $this->t('None (original image)'),
      '#options' => $image_styles,
      '#description' => $description_link->toRenderable() + [
        '#access' => $this->currentUser->hasPermission('administer image styles'),
      ],
      '#states' => [
        'invisible' => [
          ':input[name$="[settings][thumbnail_source_field]"]' => ['value' => ''],
        ],
      ],
    ];

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();
    $summary[] = $this->t('Text that launches a modal window.');
    $summary[] = $this->t('Muted: %muted', ['%muted' => $this->getSetting('muted') ? $this->t('yes') : $this->t('no')]);
    $summary[] = $this->t('Size: %width x %height pixels', [
      '%width' => $this->getSetting('width'),
      '%height' => $this->getSetting('height'),
    ]);

    $thumbnail_source_field = $this->getSetting('thumbnail_source_field');
    if (!empty($thumbnail_source_field)) {
      $summary[] = $this->t('Thumbnail source field: @field', ['@field' => $thumbnail_source_field]);
      $image_styles = image_style_options(FALSE);
      $thumbnail_image_style = $this->getSetting('thumbnail_source_image_style');
      if (!empty($thumbnail_image_style) && isset($image_styles[$thumbnail_image_style])) {
        $summary[] = $this->t('Thumbnail image style: @style', ['@style' => $image_styles[$thumbnail_image_style]]);
      }
      else {
        $summary[] = $this->t('Thumbnail image style: Original image');
      }
    }
    else {
      $summary[] = $this->t('Thumbnail source: Default (auto thumbnail / icon)');
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  protected function prepareAttributes(array $additional_attributes = []) {
    return parent::prepareAttributes(['muted'])
      ->setAttribute('width', $this->getSetting('width'))
      ->setAttribute('height', $this->getSetting('height'));
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $settings = $this->getSettings();

    $source_files = $this->getSourceFiles($items, $langcode);
    if (empty($source_files)) {
      return $elements;
    }

    // Collect cache tags to be added for each item in the field.
    $cache_tags = [];
    $attributes = $this->prepareAttributes();

    $entity = $items->getEntity();
    $thumbnail_source_field = $settings['thumbnail_source_field'];

    foreach ($source_files as $delta => $files) {
      // Resolve the thumbnail item and element-level settings.
      $thumb = $entity->get('thumbnail')->first();
      $element_settings = $settings;

      if (!empty($thumbnail_source_field) && $entity->hasField($thumbnail_source_field)) {
        $source_field_items = $entity->get($thumbnail_source_field);
        if (!$source_field_items->isEmpty()) {
          $field_type = $entity->getFieldDefinition($thumbnail_source_field)->getType();

          if ($field_type === 'image') {
            // Direct image field: use the ImageItem directly.
            $thumb = $source_field_items->first();
            $element_settings['image_style'] = $settings['thumbnail_source_image_style'];
          }
          elseif ($field_type === 'entity_reference') {
            // Entity reference to media: resolve to the media thumbnail ImageItem.
            $ref_entity = $source_field_items->first()->entity;
            if ($ref_entity && $ref_entity->getEntityTypeId() === 'media' && $ref_entity->hasField('thumbnail') && !$ref_entity->get('thumbnail')->isEmpty()) {
              $thumb = $ref_entity->get('thumbnail')->first();
              $element_settings['image_style'] = $settings['thumbnail_source_image_style'];
            }
          }
        }
      }

      $elements[$delta] = [
        '#theme' => 'glightbox_media_file_video_formatter',
        '#file_video' => $files,
        '#thumb' => $thumb,
        '#entity' => $entity,
        '#settings' => $element_settings,
        '#cache' => [
          'tags' => $cache_tags,
        ],
        '#attached' => [
          'library' => [
            'glightbox_media_video/glightbox-media-video',
          ],
        ],
      ];

      $cache_tags = [];
      foreach ($files as $file) {
        $cache_tags = Cache::mergeTags($cache_tags, $file['file']->getCacheTags());
      }
      $elements[$delta]['#cache']['tags'] = $cache_tags;
    }

    // Attach the GLightbox JS and CSS.
    if ($this->glightboxAttachment->isApplicable()) {
      $this->glightboxAttachment->attach($elements);
    }

    return $elements;
  }
}

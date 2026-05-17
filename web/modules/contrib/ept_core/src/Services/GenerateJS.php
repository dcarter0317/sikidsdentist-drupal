<?php

namespace Drupal\ept_core\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\media\OEmbed\UrlResolver;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Transform Paragraph settings in JS.
 */
class GenerateJS {

  /**
   * The EPT Core configuration.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Converts oEmbed media URLs into endpoint-specific resource URLs.
   *
   * @var \Drupal\media\OEmbed\UrlResolver
   */
  protected $urlResolver;

  /**
   * The file URL generator.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new GenerateCSS object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config factory.
   * @param \Drupal\media\OEmbed\UrlResolver $url_resolver
   *   Converts oEmbed media URLs into endpoint-specific resource URLs.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $file_url_generator
   *   The file URL generator.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(ConfigFactoryInterface $config_factory, UrlResolver $url_resolver, FileUrlGeneratorInterface $file_url_generator, EntityTypeManagerInterface $entity_type_manager) {
    $this->config = $config_factory->get('ept_core.settings');
    $this->urlResolver = $url_resolver;
    $this->fileUrlGenerator = $file_url_generator;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Generate JS from $settings.
   */
  public function generateFromSettings($settings) {
    $javascript_data = [];

    if (empty($settings['other_settings']['background_media'])) {
      return $javascript_data;
    }

    $media = $this->entityTypeManager->getStorage('media')->load($settings['other_settings']['background_media']);
    if (empty($media)) {
      return $javascript_data;
    }

    /** @var \Drupal\media\MediaTypeInterface $media_type */
    $media_type = $this->entityTypeManager
      ->getStorage('media_type')
      ->load($media->bundle());

    $source_field_name = $media_type
      ->getSource()
      ->getSourceFieldDefinition($media_type)
      ->getName();

    switch ($media->getSource()->getPluginId()) {
      case 'image':
        /** @var \Drupal\file\Entity\File $file */
        $file = $media->get($source_field_name)->entity;
        $uri = $file->getFileUri();
        $media_url = $this->fileUrlGenerator->generateAbsoluteString($uri);

        if (!empty($media_url) && !empty($settings['other_settings']['background_image_style']) &&
          $settings['other_settings']['background_image_style'] == 'parallax') {
          $javascript_data['eptCoreParallax']['mediaUrl'] = $media_url;
        }
        break;

      case 'oembed:video':
        $javascript_data['eptCoreBackgroundRemoteVideo']['mediaUrl'] = $media->get($source_field_name)->value;
        $provider = $this->urlResolver->getProviderByUrl($media->get($source_field_name)->value);
        if ($provider->getName() == 'YouTube') {
          $javascript_data['eptCoreBackgroundRemoteVideo']['mediaProvider'] = 'YouTube';
        }
        break;

      case 'video_file':
        $fid = $media->get($source_field_name)->target_id;
        $file = $this->entityTypeManager->getStorage('file')->load($fid);
        if (!empty($file)) {
          $javascript_data['eptCoreBackgroundVideo']['mediaUrl'] = $this->fileUrlGenerator->generateAbsoluteString($file->getFileUri());
        }

        break;

    }

    return $javascript_data;
  }

}

<?php

namespace Drupal\media_responsive_thumbnail_url_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\media_responsive_thumbnail\Plugin\Field\FieldFormatter\MediaResponsiveThumbnailFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'media_responsive_thumbnail_url' formatter.
 *
 * @FieldFormatter(
 *   id = "media_responsive_thumbnail_url",
 *   label = @Translation("Responsive thumbnail url"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class MediaResponsiveThumbnailUrlFormatter extends MediaResponsiveThumbnailFormatter {

  /**
   * The file URL generator.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $fileUrlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $plugin = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $plugin->fileUrlGenerator = $container->get('file_url_generator');
    return $plugin;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $media_items = $this->getEntitiesToView($items, $langcode);

    // Early opt-out if the field is empty.
    if (empty($media_items)) {
      return $elements;
    }

    // Collect cache tags to be added for each item in the field.
    /** @var \Drupal\responsive_image\Entity\ResponsiveImageStyle $responsive_image_style */
    $responsive_image_style = $this->responsiveImageStyleStorage->load($this->getSetting('responsive_image_style'));
    $image_styles_to_load = [];
    $cache_tags = [];
    if ($responsive_image_style) {
      $cache_tags = Cache::mergeTags($cache_tags, $responsive_image_style->getCacheTags());
      $image_styles_to_load = $responsive_image_style->getImageStyleIds();
    }

    /** @var \Drupal\image\Entity\ImageStyle[] $image_styles */
    $image_styles = $this->imageStyleStorage->loadMultiple($image_styles_to_load);
    foreach ($image_styles as $image_style) {
      $cache_tags = Cache::mergeTags($cache_tags, $image_style->getCacheTags());
    }


    /** @var \Drupal\media\MediaInterface[] $media_items */
    foreach ($media_items as $delta => $media) {
      $thumbnailUri = $media->get('thumbnail')->entity->getFileUri();
      $urls = [];
      foreach ($image_styles as $image_style_name => $image_style) {
        $url = $image_style ? $image_style->buildUrl($thumbnailUri) : $this->fileUrlGenerator->generateAbsoluteString($thumbnailUri);
        $urls[$image_style_name]['#markup'] = $this->fileUrlGenerator->transformRelative($url);
      }
      $elements[$delta] = [
        '#theme' => 'item_list',
        '#items' => $urls,
      ];

      // Add cacheability of each item in the field.
      $this->renderer->addCacheableDependency($elements[$delta], $media);
    }

    // Add cacheability of the image style setting.
    if ($this->getSetting('image_link') && ($image_style = $this->responsiveImageStyleStorage->load($this->getSetting('responsive_image_style')))) {
      $this->renderer->addCacheableDependency($elements, $image_style);
    }

    return $elements;
  }

}

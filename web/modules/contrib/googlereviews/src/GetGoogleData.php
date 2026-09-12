<?php

namespace Drupal\googlereviews;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Get data from Google Maps API.
 */
class GetGoogleData implements GetGoogleDataInterface {

  use StringTranslationTrait;

  /**
   * The HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $client;

  /**
   * The logger channel factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $logger;

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The URL generator.
   *
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * The URL generator.
   *
   * @var \Drupal\Core\StringTranslation\TranslationInterface
   */
  protected $stringTranslation;

  /**
   * Constructs a GetGoogleData object.
   *
   * @param \GuzzleHttp\ClientInterface $client
   *   The HTTP client.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The logger channel factory.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The URL generator.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   *   The string translation service.
   */
  public function __construct(ClientInterface $client, LoggerChannelFactoryInterface $logger, MessengerInterface $messenger, ConfigFactoryInterface $config_factory, LanguageManagerInterface $language_manager, UrlGeneratorInterface $url_generator, TranslationInterface $string_translation) {
    $this->client = $client;
    $this->logger = $logger;
    $this->messenger = $messenger;
    $this->configFactory = $config_factory;
    $this->languageManager = $language_manager;
    $this->urlGenerator = $url_generator;
    $this->stringTranslation = $string_translation;
  }

  /**
   * Get reviews from Google Maps API.
   *
   * @param array $fields
   *   (optional) The fields which the result should be limited to.
   * @param int $max_reviews
   *   (optional) The max amount of reviews to return.
   * @param string $reviews_sort
   *   (optional) The sorting of the reviews 'newest' or 'most_relevant'.
   * @param string $language
   *   (optional) The language that should be used to translate certain results.
   * @param string|null $google_place_id
   *   (optional) The place ID.
   * @param int|null $minimum_rating
   *   (optional) The minimum review rating to include.
   * @param string $filtered_words
   *   (optional) Comma-separated words that exclude matching review text or
   *   reviewer names.
   *
   * @return array
   *   Data from Google Maps API with information about a place_id in an array.
   */
  public function getGoogleReviews(array $fields = [], int $max_reviews = 5, string $reviews_sort = 'newest', string $language = '', ?string $google_place_id = '', ?int $minimum_rating = NULL, string $filtered_words = ''): array {
    $config = $this->configFactory->get('googlereviews.settings');
    $auth_key = $config->get('google_auth_key');
    $place_id = !empty($google_place_id) ? $google_place_id : $config->get('google_place_id');
    $api_url = $config->get('google_api_url');
    $language = ($language == '') ? $this->languageManager->getCurrentLanguage()->getId() : $language;

    if ($auth_key == '' || $place_id == '') {
      $link = $this->urlGenerator->generateFromRoute('googlereviews.settings_form');
      $this->messenger->addError($this->t('You need to add credentials on the <a href=":link">Google review settings page</a> to show the reviews.', [':link' => $link]));
      return [];
    }
    $client_options = [];

    if ($config->get('google_places_api') === 1) {
      // v1 API.
      $api_url .= $place_id;
      $client_options['headers'] = [];
      $client_options['headers']['X-Goog-Api-Key'] = $auth_key;
      $client_options['headers']['languageCode'] = $language;
      $client_options['headers']['X-Goog-FieldMask'] = implode(',', $fields);
      $client_options['headers']['Content-Type'] = 'application/json';
    }
    else {
      // Legacy API.
      $client_options['query'] = [];
      $client_options['query']['place_id'] = $place_id;
      $client_options['query']['key'] = $auth_key;
      $client_options['query']['language'] = $language;
      if (!empty($fields)) {
        $client_options['query']['fields'] = implode(',', $fields);
      }
      $client_options['query']['reviews_sort'] = $reviews_sort;
    }

    $result = [];
    try {
      $request = $this->client->get($api_url, $client_options);
      $resultArray = json_decode($request->getBody(), TRUE);

      if ($config->get('google_places_api') === 1) {
        if (isset($resultArray['error'])) {
          $this->logger->get('googlereviews')->error($this->t('Something went wrong with contacting the Google Maps API. @status, @error', [
            '@status' => $resultArray['error']['status'],
            '@error' => $resultArray['error']['message'],
          ]));
          $this->messenger->addError($this->t('Something went wrong with contacting the Google Maps API.'));
        }
        elseif (isset($resultArray['id'])) {
          $result['place_id'] = $resultArray['id'];
          $result['rating'] = $resultArray['rating'];
          if (isset($resultArray['userRatingCount'])) {
            $result['user_ratings_total'] = $resultArray['userRatingCount'];
          }
          if (isset($resultArray['googleMapsLinks']['reviewsUri'])) {
            $result['url'] = $resultArray['googleMapsLinks']['reviewsUri'];
          }
          if (isset($resultArray['reviews'])) {
            $resultArray['reviews'] = array_slice($resultArray['reviews'], 0, $max_reviews);
            $result['reviews'] = [];
            foreach ($resultArray['reviews'] as $review) {
              $result['reviews'][] = [
                'author_name' => $review['authorAttribution']['displayName'],
                'author_url' => $review['authorAttribution']['uri'],
                'profile_photo_url' => $review['authorAttribution']['photoUri'],
                'rating' => $review['rating'],
                'relative_time_description' => $review['relativePublishTimeDescription'],
                'text' => $review['text']['text'],
              ];
            }
            $result['reviews'] = $this->filterReviews($result['reviews'], $minimum_rating, $filtered_words);
          }
        }
      }
      else {
        // Legacy API errors.
        if (isset($resultArray['status']) && $resultArray['status'] !== 'OK') {
          if (isset($resultArray['error_message']) && !empty($resultArray['error_message'])) {
            $this->logger->get('googlereviews')->error($this->t('Something went wrong with contacting the Google Maps API. @status, @error', [
              '@status' => $resultArray['status'],
              '@error' => $resultArray['error_message'],
            ]));
            $this->messenger->addError($this->t('Something went wrong with contacting the Google Maps API.'));
          }
          else {
            $this->logger->get('googlereviews')->error($this->t('Something went wrong with contacting the Google Maps API: @status', [
              '@status' => $resultArray['status'],
            ]));
            $this->messenger->addError($this->t('Something went wrong with contacting the Google Maps API.'));
          }
        }

        // Legacy API result.
        if (isset($resultArray['result']) && !empty($resultArray['result'])) {
          if (isset($resultArray['result']['reviews'])) {
            $resultArray['result']['reviews'] = $this->filterReviews($resultArray['result']['reviews'], $minimum_rating, $filtered_words);
            $resultArray['result']['reviews'] = array_slice($resultArray['result']['reviews'], 0, $max_reviews);
          }

          $result = $resultArray['result'];
        }
      }
    }
    catch (RequestException $e) {
      $this->logger->get('googlereviews')->error($e);
      $this->messenger->addError($this->t('Something went wrong with contacting the Google Maps API.'));
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    $config = $this->configFactory->get('googlereviews.settings');
    return $config->get('cache_max_age');
  }

  /**
   * {@inheritdoc}
   */
  public function getGooglePlacesApiVersion() {
    $config = $this->configFactory->get('googlereviews.settings');
    return $config->get('google_places_api');
  }

  /**
   * Applies moderation filters to reviews.
   *
   * @param array $reviews
   *   Reviews returned by Google.
   * @param int|null $minimum_rating
   *   Minimum rating threshold.
   * @param string $filtered_words
   *   Comma-separated words to exclude from review text or reviewer names.
   *
   * @return array
   *   Filtered reviews.
   */
  protected function filterReviews(array $reviews, ?int $minimum_rating, string $filtered_words): array {
    $filtered_words = array_filter(array_map('trim', explode(',', $filtered_words)));

    if ($minimum_rating === NULL && empty($filtered_words)) {
      return $reviews;
    }

    return array_filter($reviews, function (array $review) use ($minimum_rating, $filtered_words) {
      if ($minimum_rating !== NULL && (!isset($review['rating']) || (float) $review['rating'] < $minimum_rating)) {
        return FALSE;
      }

      if (empty($filtered_words)) {
        return TRUE;
      }

      $review_text = (string) ($review['text'] ?? '');
      $reviewer_name = (string) ($review['author_name'] ?? '');
      foreach ($filtered_words as $word) {
        if ($word !== '' && (stripos($review_text, $word) !== FALSE || stripos($reviewer_name, $word) !== FALSE)) {
          return FALSE;
        }
      }

      return TRUE;
    });
  }

}

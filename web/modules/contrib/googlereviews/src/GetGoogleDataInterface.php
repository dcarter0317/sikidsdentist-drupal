<?php

namespace Drupal\googlereviews;

/**
 * Interface for Get Google Data class.
 *
 * @package Drupal\googlereviews
 */
interface GetGoogleDataInterface {

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
  public function getGoogleReviews(array $fields = [], int $max_reviews = 5, string $reviews_sort = 'newest', string $language = '', ?string $google_place_id = '', ?int $minimum_rating = NULL, string $filtered_words = ''): array;

  /**
   * Get cache max age.
   *
   * @return int
   *   Cache max age in seconds.
   */
  public function getCacheMaxAge();

  /**
   * Get API version.
   *
   * @return int
   *   API version.
   */
  public function getGooglePlacesApiVersion();

}

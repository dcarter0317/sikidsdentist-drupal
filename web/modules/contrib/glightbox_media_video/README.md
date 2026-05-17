# CONTENTS OF THIS FILE

- Introduction
- Features
- Requirements
- Installation
- Local Video Thumbnail
- Maintainers

## Introduction

GLightbox Media Video extends Drupal GLightbox module with support for core media video and remote video types.

## Features

The GLightbox Media Video module:

- Works as a Formatter for Video URL field in Remote Media Video
- Works as a Formatter for Video file field in Local Media Video (media type "video")
- Choose between a text or thumbnail to launch a GLightbox
- Supports Media thumbnail and image styles
- Supports Gallery (video grouping) - aka GLightbox rel
- Custom thumbnail source field for Local Video with image style selection

## Requirements

- GLightbox (https://www.drupal.org/project/glightbox)
- Media (core)

## Installation

1. Install the module as normal, see link for instructions.
   Link: https://www.drupal.org/documentation/install/modules-themes/modules-8

2. Go to "Media types" -> "Remote Video" -> "Manage display" -> "Video URL" => select GLightbox Remote Media Video formatter and adjust settings

3. Go to "Media types" -> "Video" -> "Manage display" -> "Video file" => select GLightbox Video Popup formatter and adjust settings

## Local Video Thumbnail

The **GLightbox Video Popup** formatter (for the `file` field on the `video` media type) supports
a configurable thumbnail source with the following options:

### Thumbnail source field

By default the formatter uses the auto-generated media thumbnail (typically a video icon) as the
clickable image that opens the GLightbox popup.

You can override this by selecting a **Thumbnail source field** in the formatter settings:

- **Image field** — any `image` field attached to the Video media type. The image stored in that
  field is used directly as the thumbnail.
- **Media (image) field** — any `entity_reference` field on the Video media type that references
  a `media` entity of bundle `image`. The thumbnail of the referenced Image media entity is used.

The dropdown is populated automatically from the fields available on the media bundle where the
formatter is configured, so only compatible field types are listed.

### Thumbnail image style

When a **Thumbnail source field** is selected you can also choose a **Thumbnail image style** to
control how the image is rendered (e.g. crop, scale, etc.). Leave it empty to display the image
at its original size.

### Fallback behaviour

If the selected Thumbnail source field has no value for a particular video item (e.g. the image
was not filled in), the formatter automatically falls back to the default behaviour: the
auto-generated thumbnail/icon is displayed and clicking it opens the video in the GLightbox popup.
This means existing display is never broken by an empty field.

## Recommended modules

Looking for Image gallery module? You can try these modules with GLightbox integration:

[Extra Block Types (EBT): Image Gallery](https://www.drupal.org/project/ebt_image_gallery)
[Extra Paragraph Types (EPT): Image Gallery](https://www.drupal.org/project/ept_image_gallery)
[Extra Block Types (EBT): Image](https://www.drupal.org/project/ebt_image)
[Extra Paragraph Types (EPT): Image](https://www.drupal.org/project/ept_image)

Looking for Video gallery module? You can try these modules with GLightbox integration:

[Extra Block Types (EBT): Video and Image Gallery](https://www.drupal.org/project/ebt_video_and_image_gallery)
[Extra Paragraph Types (EPT): Video and Image Gallery](https://www.drupal.org/project/ept_video_and_image_gallery)
[Extra Block Types (EBT): Video](https://www.drupal.org/project/ebt_video)
[Extra Paragraph Types (EPT): Video](https://www.drupal.org/project/ept_video)

## Maintainers

Maintainers:

- Ivan Abramenko (https://www.drupal.org/u/levmyshkin)

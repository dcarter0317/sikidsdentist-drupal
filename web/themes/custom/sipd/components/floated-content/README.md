# Floated Content Component

An editorial layout component that floats an image left or right of a body text block, allowing copy to wrap naturally around it. Used for blog posts, news articles, and dental practice editorial pages.

## Props

| Prop | Type | Required | Default | Description |
|---|---|---|---|---|
| `image_url` | string | no | — | URL of the floated image |
| `image_alt` | string | no | `""` | Alt text for the image |
| `body` | string | **yes** | — | Pre-rendered HTML body copy |
| `float_direction` | `left` \| `right` | no | `left` | Which side the image floats to |

## Paragraph Fields

| Drupal Field | Machine Name | Type | Maps To |
|---|---|---|---|
| Image | `field_fc_image` | Media (image) | `image_url`, `image_alt` |
| Body | `field_fc_body` | Long text (formatted) | `body` |
| Float Direction | `field_fc_float_direction` | List (text) | `float_direction` |

## Responsive Behavior

| Breakpoint | Behavior |
|---|---|
| > 768px | Image is `400px` wide; text wraps alongside it |
| ≤ 768px | Image shrinks to `50%` width; text continues to wrap |
| ≤ 480px | Float removed; image goes full-width and stacks above text |

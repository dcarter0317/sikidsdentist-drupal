# Post Component — Drupal SDC + Paragraphs

## Purpose

The **Post** component is a horizontal content row layout featuring an image, eyebrow (date), title, optional subtitle, description, and CTA link.

All fields are optional. Empty fields are not rendered.

## Files

| File | Purpose |
|---|---|
| `components/post/post.component.yml` | SDC metadata and prop contract |
| `components/post/post.twig` | Component markup |
| `components/post/post.css` | Component styles |
| `components/post/thumbnail.png` | Component visual reference |
| `templates/paragraphs/paragraph--post.html.twig` | Bridge template — maps paragraph fields to SDC props |

## Paragraph Fields

Add these fields to the `post` paragraph bundle (machine names below):

| Label | Machine Name | Field Type | Notes |
|---|---|---|---|
| Eyebrow | `field_post_eyebrow` | Text (plain) | Typically the publication date (e.g. `October 23, 2025`) |
| Title | `field_post_title` | Text (plain) | Main h3 post heading |
| Subtitle | `field_post_subtitle` | Text (plain) | Optional secondary headline (h4) |
| Body | `field_post_body` | Text (long, formatted/plain) | Post excerpt or body copy |
| Image | `field_post_media` | Entity reference (Media) | Image media bundle |
| CTA | `field_post_cta` | Link | Call-to-action link |

## Render Flow

1. The editor fills in fields on the `post` paragraph.
2. `paragraph--post.html.twig` reads those values and resolves the media entity URL.
3. Template includes `sipd:post` SDC with mapped props.
4. SDC renders only non-empty fields.

## Cache Rebuild

After adding or modifying component files, rebuild the Drupal cache:

```bash
drush cr
```

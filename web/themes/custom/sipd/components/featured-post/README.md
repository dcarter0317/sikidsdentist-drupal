# Featured Post Component — Drupal SDC + Paragraphs + Layout Builder

## Purpose

This Featured Post component uses:
- **Paragraphs** for content management.
- **Single Directory Components (SDC)** for markup, CSS, and metadata.
- **Layout Builder** for page placement.

All fields are optional. Empty fields are not rendered.

## Files

| File | Purpose |
|---|---|
| `components/featured-post/featured-post.component.yml` | SDC metadata and prop contract |
| `components/featured-post/featured-post.twig` | Component markup |
| `components/featured-post/featured-post.css` | Component styles |
| `templates/paragraphs/paragraph--featured-post.html.twig` | Bridge template — maps paragraph fields to SDC props |

## Paragraph Fields

Add these fields to the `featured_post` paragraph bundle (machine names below):

| Label | Machine Name | Field Type | Notes |
|---|---|---|---|
| Style | `field_fp_style` | List (text) | `standard` or `featured` |
| Eyebrow | `field_fp_eyebrow` | Text (plain) | Typically the publication date |
| Subtitle | `field_fp_subtitle` | Text (plain) | h4 — shown in **featured** style only |
| Category | `field_fp_category` | Text (plain) | Shown in **featured** style only |
| Author | `field_fp_author` | Text (plain) | Shown in **featured** style only |
| Image | `field_fp_media` | Entity reference (Media) | Image media bundle |
| Title | `field_fp_title` | Text (plain) | Main h3 post heading |
| Body | `field_fp_body` | Text (long) | Post excerpt / body copy |
| CTA | `field_fp_cta` | Link | "Read More" link |

## Style Variants

| Style value | Variant class | What it shows |
|---|---|---|
| `standard` | `post--standard` | Eyebrow, title, description, CTA |
| `featured` | `post--featured` | All of the above + subtitle, category, author |

The `post__header` block (subtitle, category, author) is only rendered in the Twig template when `variant_class == 'post--featured'`.

## Render Flow

1. Editor fills in fields on the `featured_post` paragraph.
2. `paragraph--featured-post.html.twig` reads those values and resolves the media entity URL.
3. Template includes `sipd:featured-post` with mapped props.
4. SDC renders only non-empty fields.

## Cache Rebuild

After any template or component file change:

```bash
drush cr
```

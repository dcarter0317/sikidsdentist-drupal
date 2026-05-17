# Page Hero Component

A full-width hero section with a large image and an overlaid text card containing a banner label, heading, description, and call-to-action link. Used as the top hero for interior/service pages.

## File Structure

```
page-hero/
  page-hero.component.yml   Component schema (props)
  page-hero.twig            Twig template
  page-hero.css             Scoped component styles
  README.md                 This file
```

## Props

| Prop | Type | Required | Description |
|---|---|---|---|
| `banner_label` | string | No | Short uppercase label in the teal banner |
| `title` | string | **Yes** | Main h1 heading on the text card |
| `description` | string (HTML) | No | Pre-rendered HTML from formatted text field — output with `\|raw` |
| `cta_label` | string | No | Call-to-action link text |
| `cta_url` | string | No | Call-to-action link URL |
| `image_url` | string | No | Resolved file URL from media entity |
| `image_alt` | string | No | Alt text from the media image |

## Paragraph Type Fields (as created)

| Field label | Machine name | Field type | Maps to prop |
|---|---|---|---|
| Banner Label | `field_ph_banner_label` | Text (plain) | `banner_label` |
| Title | `field_ph_title` | Text (plain) | `title` |
| Description | `field_ph_description` | Text (formatted, long) | `description` |
| CTA | `field_ph_cta` | Link | `cta_label` + `cta_url` |
| Image | `field_ph_image` | Entity reference (Media) | `image_url` + `image_alt` |

## Paragraph Template

Create `paragraph--page-hero.html.twig` in your theme's `templates/paragraphs/` folder:

```twig
{%
  set image_url = null
  set image_alt = ''
%}

{# Resolve image URL and alt text from the Media entity reference #}
{% if content.field_ph_image[0] is not empty %}
  {% set media_entity = paragraph.field_ph_image.entity %}
  {% set file_entity = media_entity.field_media_image.entity %}
  {% set image_url = file_url(file_entity.uri.value) %}
  {% set image_alt = media_entity.field_media_image.alt %}
{% endif %}

{% include 'sipd:page-hero' with {
  banner_label: paragraph.field_ph_banner_label.value,
  title: paragraph.field_ph_title.value,
  description: content.field_ph_description|render,
  cta_label: paragraph.field_ph_cta.title,
  cta_url: paragraph.field_ph_cta.uri|replace({'internal:': ''}),
  image_url: image_url,
  image_alt: image_alt,
} only %}
```

## CSS Variables Required

| Variable | Purpose |
|---|---|
| `--clr-bg-3` | Text card background |
| `--clr-bg-4` | Banner and CTA button background |
| `--clr-text-2` | Text card foreground color |
| `--card-link-color` | CTA link text color |
| `--fw-light` | Banner font weight |
| `--fw-bold` | CTA button font weight |
| `--fs-caption` | Description font size |

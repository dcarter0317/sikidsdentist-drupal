# Banner Component — Drupal SDC + Paragraphs

## Architecture Overview

```
┌───────────────────────────────────────────────────────────────────┐
│              PARAGRAPHS MODULE  — "banner" bundle                 │
│   Stores & provides content:                                      │
│     field_banner_style           (list_string)                    │
│     field_banner_title           (string)                         │
│     field_banner_body            (string)                         │
│     field_banner_label           (string)                         │
│     field_banner_cta             (link)                           │
│     field_banner_cta_secondary   (link)                           │
└───────────────────────────┬───────────────────────────────────────┘
                            │ paragraph--banner.html.twig (bridge)
                            ▼
┌───────────────────────────────────────────────────────────────────┐
│          SINGLE DIRECTORY COMPONENT  — sipd:banner                │
│     banner.component.yml  — prop contract                         │
│     banner.twig           — markup                                │
│     banner.css            — scoped styles                         │
└───────────────────────────────────────────────────────────────────┘
```

## Banner Styles

| Style | Fields used | Layout |
|-------|-------------|--------|
| `default` | title, body, cta | Centered title + body + single button |
| `button-banner` | label, cta, cta_secondary | Label (uppercase) + two-button group |
| `cta-banner` | label, cta | Inline label + single button with arrow |

## Paragraph Fields

| Label | Machine name | Drupal type | Used in style |
|-------|--------------|-------------|---------------|
| Style | `field_banner_style` | List (text) | all |
| Title | `field_banner_title` | Text (plain) | default |
| Body | `field_banner_body` | Text (plain) | default |
| Label | `field_banner_label` | Text (plain) | button-banner, cta-banner |
| Primary CTA | `field_banner_cta` | Link | all |
| Secondary CTA | `field_banner_cta_secondary` | Link | button-banner |

## Setup

### 1. Enable the module

```bash
drush en banner_paragraph -y
```

### 2. Add field instances via UI

Go to **Structure → Paragraph types → Banner → Manage fields** and confirm all fields exist.

### 3. Add a Paragraphs reference field to your content type

Add an **Entity reference revisions** field to your content type and allow the **Banner** paragraph type.

### 4. Clear caches and validate

```bash
drush cr
drush sdc:validate sipd:banner
```

## Customization

### Change the background color
The banner uses `--clr-bg-4` from your global design tokens. Override per-instance with:
```css
.banner { --banner-bg-color: #your-color; }
```

### Add a background image
Extend the paragraph type with an image field, resolve the file URL in the bridge template, and add an inline style to the `<article>` in `banner.twig`:
```twig
<article class="banner banner--{{ banner_style }}"
  {% if background_image_url %}style="background-image: url('{{ background_image_url }}');"{% endif %}>
```

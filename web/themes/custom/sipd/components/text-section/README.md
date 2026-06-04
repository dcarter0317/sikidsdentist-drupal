# Text Section Component — Drupal SDC + Paragraphs

## Purpose

The **Text Section** component is a clean, modular block designed for displaying editorial copy, structured messaging, and an optional call-to-action button, with a customizable top border accent.

All fields are optional. Empty fields are not rendered.

## Files

| File | Purpose |
|---|---|
| `components/text-section/text-section.component.yml` | SDC metadata and prop contract |
| `components/text-section/text-section.twig` | Component markup |
| `components/text-section/text-section.css` | Component styles |
| `components/text-section/thumbnail.png` | Component visual reference |
| `templates/paragraphs/paragraph--text-section.html.twig` | Bridge template — maps paragraph fields to SDC props |

## Paragraph Fields

Add these fields to the `text_section` paragraph bundle (machine names below):

| Label | Machine Name | Field Type | Notes |
|---|---|---|---|
| Title | `field_ts_title` | Text (plain) | Main h2 section heading |
| Description | `field_ts_description` | Text (long, formatted) | Section body copy / description |
| CTA | `field_ts_cta_link` | Link | Optional call-to-action button |
| Show Top Border | `field_ts_border_top` | Boolean | Toggles the top border divider accent |

## Render Flow

1. The editor fills in fields on the `text_section` paragraph.
2. `paragraph--text-section.html.twig` reads those values.
3. Template includes `sipd:text-section` SDC with mapped props.
4. SDC renders only non-empty fields.

## Cache Rebuild

After adding or modifying component files, rebuild the Drupal cache:

```bash
drush cr
```

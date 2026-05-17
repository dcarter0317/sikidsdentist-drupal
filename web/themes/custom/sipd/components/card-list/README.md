# Card List Component - Drupal SDC + Paragraphs

## Purpose

`card_list` is a container paragraph that renders multiple nested `card_item` paragraphs.

## Files

- `components/card-list/card-list.component.yml`
- `components/card-list/card-list.twig`
- `components/card-list/card-list.css`
- `templates/paragraphs/paragraph--card-list.html.twig`
- `templates/paragraphs/paragraph--card-item.html.twig`

## Recommended Paragraph Setup

### Paragraph type: `card_item`
Optional fields:
- `field_card_eyebrow`
- `field_card_image`
- `field_card_title`
- `field_card_description`
- `field_card_cta`

### Paragraph type: `card_list`
- Optional heading field: `field_card_list_heading` (or `field_heading`)
- Nested cards field (Entity reference revisions) allowing multiple `card_item`:
  - Any machine name is supported.
  - Template auto-detects the first populated paragraph reference-revisions field
    that allows bundle `card_item` / `card-item`.

## Cache Rebuild

```bash
drush cr
```

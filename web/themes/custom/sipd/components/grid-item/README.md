# Grid Item

Generic content cell used inside a **Grid Container**. The item can hold any HTML body content — text, images, lists, embedded components.

## Props

| Prop | Type | Required | Description |
|------|------|----------|-------------|
| `heading` | string | no | Optional cell heading |
| `content` | string | no | Body content; HTML markup is allowed |

## Drupal paragraph fields

| Field machine name | Type | Maps to |
|--------------------|------|---------|
| `field_grid_item_heading` | Plain text | `heading` |
| `field_grid_item_content` | Formatted long text | `content` |

## Notes

- Layout (columns, gap) is entirely controlled by the parent **Grid Container** — this component only styles its own cell.
- `content` is rendered with `|raw`; only store trusted/filtered HTML.

## Usage (Twig)

```twig
{% include "sipd:grid-item" with {
  heading: 'Cell Heading',
  content: '<p>Any HTML content here.</p>',
} only %}
```

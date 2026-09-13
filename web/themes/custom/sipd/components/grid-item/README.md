# Grid Item

Generic content cell used inside a **Grid Container**. The item can hold any HTML body content — text, images, lists, embedded components.

## Props

| Prop | Type | Required | Description |
|------|------|----------|-------------|
| `heading` | string | no | Optional cell heading |
| `content` | string | no | Body content; HTML markup is allowed |
| `bg_color` | string | no | Background color, hex (e.g. `#FFFFFF`) |
| `text_color` | string | no | Text color, hex (e.g. `#00334F`) |
| `border_color` | string | no | Color of the 3px bottom border, hex (e.g. `#1478A3`) |

## Drupal paragraph fields

| Field machine name | Type | Maps to |
|--------------------|------|---------|
| `field_grid_item_heading` | Plain text | `heading` |
| `field_grid_item_content` | Formatted long text | `content` |
| `field_grid_item_bg_color` | Color (color_field, box widget) | `bg_color` |
| `field_grid_item_text_color` | Color (color_field, box widget) | `text_color` |
| `field_grid_item_border_color` | Color (color_field, box widget) | `border_color` |

## Notes

- Layout (columns, gap) is entirely controlled by the parent **Grid Container** — this component only styles its own cell.
- `content` is rendered with `|raw`; only store trusted/filtered HTML.
- Color fields use the same `color_field_widget_box` swatch palette as other paragraph types (e.g. Text Block). The bottom border is a fixed 3px width; only its color is configurable.

## Usage (Twig)

```twig
{% include "sipd:grid-item" with {
  heading: 'Cell Heading',
  content: '<p>Any HTML content here.</p>',
  bg_color: '#FFFFFF',
  text_color: '#00334F',
  border_color: '#1478A3',
} only %}
```

# Grid Container

CSS Grid layout wrapper. Place any number of **Grid Item** paragraph instances inside it; column count is set by the `columns` variant. Collapses to a single column below 900 px.

## Props

| Prop | Type | Required | Description |
|------|------|----------|-------------|
| `heading` | string | no | Optional section heading spanning the full grid width |

## Slots

| Slot | Description |
|------|-------------|
| `items` | Rendered Grid Item paragraph instances |

## Variants

| Variant key | Desktop columns | Mobile |
|-------------|-----------------|--------|
| `columns-auto` (default) | Auto-fills at 300 px min — naturally responsive | 1 |
| `columns-2` | 2 | 1 |
| `columns-3` | 3 | 1 |
| `columns-4` | 4 | 1 |
| `columns-5` | 5 | 1 |
| `columns-6` | 6 | 1 |

## Drupal paragraph fields (parent bundle)

| Field machine name | Type | Maps to |
|--------------------|------|---------|
| `field_grid_heading` | Plain text | `heading` |
| `field_grid_columns` | List (text): `2`–`6` | `variant_class` → `grid-container--columns-N` |
| `field_grid_items` | Entity reference revisions → `grid_item` | `items` slot |

## Nesting

```
[Grid Container paragraph]
  └─ [Grid Item paragraph] ×N
```

## Usage (Twig)

```twig
{% include "sipd:grid-container" with {
  heading: 'Our Services',
  variant_class: 'grid-container--columns-3',
  items: items,
} only %}
```

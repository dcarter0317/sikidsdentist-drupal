# Accordion List

Grid container that lays out multiple **Accordion Item** paragraph instances. Add as many items as needed; column count is controlled by the `columns` variant.

## Props

| Prop | Type | Required | Description |
|------|------|----------|-------------|
| `heading` | string | no | Optional heading displayed above the grid |

## Slots

| Slot | Description |
|------|-------------|
| `items` | Rendered Accordion Item paragraph instances |

## Variants

| Variant key | Columns (desktop) | Mobile |
|-------------|-------------------|--------|
| `columns-1` (default) | 1 — classic full-width stacked accordion | 1 |
| `columns-2` | 2 side-by-side | 1 |
| `columns-3` | 3 columns | 1 |
| `columns-4` | 4 columns | 1 |

## Drupal paragraph fields (parent)

| Field machine name | Type | Maps to |
|--------------------|------|---------|
| `field_accordion_list_heading` | Plain text | `heading` |
| `field_accordion_list_columns` | List (text) | `variant_class` → `accordion-list--columns-N` |

## Nesting

This component is the **parent**. Each child is an **Accordion Item** paragraph (`sipd:accordion-item`):

```
[Accordion List paragraph]
  └─ [Accordion Item paragraph] ×N
```

## Usage (Twig)

```twig
{% include "sipd:accordion-list" with {
  heading: 'Frequently Asked Questions',
  variant_class: 'accordion-list--columns-2',
  items: items,
} only %}
```

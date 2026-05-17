# Accordion Item

Single expandable `<details>`/`<summary>` component. Add multiple paragraph instances of this type to build an accordion list on any page.

## Props

| Prop | Type | Required | Description |
|------|------|----------|-------------|
| `title` | string | yes | The heading shown in the collapsed summary bar |
| `content` | string | yes | The expandable body; HTML markup is allowed |
| `open` | boolean | no | Start the item expanded (default: false) |

## Drupal paragraph fields

| Field machine name | Type | Maps to |
|--------------------|------|---------|
| `field_accordion_title` | Plain text | `title` |
| `field_accordion_content` | Formatted long text | `content` |
| `field_accordion_open` | Boolean | `open` |

## CSS features used

- `::details-content` pseudo-element for padding the expandable region (supported all major browsers since Sep 2025).
- `calc-size(auto, …)` for animated open/close to intrinsic height — applied as progressive enhancement; non-supporting browsers still get a working (non-animated) accordion.
- `transition-behavior: allow-discrete` to animate `content-visibility` in sync with the height animation.

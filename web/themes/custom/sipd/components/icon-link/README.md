# Icon Link

Icon link block with a circular icon and a bordered text label.

## Props

| Prop | Type | Required | Description |
|------|------|----------|-------------|
| `url` | string | yes | Link destination URL |
| `text` | string | yes | Link text displayed in the block |
| `icon_class` | string | no | Font Awesome icon class (default: `fa-solid fa-user-group`) |

## Drupal block fields

This component is used by the `icon_link` custom block type. The fields map as follows:

| Field machine name | Type | Maps to |
|--------------------|------|---------|
| `field_icon_link_url` | Link | `url` |
| `field_icon_link_text` | Plain text | `text` |
| `field_icon_link_class` | Plain text | `icon_class` |

## Drupal paragraph fields

This component is also used by the `icon_link` paragraph type. The fields map as follows:

| Field machine name | Type | Maps to |
|--------------------|------|---------|
| `field_icon_link_url` | Plain text | `url` |
| `field_icon_link_text` | Plain text | `text` |
| `field_icon_link_class` | Plain text | `icon_class` |


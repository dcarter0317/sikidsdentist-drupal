# Card Component - Drupal SDC + Paragraphs + Layout Builder

## Purpose

This Card uses:
- Paragraphs for content management.
- Single Directory Components (SDC) for markup, CSS, and metadata.
- Layout Builder for page placement.

All Card fields are optional. If a field is empty, it is not rendered.

## Files

- `components/card/card.component.yml` - SDC metadata and prop contract.
- `components/card/card.twig` - Card markup.
- `components/card/card.css` - Card styles.
- `templates/paragraphs/paragraph--card.html.twig` - Bridge template mapping paragraph fields to SDC props.

## Expected Paragraph Fields

Recommended field machine names on paragraph bundle `card`:

- `field_card_eyebrow` (text)
- `field_card_media` (entity reference → Media: Image)
- `field_card_title` (text)
- `field_card_description` (text_long)
- `field_card_cta` (link)

The bridge template also supports legacy names:
- `field_card_body` as description fallback.
- `field_card_link` as CTA fallback.

## Render Flow

1. Paragraph entity stores Card content values.
2. `paragraph--card.html.twig` reads those values.
3. Template includes `sipd:card` and passes props.
4. Card SDC renders only populated fields.

## Variants

The Card SDC exposes a `text_alignment` variant:
- `text-left` (default)
- `text-center`
- `text-right`

Variant classes are applied on the root card element (`.card--text-left`, `.card--text-center`, `.card--text-right`) and styled in `card.css`.

## Cache Rebuild

After changing template/component files:

```bash
drush cr
```

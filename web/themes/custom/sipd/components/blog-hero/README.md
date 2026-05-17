# Blog Hero Component — Drupal SDC + Paragraphs + Layout Builder

## Architecture Overview

```
┌───────────────────────────────────────────────────────────────────┐
│                        LAYOUT BUILDER                             │
│   (arranges blocks/regions on a node; editor drags Hero block)    │
└───────────────────────────┬───────────────────────────────────────┘
                            │ renders a Block
                            ▼
┌───────────────────────────────────────────────────────────────────┐
│              PARAGRAPHS MODULE  — "blog_hero" bundle              │
│   Stores & provides content:                                      │
│     field_blog_hero_title            (string)                     │
│     field_blog_hero_date             (string)                     │
│     field_blog_hero_author           (string)                     │
│     field_blog_hero_author_link      (link)                       │
│     field_blog_hero_background_image (image)                      │
│     field_blog_hero_theme            (list_string: dark | light)  │
└───────────────────────────┬───────────────────────────────────────┘
                            │ paragraph--blog-hero.html.twig (bridge)
                            │ maps fields → SDC props
                            ▼
┌───────────────────────────────────────────────────────────────────┐
│          SINGLE DIRECTORY COMPONENT  — sipd:blog-hero             │
│   Owns the UI only:                                               │
│     blog-hero.component.yml  — prop/slot contract                 │
│     blog-hero.twig           — markup                             │
│     blog-hero.css            — scoped styles                      │
└───────────────────────────────────────────────────────────────────┘
```

**Each layer has one job:**
- **Paragraphs** → content storage and editing UI
- **paragraph--blog-hero.html.twig** → data mapping (bridge)
- **Blog Hero SDC** → UI rendering (markup + styles)
- **Layout Builder** → page layout and placement

---

## File Listing

```
web/
└── themes/custom/sipd/
    ├── components/
    │   └── blog-hero/                             ← Single Directory Component
    │       ├── blog-hero.component.yml            ← SDC definition + prop schema
    │       ├── blog-hero.twig                     ← Component markup
    │       ├── blog-hero.css                      ← Scoped component styles
    │       └── README.md                          ← This file
    └── templates/
        └── paragraphs/
            └── paragraph--blog-hero.html.twig     ← Bridge: Paragraphs → SDC
```

---

## Props

| Prop                   | Type   | Required | Description                                      |
|------------------------|--------|----------|--------------------------------------------------|
| `title`                | string | Yes      | Main heading text displayed in the hero          |
| `date`                 | string | No       | Publication date (e.g. "October 23, 2025")       |
| `author`               | string | No       | Display name of the post author                  |
| `author_link`          | string | No       | URL the author name links to                     |
| `background_image_url` | string | No       | URL of the background image                      |
| `background_image_alt` | string | No       | Alt text for the background image (accessibility)|
| `theme`                | string | No       | Color scheme: `'light'` (default) or `'dark'`    |

---

## Expected Paragraph Fields

Field machine names on paragraph bundle `blog_hero`:

| Field label                | Machine name                       | Type                          |
|----------------------------|------------------------------------|-------------------------------|
| Blog Hero Title            | `field_blog_hero_title`            | Text (plain)                  |
| Blog Hero Date             | `field_blog_hero_date`             | Text (plain)                  |
| Blog Hero Author           | `field_blog_hero_author`           | Text (plain)                  |
| Blog Hero Author Link      | `field_blog_hero_author_link`      | Text (plain)                  |
| Blog Hero Background Image | `field_blog_hero_background_image` | Entity reference → Media      |
| Blog Hero Background Image Alt | `field_blog_hero_bg_img_alt`   | Text (plain)                  |

> **Background image note:** The bridge template accesses the image URL via `paragraph.field_blog_hero_background_image.entity.field_media_image.entity.uri.value`. The Media entity must reference an Image or Vector image media type with a `field_media_image` source field.

---

## CSS Custom Properties

Override these variables on the root element or via inline style to customize the appearance:

| Variable                    | Default                      | Description                    |
|-----------------------------|------------------------------|--------------------------------|
| `--blog-hero-text-color`    | `var(--clr-text-3)`          | Main text color                |
| `--blog-hero-title-font-size` | `2.5rem`                   | Title font size                |
| `--blog-hero-info-font-size`  | `1.4rem`                   | Date/author font size          |
| `--blog-hero-font-weight`   | `300`                        | Info text font weight          |
| `--blog-hero-height`        | `68vh`                       | Section height                 |
| `--blog-hero-overlay-color` | `rgba(255, 255, 255, 0.80)`  | Background image overlay color |

---

## Render Flow

1. Paragraph entity stores Blog Hero content values.
2. `paragraph--blog-hero.html.twig` reads those values.
3. Template includes `sipd:blog-hero` and passes props.
4. Blog Hero SDC renders only populated fields.

---

## Cache Rebuild

After changing template or component files:

```bash
drush cr
```

Validate the SDC is correctly registered:

```bash
drush sdc:validate sipd:blog-hero
```

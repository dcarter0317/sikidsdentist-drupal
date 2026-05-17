# Hero Component — Drupal SDC + Paragraphs + Layout Builder

## Architecture Overview

```
┌───────────────────────────────────────────────────────────────────┐
│                        LAYOUT BUILDER                             │
│   (arranges blocks/regions on a node; editor drags Hero block)    │
└───────────────────────────┬───────────────────────────────────────┘
                            │ renders a Block
                            ▼
┌───────────────────────────────────────────────────────────────────┐
│              PARAGRAPHS MODULE  — "hero" bundle                   │
│   Stores & provides content:                                      │
│     field_hero_headline          (string)                         │
│     field_hero_subheadline       (string)                         │
│     field_hero_body              (text_long)                      │
│     field_hero_cta               (link)                           │
│     field_hero_background_image  (image)                          │
│     field_hero_theme             (list_string: dark | light)      │
└───────────────────────────┬───────────────────────────────────────┘
                            │ paragraph--hero.html.twig (bridge)
                            │ maps fields → SDC props
                            ▼
┌───────────────────────────────────────────────────────────────────┐
│          SINGLE DIRECTORY COMPONENT  — mytheme:hero               │
│   Owns the UI only:                                               │
│     hero.component.yml  — prop/slot contract                      │
│     hero.twig           — markup                                  │
│     hero.css            — scoped styles                           │
└───────────────────────────────────────────────────────────────────┘
```

**Each layer has one job:**
- **Paragraphs** → content storage and editing UI
- **paragraph--hero.html.twig** → data mapping (bridge)
- **Hero SDC** → UI rendering (markup + styles)
- **Layout Builder** → page layout and placement

---

## File Listing

```
web/
├── themes/custom/mytheme/
│   ├── components/
│   │   └── hero/                          ← Single Directory Component
│   │       ├── hero.component.yml         ← SDC definition + prop schema
│   │       ├── hero.twig                  ← Component markup
│   │       └── hero.css                   ← Scoped component styles
│   └── templates/
│       └── paragraphs/
│           └── paragraph--hero.html.twig  ← Bridge: Paragraphs → SDC
│
└── modules/custom/hero_paragraph/
    ├── hero_paragraph.info.yml
    ├── hero_paragraph.module               ← theme suggestion hooks
    └── config/install/
        ├── paragraph.paragraph_type.hero.yml
        └── field.storage.paragraph.hero_fields.yml
```

---

## Step-by-Step Setup

### 1. Prerequisites — enable required modules

```bash
drush en paragraphs layout_builder layout_discovery \
         field_ui link image text options -y
```

### 2. Enable the custom module

```bash
drush en hero_paragraph -y
```

This imports the `hero` paragraph type and all field storage configs automatically via `config/install/`.

### 3. Add field instances via UI (or export config)

Go to **Structure → Paragraph types → Hero → Manage fields** and confirm these fields exist (the module created the storage; you may need to add instances for the `hero` bundle):

| Field label           | Machine name                    | Type        |
|-----------------------|---------------------------------|-------------|
| Headline              | field_hero_headline             | Text (plain)|
| Subheadline           | field_hero_subheadline          | Text (plain)|
| Body                  | field_hero_body                 | Text (long) |
| CTA                   | field_hero_cta                  | Link        |
| Background Image      | field_hero_background_image     | Image       |
| Theme                 | field_hero_theme                | List (text) |

### 4. Add a Paragraphs reference field to your content type

Go to **Structure → Content types → [Your Type] → Manage fields**, add a field:
- **Type**: Entity reference revisions (Paragraphs)
- **Machine name**: `field_content_paragraphs` (or your preference)
- **Allowed paragraph types**: check **Hero**

### 5. Enable Layout Builder for the content type

Go to **Structure → Content types → [Your Type] → Manage display**:
1. Check **Use Layout Builder**
2. Check **Allow each content item to have its own layout** (optional but recommended)
3. Save

### 6. Verify the SDC is discovered

```bash
drush cr
drush sdc:validate mytheme:hero
```

You should see no errors.

### 7. Place the Hero on a page

1. Edit a node of your content type
2. Click **Layout** tab
3. Click **Add block** in a region
4. Search for **Hero** (it appears as the Paragraph field block)
5. Configure and save

---

## Adding/Editing Hero Content

1. Edit the node → go to the **Content** tab (not Layout)
2. Find the Paragraphs field → click **Add Hero**
3. Fill in: Headline, Subheadline, Body, CTA, Background Image, Theme
4. Save the node

The Layout Builder then uses whatever paragraph content is stored — the SDC renders it automatically.

---

## Customising the Component

### Change the headline font
In `hero.css`, update:
```css
.hero {
  --hero-font-display: 'Your Font', serif;
}
```

### Add a new prop (e.g. `overlay_opacity`)
1. Add to `hero.component.yml` under `props.properties`
2. Use `{{ overlay_opacity|default(0.45) }}` in `hero.twig`
3. Add the field to the paragraph type
4. Map it in `paragraph--hero.html.twig`

### Override the SDC per-theme
Copy `components/hero/` into a sub-theme and Drupal's SDC resolution will prefer the sub-theme version.

---

## Drupal Version Compatibility

| Feature | Minimum version |
|---------|----------------|
| Single Directory Components (SDC) | Drupal 10.1+ |
| Layout Builder | Drupal 8.7+ |
| Paragraphs module | 8.x-1.x / 10.x compatible |

For Drupal < 10.1, SDC is available as the contributed module `drupal/sdc`.

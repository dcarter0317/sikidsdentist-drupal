# Staten Island Pediatric Dentistry — Drupal 11

Custom Drupal 11 site for Staten Island Pediatric Dentistry (SIPD). Built with the **sipd** custom theme, Single Directory Components (SDC), Paragraphs, and Layout Builder.

---

## Table of Contents

1. [Local Development](#local-development)
2. [Technology Stack](#technology-stack)
3. [Project Structure](#project-structure)
4. [Theme — sipd](#theme--sipd)
   - [Design Tokens](#design-tokens)
   - [Global Libraries](#global-libraries)
   - [Template Directories](#template-directories)
5. [Single Directory Components (SDC)](#single-directory-components-sdc)
   - [Component Architecture](#component-architecture)
   - [Component Inventory](#component-inventory)
   - [Parent / Child Components](#parent--child-components)
   - [Adding a New Component](#adding-a-new-component)
6. [Paragraphs & Bridge Templates](#paragraphs--bridge-templates)
   - [How the Render Chain Works](#how-the-render-chain-works)
   - [Paragraph Bundle Map](#paragraph-bundle-map)
7. [Custom Modules](#custom-modules)
8. [Configuration Management](#configuration-management)
9. [Common Drush Commands](#common-drush-commands)

---

## Local Development

This project uses [DDEV](https://ddev.readthedocs.io/) for local development.

**Requirements**
- Docker Desktop
- DDEV ≥ 1.23
- PHP 8.4 (managed by DDEV)
- Composer 2 (managed by DDEV)

**Start the project**

```bash
ddev start
ddev composer install
ddev drush site:install --existing-config -y
ddev drush cr
```

**Access the site**

| URL | Purpose |
|---|---|
| `https://sikidsdentist-drupal.ddev.site` | Front end |
| `https://sikidsdentist-drupal.ddev.site/admin` | Drupal admin |

**Live reload (CSS / JS / Twig)**

```bash
cd web/themes/custom/sipd
npm install
npm run livereload
```

**Stop / restart**

```bash
ddev stop
ddev restart
```

---

## Technology Stack

| Layer | Technology |
|---|---|
| CMS | Drupal 11 |
| PHP | 8.4 |
| Database | MariaDB 11.8 |
| Web server | nginx-fpm (via DDEV) |
| Component system | Drupal Single Directory Components (SDC) |
| Content modeling | Paragraphs + Layout Builder |
| Slider | Splide.js 4.1.4 (CDN) |
| Icons | Font Awesome 6.5.0 (CDN) |
| Fonts | Noto Sans JP, Poppins (Google Fonts) |
| Local dev | DDEV |

---

## Project Structure

```
sikidsdentist-drupal/
├── composer.json               # Drupal project dependencies
├── config/
│   └── sync/                   # Exported site configuration (commit this)
├── web/
│   ├── modules/
│   │   └── custom/             # Custom paragraph wrapper modules
│   └── themes/
│       └── custom/
│           └── sipd/           # The active custom theme
│               ├── assets/imgs/            # Static image assets
│               ├── components/             # SDC components (one dir per component)
│               ├── css/
│               │   └── sipd.css            # Global styles and design tokens
│               ├── js/
│               │   └── sipd.js             # Global JS (Splide init, etc.)
│               ├── templates/
│               │   ├── block/              # Block templates
│               │   ├── content/            # Node templates
│               │   ├── layout/             # Header, footer, menu templates
│               │   ├── page/               # Page-level templates
│               │   └── paragraphs/         # Paragraph bridge templates
│               ├── sipd.info.yml
│               ├── sipd.libraries.yml
│               └── sipd.theme
```

---

## Theme — sipd

The `sipd` theme (`web/themes/custom/sipd/`) is a fully custom Drupal 11 theme based on `stable9`. It owns all markup, styling, and component logic.

### Design Tokens

All design tokens are defined as CSS custom properties in [css/sipd.css](web/themes/custom/sipd/css/sipd.css) and are available globally to every component.

**Color palette**

| Token | Value | Usage |
|---|---|---|
| `--clr-primary` | `#1478A3` | Primary brand blue |
| `--clr-secondary` | `#00334F` | Dark navy |
| `--clr-accent` | `hsl(175,54%,48%)` | Teal accent |
| `--clr-bg-1` | `#ffffff` | Page background |
| `--clr-bg-3` | `#00334F` | Dark section background |
| `--clr-bg-4` | `#39BDB3` | Teal section background |
| `--clr-text-1` | `#333333` | Body text |
| `--clr-text-3` | `#00334F` | Heading text |
| `--clr-text-6` | `#1478A3` | Link / author color |
| `--clr-text-7` | `#89BBD1` | Muted link color |
| `--clr-text-8` | (inherited) | Category label color |

**Typography**

| Token | Value |
|---|---|
| `--ff-body` | `'Noto Sans JP', Arial, Helvetica, sans-serif` |
| `--ff-heading` | `'Poppins', Arial, Helvetica, sans-serif` |
| `--fw-bold` | `700` |
| `--fw-med` | `500` |
| `--fw-light` | `300` |
| `--fs-h1` – `--fs-h6` | `2.4rem` → `0.9rem` |

### Global Libraries

Defined in [sipd.libraries.yml](web/themes/custom/sipd/sipd.libraries.yml) and attached globally via `sipd.info.yml`.

| Asset | Source |
|---|---|
| `sipd.css` | Local — design tokens + global styles |
| `sipd.js` | Local — Splide carousel init |
| Splide.js 4.1.4 | CDN (deferred) |
| Splide CSS | CDN |
| Noto Sans JP | Google Fonts |
| Poppins | Google Fonts |
| Font Awesome 6.5.0 | CDN |

### Template Directories

| Directory | Contains |
|---|---|
| `templates/layout/` | `header.html.twig`, `footer.html.twig`, `main-section.html.twig`, `menu--main.html.twig` |
| `templates/page/` | `page--front.html.twig` |
| `templates/content/` | `node.html.twig`, `node--page.html.twig` |
| `templates/block/` | Block-level overrides for icon link and card blocks |
| `templates/paragraphs/` | Bridge templates — one per paragraph bundle |

---

## Single Directory Components (SDC)

### Component Architecture

Each component lives in its own directory under `web/themes/custom/sipd/components/` and follows the Drupal SDC convention:

```
components/
└── component-name/
    ├── component-name.component.yml   # Prop contract, variants, metadata
    ├── component-name.twig            # Markup
    ├── component-name.css             # Scoped styles
    └── README.md                      # Field map and usage notes
```

Components are registered under the `sipd` namespace in `sipd.info.yml`:

```yaml
components:
  namespaces:
    sipd:
      - components
```

They are included from bridge templates using:

```twig
{% include "sipd:component-name" with { prop: value } only %}
```

### Component Inventory

| Component | SDC ID | Description |
|---|---|---|
| [Hero](web/themes/custom/sipd/components/hero/) | `sipd:hero` | Full-width hero with headline, subheadline, body, CTA, background image, and color theme |
| [Blog Hero](web/themes/custom/sipd/components/blog-hero/) | `sipd:blog-hero` | Full-width blog post hero with title, date, author, and background image |
| [Banner](web/themes/custom/sipd/components/banner/) | `sipd:banner` | Full-width banner in three variants: default, button-banner, cta-banner |
| [Featured Post](web/themes/custom/sipd/components/featured-post/) | `sipd:featured-post` | Blog post card with image, eyebrow, title, description, and CTA. Featured variant adds subtitle, category, and author |
| [Card](web/themes/custom/sipd/components/card/) | `sipd:card` | Reusable card with image, eyebrow, title, description, and CTA. Supports text-alignment and wide variants |
| [Card List](web/themes/custom/sipd/components/card-list/) | `sipd:card-list` | Grid container for nested Card Item paragraphs. 2/3/4-column variants |
| [Accordion Item](web/themes/custom/sipd/components/accordion-item/) | `sipd:accordion-item` | Single `<details>`/`<summary>` expandable item |
| [Accordion List](web/themes/custom/sipd/components/accordion-list/) | `sipd:accordion-list` | Grid layout for nested Accordion Item paragraphs. 1/2/3/4-column variants |
| [Grid Item](web/themes/custom/sipd/components/grid-item/) | `sipd:grid-item` | Single heading + rich text cell for use inside a Grid Container |
| [Grid Container](web/themes/custom/sipd/components/grid-container/) | `sipd:grid-container` | CSS Grid layout wrapper for nested Grid Item paragraphs. Auto/2/3/4/5/6-column variants |
| [Slider](web/themes/custom/sipd/components/slider/) | `sipd:slider` | Splide.js carousel. Accepts nested Slide Item paragraphs as rendered slide content |
| [Icon Link](web/themes/custom/sipd/components/icon-link/) | `sipd:icon-link` | Circular icon + bordered text label link block |

### Parent / Child Components

Three components act as layout containers for nested paragraph items:

| Parent | Child | Relationship |
|---|---|---|
| `sipd:card-list` | `sipd:card` (via `card_item` bundle) | Card list renders nested Card Item paragraphs |
| `sipd:accordion-list` | `sipd:accordion-item` | Accordion list renders nested Accordion Item paragraphs |
| `sipd:grid-container` | `sipd:grid-item` | Grid container renders nested Grid Item paragraphs |

The parent bridge templates use `getFieldDefinitions()` to auto-detect the `entity_reference_revisions` field that holds the child items, then pass the rendered output as a `items` slot to the parent SDC.

### Adding a New Component

1. Create the component directory:
   ```
   web/themes/custom/sipd/components/my-component/
   ```

2. Add the four required files:
   - `my-component.component.yml` — name, props, variants
   - `my-component.twig` — markup using `{{ prop_name }}`
   - `my-component.css` — scoped styles using `--design-token` variables
   - `README.md` — paragraph field map and usage notes

3. Create the bridge template:
   ```
   web/themes/custom/sipd/templates/paragraphs/paragraph--my_bundle.html.twig
   ```

4. Map paragraph fields to SDC props and include:
   ```twig
   {% include "sipd:my-component" with { prop: value } only %}
   ```

5. Clear the cache:
   ```bash
   ddev drush cr
   ```

---

## Paragraphs & Bridge Templates

### How the Render Chain Works

```
Editor creates content
        │
        ▼
Paragraph entity (stored in DB)
        │
        ▼
paragraph--{bundle}.html.twig   ← bridge template reads raw field values
        │
        ▼
sipd:{component}                ← SDC renders typed props into markup
        │
        ▼
Browser
```

Bridge templates live in `templates/paragraphs/` and follow strict conventions:
- All variables are initialized to `null` at the top
- Each field is read from the `paragraph` entity using safe checks (`is defined and not isEmpty`)
- Media entity references are traversed: `paragraph.field_*.entity.field_media_image.entity.uri.value|file_url`
- Only whitelisted props are passed to the SDC using `only`

### Paragraph Bundle Map

| Paragraph Bundle | Bridge Template | SDC Component | Module |
|---|---|---|---|
| `hero` | `paragraph--hero.html.twig` | `sipd:hero` | `hero_paragraph` |
| `blog_hero` | `paragraph--blog-hero.html.twig` | `sipd:blog-hero` | `blog_hero_paragraph` |
| `banner` | `paragraph--banner.html.twig` | `sipd:banner` | `banner_paragraph` |
| `featured_post` | `paragraph--featured-post.html.twig` | `sipd:featured-post` | `featured_post_paragraph` |
| `card` | `paragraph--card.html.twig` | `sipd:card` | `card_paragraph` |
| `card_item` | `paragraph--card-item.html.twig` | `sipd:card` | `card_paragraph` |
| `card_list` | `paragraph--card-list.html.twig` | `sipd:card-list` | `card_list_paragraph` |
| `accordion_item` | `paragraph--accordion-item.html.twig` | `sipd:accordion-item` | `accordion_item_paragraph` |
| `accordion_list` | `paragraph--accordion-list.html.twig` | `sipd:accordion-list` | `accordion_list_paragraph` |
| `grid_item` | `paragraph--grid-item.html.twig` | `sipd:grid-item` | `grid_item_paragraph` |
| `grid_container` | `paragraph--grid-container.html.twig` | `sipd:grid-container` | `grid_container_paragraph` |

---

## Custom Modules

All custom modules live in `web/modules/custom/`. Each is a lightweight wrapper that declares the `paragraphs` or `block_content` module as a dependency. Paragraph/block types and field storage are managed via Drupal's active configuration (not via `config/install`), so modules contain only `info.yml` and `.module`.

| Module | Machine Name | Purpose |
|---|---|---|
| Hero Paragraph | `hero_paragraph` | Declares dependency for the `hero` paragraph type |
| Blog Hero Paragraph | `blog_hero_paragraph` | Declares dependency for the `blog_hero` paragraph type |
| Banner Paragraph | `banner_paragraph` | Declares dependency for the `banner` paragraph type |
| Featured Post Paragraph | `featured_post_paragraph` | Declares dependency for the `featured_post` paragraph type |
| Card Paragraph | `card_paragraph` | Declares dependency for the `card` and `card_item` paragraph types |
| Card List Paragraph | `card_list_paragraph` | Declares dependency for the `card_list` paragraph type |
| Accordion Item Paragraph | `accordion_item_paragraph` | Declares dependency for the `accordion_item` paragraph type |
| Accordion List Paragraph | `accordion_list_paragraph` | Declares dependency for the `accordion_list` paragraph type |
| Grid Item Paragraph | `grid_item_paragraph` | Declares dependency for the `grid_item` paragraph type |
| Grid Container Paragraph | `grid_container_paragraph` | Declares dependency for the `grid_container` paragraph type |
| Icon Link Block | `icon_link_block` | Declares dependency for the `icon_link` block type |

> **Note:** Paragraph and block type configurations (field storage, field instances, display modes) live in `config/sync/` and are managed via `drush cex` / `drush cim`. Do not add `config/install` to these modules — it will conflict with the active configuration.

---

## Configuration Management

Site configuration is exported to `config/sync/` and committed to version control. This is the source of truth for deploying to any environment.

**Workflow**

```bash
# After making any configuration change in the Drupal UI:
ddev drush cex
git add config/sync
git commit -m "Export config: describe what changed"

# On another environment (staging, production):
ddev drush cim -y
ddev drush cr
```

**What lives in config/sync**

- All paragraph type definitions (`paragraphs.paragraphs_type.*.yml`)
- All field storage and field instance configs
- Display modes, view modes, form displays
- Layout Builder layouts
- Block placements, menus, image styles
- Any other Drupal configuration changed via the admin UI

**What does NOT live in config/sync**

- Content (nodes, paragraphs, media entities) — use the migrate or content sync module
- User accounts
- Files uploaded through the site

---

## Common Drush Commands

```bash
# Clear all caches
ddev drush cr

# Export active configuration to config/sync
ddev drush cex

# Import configuration from config/sync into the database
ddev drush cim -y

# Enable a module
ddev drush en module_name

# Uninstall a module
ddev drush pmu module_name

# Run database updates after a core/module update
ddev drush updb -y

# View the status of configuration (what differs between DB and sync/)
ddev drush config:status

# One-time login link
ddev drush uli
```

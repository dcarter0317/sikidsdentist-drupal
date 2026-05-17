# Slider Component

Full-width carousel built with [Splide.js](https://splidejs.com/). Wraps nested Slide Item paragraphs and initializes the carousel via `sipd.js`.

Splide CSS/JS is loaded through the theme's global library (`sipd.libraries.yml`) — no additional library attachment is needed.

## Fields (Props)

| Field | Type | Required | Default | Description |
|---|---|---|---|---|
| `aria_label` | string | **Yes** | — | Accessible label for the carousel region, e.g. `"Office tour photos"` |
| `slider_type` | string | No | `loop` | Splide transition: `loop`, `fade`, or `slide` |
| `autoplay` | boolean | No | `true` | Whether slides advance automatically |
| `interval` | integer | No | `7000` | Milliseconds between auto-advances |

## Slot

| Slot | Description |
|---|---|
| `slides` | Rendered `<li class="splide__slide">` items from nested Slide Item paragraphs |

Each slide item in the slot can be either an **image slide** or a **text-content slide**.

### Image slide markup (from Slide Item paragraph template)

```twig
<li class="splide__slide">
  <img src="{{ image_url }}" alt="{{ image_alt }}">
</li>
```

### Text-content slide markup

```twig
<li class="splide__slide">
  <div class="splide__content text-content [content-center|content-right]">
    <h2>{{ heading }}</h2>
    <p>{{ body }}</p>
    <a href="{{ cta_url }}">{{ cta_label }}</a>
  </div>
</li>
```

Content alignment is controlled by adding a modifier class to `.splide__content`:
- *(none)* — left-aligned (default)
- `content-center` — centered
- `content-right` — right-aligned

## Twig usage example

```twig
{% component 'sipd:slider' with {
  aria_label: 'Office tour',
  slider_type: 'loop',
  autoplay: true,
  interval: 8000,
} %}
  {% block slides %}
    {# rendered Slide Item paragraph items #}
    {{ items }}
  {% endblock %}
{% endcomponent %}
```

## Paragraphs setup

1. Create a **Slider** paragraph bundle with fields mapping to the props above.
2. Create a **Slide Item** paragraph bundle (image field + optional text fields).
3. Add an entity reference revisions field on the Slider paragraph pointing to Slide Item.
4. In the Slide Item paragraph template (`paragraph--slide-item.html.twig`), output the `<li class="splide__slide">` wrapper and pass the rendered items into the `slides` slot.

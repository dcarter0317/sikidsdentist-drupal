# Image Link Component

A modern, highly visual link component featuring a background image, a brand-colored overlay, and centered typography. Perfect for service pages, service category highlights, or feature call-to-actions.

## Features
- **Visual-first Layout**: Full-size background image with support for custom aspect ratios (defaults to a sleek `21:9` wide ratio).
- **Dynamic Interactions**: Features a smooth scale transition on the background image and a subtle hover scaling on the central text.
- **Hover-activated Overlay**: A semi-transparent brand-colored overlay (`--clr-secondary` based) that darkens seamlessly on hover to improve text contrast and visual feedback.
- **Fluid Typography**: Uses CSS `clamp()` for automatically scaling typography that looks flawless from mobile devices to desktop monitors.
- **Fully Semantic & Accessible**: Wraps the entire block in a single anchor (`<a>`) tag so the entire element is interactive and properly interpreted by screen readers.

## Usage in Twig Templates

Include the component in your Twig templates using the standard Drupal SDC include syntax:

```twig
{% include 'sipd:image-link' with {
  url: '/services/custom-sports-mouthguard',
  text: 'Custom Sports Mouthguard',
  image: '/sites/default/files/mouthguard.jpg',
  image_alt: 'Custom Sports Mouthguard'
} only %}
```

## Properties (Props)

- **url** (string): The link destination URL.
- **text** (string): The text displayed on top of the background image overlay.
- **image** (string): The URL path to the background image.
- **image_alt** (string): Alternative text for accessibility.
- **bg_color** (string): Overlay background color (hex format).
- **bg_opacity** (string): Overlay background opacity (0 to 1).

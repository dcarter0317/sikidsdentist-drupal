# Profile Card Component

A premium, modern, and interactive **Profile Card** component built for the **SI Kids Dentist** website. Designed to showcase clinicians and team members with clear typographic hierarchy, structured bio copy, and an engaging Call-to-Action (CTA).

---

## 📸 Component Preview

![Component Preview](thumbnail.png)

---

## ✨ Features

- **Semantic HTML5:** Built using standard `<article>` elements to maximize accessibility and SEO.
- **Micro-Animations:** Implements card hover-lift translations (`translateY(-6px)`) with realistic box-shadow expansions and CTA button transitions.
- **Centered Image Headshot:** Optimizes headshots with responsive aspect ratios, rounded borders (`border-radius: 12px`), and soft container drop shadows.
- **Brand Typography:** Built directly on top of variables defined in the repository's main `reset.css` (using `Poppins` and `Noto Sans JP`).
- **Flexible Theme Engine:** Operates entirely through CSS Custom Properties, making style changes quick and modular.

---

## 📂 File Structure

```text
profile-card/
├── profile-card.html   # Component structure and layout wrapper markup
├── css/
│   └── profile-card.css # Component styles, hover mechanisms, and media queries
└── thumbnail.png       # Component design mockup preview
```

---

## 🛠️ Usage & Integration

To integrate the `Profile Card` component into your application:

### 1. Link Fonts and Core Files
Add Google Fonts and FontAwesome library inside the `<head>` tag of your page:

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;200;300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
```

### 2. Stylesheet Imports
Import the primary `reset.css` stylesheet and the card stylesheet:

```html
<link rel="stylesheet" href="../reset.css">
<link rel="stylesheet" href="css/profile-card.css">
```

### 3. Insert HTML Markups
Use the following structured snippet to insert the clinician cards:

```html
<article class="profile-card">
    <div class="profile-card__image-container">
        <!-- Relative or absolute path to doctor headshot -->
        <img class="profile-card__image" src="../assets/imgs/medium_michelle_headshot.jpg" alt="Dr. Michelle Flanigan">
    </div>
    <div class="profile-card__content">
        <h2 class="profile-card__name">Dr. Michelle<br>Flanigan</h2>
        <div class="profile-card__divider"></div>
        <p class="profile-card__bio">
            Dr. Michelle started her education at the University of Medicine and Dentistry of New Jersey, New Jersey Dental School, now known as Rutgers School of Dental Medicine. She then completed ...
        </p>
    </div>
    <div class="profile-card__footer">
        <a href="#" role="button" class="profile-card__btn">Read More</a>
    </div>
</article>
```

---

## 🎨 Design Customization

The component uses scoped CSS Custom Properties under the `.profile-card` selector. Simply override these variables to adapt the component's appearance to fit alternate pages or themes:

```css
.profile-card {
  /* Layout Sizing */
  max-width: 400px;
  
  /* Color Customizations */
  --profile-card-bg: #ffffff;
  --profile-card-name-color: #00334F;
  --profile-card-text-color: #414549;
  --profile-card-divider-color: #39BDB3;
  --profile-card-footer-bg: hsl(175, 54%, 93%);
  
  /* Button Specific Overrides */
  --profile-card-btn-bg: #00334F;
  --profile-card-btn-text: #ffffff;
  --profile-card-btn-hover-bg: transparent;
  --profile-card-btn-hover-text: #00334F;
  --profile-card-btn-hover-border: #00334F;
}
```

### ⚙️ Local Design Tokens Reference

| CSS Custom Property | Default Value | Description |
| :--- | :--- | :--- |
| `--profile-card-bg` | `var(--clr-bg-1)` | Background color of the profile card. |
| `--profile-card-name-color` | `var(--clr-text-3)` | Text color of the clinician's name. |
| `--profile-card-text-color` | `var(--clr-text-5)` | Font color of the main body paragraph description. |
| `--profile-card-divider-color` | `var(--clr-bg-4)` | Background color of the short horizontal divider block. |
| `--profile-card-footer-bg` | `hsl(175, 54%, 93%)` | Muted background color of the footer section. |
| `--profile-card-btn-bg` | `var(--clr-bg-3)` | CTA Button rest background. |
| `--profile-card-btn-text` | `var(--clr-text-light)` | CTA Button rest text color. |
| `--profile-card-btn-hover-bg` | `transparent` | CTA Button hover background. |
| `--profile-card-btn-hover-text` | `var(--clr-text-3)` | CTA Button hover text color. |
| `--profile-card-btn-hover-border` | `var(--clr-bg-3)` | CTA Button hover border color. |

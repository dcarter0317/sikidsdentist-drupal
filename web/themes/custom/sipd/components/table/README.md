# Table Component - Drupal SDC

## Purpose

A clean, responsive, and highly readable table component for structured data presentation: feature comparisons, pricing and plan breakdowns, service/treatment matrices, and other data-heavy content blocks.

This component uses Single Directory Components (SDC) for markup, CSS, and metadata, and leverages the theme's shared design tokens (`--clr-bg-1`, `--clr-text-3`, `--clr-text-5`, `--ff-body`, `--fw-bold`, `--fw-med`) so it stays visually consistent with the rest of the design system.

## Files

- `table.component.yml` - SDC metadata and prop contract.
- `table.twig` - Table markup.
- `table.css` - Table styles.
- `templates/paragraphs/paragraph--table.html.twig` - Bridge template mapping "table" paragraph fields to Table SDC props.

## Props

- `caption` (string, optional) - Caption describing the table content.
- `headers` (array of strings, optional) - Column headings rendered in `<thead>`.
- `rows` (array of objects, optional) - Table rows. Each row supports:
  - `heading` (string, optional) - Row heading rendered as `<th scope="row">`.
  - `cells` (array of strings) - Cell values rendered as `<td>`.
- `variant_class` (string, optional) - Table-level alignment modifier: `align-left`, `align-center`, or `align-right`.
- `dark_mode` (boolean, optional, default `false`) - Renders the table using the site's dark mode color pattern (same approach as the Text Block and Floated Content components).
- `vertical_borders` (boolean, optional, default `false`) - Adds vertical borders between columns.
- `outer_border` (boolean, optional, default `false`) - Adds a border around the outside of the whole table.
- `bg_color` (string, optional) - HEX color for the overall table background.
- `header_bg_color` (string, optional) - HEX color for the `<thead>` row background.
- `row_bg_color` (string, optional) - HEX color applied behind each row, including row heading (`<th scope="row">`) cells.
- `col_bg_color` (string, optional) - HEX color applied to each data cell (`<td>`), effectively coloring the columns.
- `mobile_layout` (string, optional, default `scroll`) - How the table behaves on narrow screens. One of:
  - `scroll` - Keeps the table shape and scrolls horizontally (see [Mobile responsiveness](#mobile-responsiveness) below).
  - `stacked` - Turns each row into a labeled card; best for long tables with few columns.

Any of the four color props can be set independently of `dark_mode` — they override the light/dark defaults either way. When `dark_mode` is `true` and a color prop is left empty, its dark default is used instead.

## Example usage

```twig
{% include 'sipd:table' with {
  caption: 'Whitening Options Comparison',
  headers: ['Treatment', 'Benefits', 'Duration', 'Cost'],
  rows: [
    { heading: 'Whitening Kit', cells: ['Convenient at-home use', '2 weeks', '$149'] },
    { heading: 'In-Office Whitening', cells: ['Fast results under supervision', '1 session', '$399'] },
  ],
  variant_class: 'align-left',
  dark_mode: false,
  bg_color: '#ffffff',
  header_bg_color: '#f3f4f6',
  row_bg_color: '#fafafa',
  col_bg_color: '',
  mobile_layout: 'stacked',
} only %}
```

## Paragraph fields (Table)

The "Table" paragraph type exposes these color/appearance fields, each editable via the Color Field module's native color-picker widget, which also accepts a manually typed HEX value:

- `field_table_dark_mode` (boolean) - Dark mode toggle.
- `field_table_bg_color` (color) - Table background color.
- `field_table_header_bg_color` (color) - Table header background color.
- `field_table_row_bg_color` (color) - Row background color.
- `field_table_col_bg_color` (color) - Column background color.
- `field_table_mobile_layout` (list, select) - `Horizontal scroll` (default) or `Stacked cards`. See [Mobile responsiveness](#mobile-responsiveness).

## Features

- Semantic table markup using `table`, `thead`, `tbody`, `th`, and `td`.
- Consistent spacing, borders, and typography across rows and columns.
- Table-level text alignment via the `align-left` / `align-center` / `align-right` variant classes on `.table-comp`; the same classes can be applied to an individual `th`/`td` to override the table-level default.
- Accessible structure with `scope="col"` on column headers and `scope="row"` on row headers.

## Mobile responsiveness

The component supports two mobile strategies, chosen per-instance via `mobile_layout` (`field_table_mobile_layout` on the paragraph):

### `scroll` (default)

- The `.table-wrap` wrapper uses `overflow-x: auto`, and below 768px each `th`/`td` gets a `min-width` (140px) so columns keep a legible size instead of being crushed to fit — this is what makes the table actually scroll horizontally rather than just squeezing text.
- The `<caption>` is pinned to the left edge of the scroll container (`position: sticky; left: 0`) and left-aligned, so it stays fully readable at rest instead of being centered over the full (now wider-than-viewport) table and running off-screen.
- A scroll-shadow affordance fades in on whichever edge still has hidden content (pure CSS, no JS), so it's visually obvious the table can be scrolled sideways; it fades out once you've scrolled all the way to that edge.
- The scrollable wrapper is exposed as a focusable region (`role="region"`, `tabindex="0"`, `aria-label`) so keyboard-only users can scroll it (WCAG 1.4.10 / 2.1.1); it gets a visible focus outline via `:focus-visible`.
- `-webkit-overflow-scrolling: touch` gives momentum scrolling on iOS; smooth scrolling is applied only when `prefers-reduced-motion: no-preference`.

**Not a sticky first column.** A sticky column was tried and removed: browsers paint table cell backgrounds outside normal z-index stacking, so a `position: sticky` `<td>`/`<th>` doesn't reliably cover the cells scrolling underneath it — neighboring column text visibly bled through during testing. This is a known cross-browser rough edge with sticky *table cells* specifically (as opposed to sticky on non-cell elements, like the caption above, which works fine). A reliable frozen column would need a duplicated mini-table overlay (the approach grid libraries like AG Grid/DataTables use), which is more machinery than this component takes on — use `stacked` layout instead if row identity needs to stay visible without scrolling.

### `stacked`

- Below 640px, the `<thead>` is visually hidden (but still in the DOM for screen readers) and each `<tr>` becomes a bordered, rounded card.
- Each `<td>` renders as a `label: value` row via `content: attr(data-label)`, where the label comes from the matching column heading — no horizontal scrolling needed.
- Best suited to tables with few columns and many rows (pricing plans, spec sheets) where a card-per-row reads more naturally on a phone than a scrolling table.

## Accessibility Considerations

- Uses semantic table structure instead of layout tables.
- Applies `scope="col"` to column headers and `scope="row"` to row headers.
- Maintains strong text contrast using the theme's color variables.
- Supports keyboard navigation through standard table behavior, including keyboard access to the horizontally scrollable region on mobile.
- The stacked mobile layout hides the header row visually only (not with `display: none`), so screen reader users retain header context via `scope="col"`.

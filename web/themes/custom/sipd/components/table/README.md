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
- `bg_color` (string, optional) - HEX color for the overall table background.
- `header_bg_color` (string, optional) - HEX color for the `<thead>` row background.
- `row_bg_color` (string, optional) - HEX color applied behind each row, including row heading (`<th scope="row">`) cells.
- `col_bg_color` (string, optional) - HEX color applied to each data cell (`<td>`), effectively coloring the columns.

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
} only %}
```

## Paragraph fields (Table)

The "Table" paragraph type exposes these color/appearance fields, each editable via the Color Field module's native color-picker widget, which also accepts a manually typed HEX value:

- `field_table_dark_mode` (boolean) - Dark mode toggle.
- `field_table_bg_color` (color) - Table background color.
- `field_table_header_bg_color` (color) - Table header background color.
- `field_table_row_bg_color` (color) - Row background color.
- `field_table_col_bg_color` (color) - Column background color.

## Features

- Semantic table markup using `table`, `thead`, `tbody`, `th`, and `td`.
- Responsive horizontal scrolling via a `.table-wrap` wrapper (`overflow-x: auto`).
- Consistent spacing, borders, and typography across rows and columns.
- Table-level text alignment via the `align-left` / `align-center` / `align-right` variant classes on `.table-comp`; the same classes can be applied to an individual `th`/`td` to override the table-level default.
- Accessible structure with `scope="col"` on column headers and `scope="row"` on row headers.
- Reduced padding and font size on screens narrower than 768px.

## Accessibility Considerations

- Uses semantic table structure instead of layout tables.
- Applies `scope="col"` to column headers and `scope="row"` to row headers.
- Maintains strong text contrast using the theme's color variables.
- Supports keyboard navigation through standard table behavior.

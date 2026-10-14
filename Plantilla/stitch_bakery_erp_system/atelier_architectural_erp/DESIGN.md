---
name: Atelier Architectural ERP
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#45464d'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#76777d'
  outline-variant: '#c6c6cd'
  surface-tint: '#565e74'
  primary: '#000000'
  on-primary: '#ffffff'
  primary-container: '#131b2e'
  on-primary-container: '#7c839b'
  inverse-primary: '#bec6e0'
  secondary: '#9b4500'
  on-secondary: '#ffffff'
  secondary-container: '#fd8a42'
  on-secondary-container: '#682c00'
  tertiary: '#000000'
  on-tertiary: '#ffffff'
  tertiary-container: '#002115'
  on-tertiary-container: '#339471'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dae2fd'
  primary-fixed-dim: '#bec6e0'
  on-primary-fixed: '#131b2e'
  on-primary-fixed-variant: '#3f465c'
  secondary-fixed: '#ffdbca'
  secondary-fixed-dim: '#ffb68e'
  on-secondary-fixed: '#331200'
  on-secondary-fixed-variant: '#763300'
  tertiary-fixed: '#97f5cc'
  tertiary-fixed-dim: '#7bd8b1'
  on-tertiary-fixed: '#002115'
  on-tertiary-fixed-variant: '#00513a'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-xl:
    fontFamily: Inter
    fontSize: 36px
    fontWeight: '600'
    lineHeight: 44px
    letterSpacing: -0.02em
  headline-xl-mobile:
    fontFamily: Inter
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
    letterSpacing: -0.01em
  headline-lg:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 26px
    letterSpacing: -0.005em
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  body-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 18px
  mono-metric-lg:
    fontFamily: JetBrains Mono
    fontSize: 28px
    fontWeight: '500'
    lineHeight: 34px
    letterSpacing: -0.03em
  mono-metric-md:
    fontFamily: JetBrains Mono
    fontSize: 16px
    fontWeight: '500'
    lineHeight: 22px
    letterSpacing: -0.02em
  mono-table:
    fontFamily: JetBrains Mono
    fontSize: 13px
    fontWeight: '400'
    lineHeight: 18px
    letterSpacing: 0em
  label-caps:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.06em
spacing:
  gutter: 1rem
  gutter-desktop: 1.5rem
  margin: 1rem
  margin-desktop: 2rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.5rem
---

## Brand & Style

This design system establishes an architectural, uncompromising, and sober visual language tailored for high-end bakeries, artisanal flour ateliers, and enterprise bakery logistics. It rejects playful or superficial SaaS tropes—eliminating glassmorphism, floating decorative badges, blur layers, and organic pill shapes entirely.

Instead, the identity embraces an aesthetic rooted in structural discipline, precision ledger drafting, and tactile culinary engineering. The visual tone evokes high-standard culinary ateliers: raw flour, cast iron ovens, metric-driven fermentation tracking, and executive ledger rigor. Surfaces are strictly opaque, solid, and planar. Structural lines communicate order, reliability, and master craftsmanship.

## Colors

The system uses two dedicated operational modes governed by pure solid color fills and razor-sharp border demarcations.

### Operational Mode (Default / Light)
- **Primary Canvas (`bg-slate-50`)**: `#f8fafc` — Solid workshop foundation.
- **Surface Layer (`bg-white`)**: `#ffffff` — Opaque white cards, tables, and inspection panes.
- **Borders & Dividers (`border-slate-200`)**: `#e2e8f0` — Crisp, structural boundaries.
- **Primary Text (`text-slate-900`)**: `#0f172a` — Deep slate-black for high legibility under bakery floor lighting.
- **Muted Text (`text-slate-500`)**: `#64748b` — Formula captions, units, and structural metadata.
- **Primary Solid Accent (`bg-slate-900`)**: `#0f172a` — Authoritative action states and navigation bars.
- **Thermal & Crust Accent (`bg-amber-700`)**: `#b45309` — Oven staging, fermentation milestones, and alert indicators.

### Executive VIP Mode (Dark)
- **Canvas Base (`bg-zinc-950`)**: `#09090b` — Deep matte black.
- **Card Surface (`bg-zinc-900`)**: `#18181b` — Solid structural panels.
- **Subtle Surface (`bg-zinc-800`)**: `#27272a` — Active table headers and toolbars.
- **Structural Borders (`border-zinc-800`)**: `#27272a` — Restrained contrast dividers.
- **Primary Typography (`text-zinc-100`)**: `#f4f4f5` — High-clarity white.
- **Muted Typography (`text-zinc-400`)**: `#a1a1aa` — Operational metadata.
- **Atelier Gold Accent (`bg-amber-600`)**: `#d97706` — VIP indicators, batch yield premiums, and financial KPIs.
- **Atelier Emerald Accent (`bg-emerald-700`)**: `#047857` — Positive margin variance and verified batch yields.

## Typography

Typography prioritizes legibility and technical rigor. Titles must be clean and unadorned: never prepend floating capsule badges, chips, or decorative eyebrow tags above primary section headings.

- **Primary Typeface**: `Inter` handles all functional user interface layers, form fields, headers, and documentation.
- **Monospaced Numerical System**: `JetBrains Mono` governs all numerical weights, oven hydration ratios (e.g., `78.5%`), temperature setpoints (`245°C`), fermentation timers, SKUs, inventory tallies, and executive financial ledgers.
- **Numeric Alignment**: All tables displaying quantitative or currency metrics must enforce tabular lining figures (`font-variant-numeric: tabular-nums`) to preserve column alignment across batch tables.

## Layout & Spacing

Layouts follow an architectural 12-column grid system built on strict 4px and 8px rhythmic increments. Density is balanced to permit rapid scanning on workshop industrial screens, tablets, and executive viewports.

### Breakpoints & Adaptive Reflow
- **Mobile (`< 768px`)**: Single-column or 2-column stacked operational flow. Margins: `1rem` (`16px`). Gaps: `0.75rem` (`12px`).
- **Tablet / Workshop Floor (`768px - 1199px`)**: 6-column fluid structure. Outer margins: `1.5rem` (`24px`). Ledger tables allow horizontal scroll with pinned left identifier columns.
- **Desktop Executive (`≥ 1200px`)**: 12-column fixed/fluid layout with max-width containment at `1440px`. Gutters: `1.5rem` (`24px`), margins: `2rem` (`32px`). Multi-panel layouts snap to 3-column ledger splits (Navigation: 2 cols, Active Worksheet: 7 cols, Batch Telemetry: 3 cols).

## Elevation & Depth

This system intentionally eliminates blurred drop-shadows and frosted glass filters. Visual hierarchy is achieved entirely through solid tonal surfaces and 1px structural outlines:

- **Strict Zero-Glass Policy**: `backdrop-blur`, semi-transparent alphas (`rgba`), and frosted glass components are strictly prohibited. Every panel, modal, dialog, and dropdown must render with 100% opacity (`#ffffff`, `#f8fafc`, or dark equivalents `#18181b`, `#09090b`).
- **Surface Elevation by Tonal Stacking**:
  - `Level 0 (Canvas)`: Base background (`bg-slate-50` / `bg-zinc-950`).
  - `Level 1 (Panels & Cards)`: Solid resting card (`bg-white` / `bg-zinc-900`) wrapped in a 1px border (`border-slate-200` / `border-zinc-800`).
  - `Level 2 (Active Rows & Hover States)`: Solid inset shift (`bg-slate-100` / `bg-zinc-800`).
  - `Level 3 (Modals & Command Palettes)`: Solid opaque background flanked by a high-contrast 1px border (`border-slate-900` or `border-zinc-700`). No ambient drop shadows; overlays utilize an opaque 80% non-blurred solid scrim (`bg-slate-950/80`).

## Shapes

The shape system is strictly architectural and rectilinear.

- **Corner Radii Rule**: Standard elements (cards, panels, data tables, modals) use `rounded-none` (0px).
- **Interactive Micro-Radii**: Buttons, input fields, and quantitative pickers may utilize at most `rounded-sm` (2px) purely to prevent harsh subpixel antialiasing on physical production screens.
- **Anti-Pill Constraint**: Rounded pill shapes (`rounded-full`) are barred from the design system. Badges, status markers, and operational state labels must use rectilinear boxes with crisp right angles.

## Components

### Buttons
- **Primary Button**: Solid `bg-slate-900` with `text-white`, `rounded-none` (or `rounded-sm`), 1px border `border-slate-900`. Hover: `bg-slate-800`.
- **Secondary Button**: Solid `bg-white` with `text-slate-900`, 1px border `border-slate-200`. Hover: `bg-slate-50`, `border-slate-300`.
- **Accent Button (Oven/Thermal)**: Solid `bg-amber-700` with `text-white`, `rounded-none`. Hover: `bg-amber-800`.
- **VIP Action (Executive)**: Solid `bg-zinc-900` with `text-amber-500`, 1px border `border-amber-600/50`. Hover: `bg-zinc-800`.
- **Padding**: Compact `px-3 py-1.5` for high-density tabular actions; `px-5 py-2.5` for primary global actions. No pills.

### Status Indicators & Tags (Zero-Pill Doctrine)
- **Design Rule**: Strictly rectangular badges with 0px radius (`rounded-none`). No pill badges.
- **Structure**: 1px solid border with opaque background fill:
  - *Proofing / Active*: `bg-amber-50 text-amber-900 border border-amber-300` (Light) | `bg-amber-950 text-amber-200 border border-amber-800` (Dark).
  - *Baked / Certified*: `bg-emerald-50 text-emerald-900 border border-emerald-300` (Light) | `bg-emerald-950 text-emerald-200 border border-emerald-800` (Dark).
  - *Draft / Rest*: `bg-slate-100 text-slate-800 border border-slate-300` (Light) | `bg-zinc-800 text-zinc-300 border border-zinc-700` (Dark).

### Input Fields & Controls
- **Inputs**: Opaque `bg-white` (or `bg-zinc-900`), 1px border `border-slate-300` (or `border-zinc-700`), `rounded-none`. Focus: 1px border `border-slate-900` without outline halos.
- **Checkboxes & Radios**: Strictly square or sharp-cornered indicators. Checkbox: `rounded-none`, 1.5px solid border. Radio: 1px border `border-slate-400` with solid square interior check mark.

### Data Tables & Ingredient Matrices
- **Table Container**: Solid `bg-white`, `border border-slate-200`, `rounded-none`.
- **Headers**: `bg-slate-100`, text `text-slate-600 font-semibold`, uppercase tracking `tracking-wider`, bottom border `border-b border-slate-200`.
- **Numeric Cells**: Styled in `font-mono tabular-nums text-right` using `JetBrains Mono`.
- **Row Hover**: Solid `hover:bg-slate-50` with no elevation or transform transitions.

### Cards & Batch Recipe Panels
- **Container**: `bg-white` (or `bg-zinc-900`), `border border-slate-200` (or `border-zinc-800`), `rounded-none`, padding `p-6`.
- **Header**: Flush, typography-driven `text-lg font-semibold tracking-tight` with immediate numeric subheader. Devoid of decorative floating icons or upper pill chips.
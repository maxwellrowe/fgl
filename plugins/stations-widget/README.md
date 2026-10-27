# Stations Widget

Render the editable route in a WordPress Shortcode block:

```text
[stations_widget]
```

Or in a PHP template:

```php
echo do_shortcode( '[stations_widget]' );
```

## Setup

1. Activate **Stations Widget** and **Advanced Custom Fields** (free or Pro).
2. Under **Stations → Phases**, create the actual route phases. Do not add a “None” phase; leave stations unassigned instead.
3. Under **Stations → Statuses**, edit Complete, Station Construction, and Future Station to upload each status icon. The included Figma icons are defaults until replaced.
4. Add and publish stations. The title is the station name. Enter Info, a Learn More Link, one Status, and optionally one Phase.
5. Set numeric positions under **Stations → Route Order**. Lower numbers appear first; ties sort by title, then ID. Keep each phase’s stations together. Draft/private stations are not rendered.
6. Under **Stations → Settings**, edit the heading and select the statuses shown in the legend. Construction and Future are selected on first activation. Selecting no statuses hides legend entries.
7. Place the shortcode on the intended page. No page is modified automatically.

The route has one global order. Phase brackets follow contiguous runs and jump buttons target the first published station in each phase. Ungrouped stations still appear in route order and do not create jump buttons. No stations or phases are invented or seeded.

## Interaction

- Swipe/drag, use previous/next, or drag the scrollbar.
- Click a station to open its details and optional link.
- Escape or the close button dismisses details. Arrow keys/Home/End move between focused station buttons.
- Multiple shortcode instances have independent controls and unique popup IDs.
- Without JavaScript, the route remains horizontally scrollable; interactive popovers require JavaScript.
- No published stations means the shortcode renders no component.

## Assets and integration

Swiper 12.0.3 is bundled locally with its MIT license. JavaScript loads when the shortcode renders. Scoped styles are enqueued on singular pages so template-inserted shortcodes have CSS available in the document head. Colors reuse theme variables with standalone fallbacks. Typography uses the theme’s Barlow font when available and Arial otherwise.

Station status icons and popup pointer were exported from the supplied Figma design (Stations node `106:977`); images are local, never linked to temporary Figma URLs. Phase bracket geometry is data-driven CSS. Uploaded icon media is managed by WordPress, and is not deployed by the repository workflow.

Content and options persist when the plugin is deactivated or deleted. ACF fields are registered in PHP and require no JSON import. This component does not modify the existing city/station post types or construction notice status taxonomy.

## Figma mapping

- Station Map: https://www.figma.com/design/EnhPFCxEcV40lPbX1UAKYO?node-id=127-2052
- Stations: https://www.figma.com/design/EnhPFCxEcV40lPbX1UAKYO?node-id=106-977
- Rendering: `includes/frontend.php` (`fglsw_shortcode`)
- Behavior: `assets/js/stations-widget.js`
- Appearance: `assets/css/stations-widget.css`

Code Connect mapping to this shortcode documentation was requested, but Figma rejected saving the mappings because the library is not on an Organization or Enterprise plan. No remote mappings were saved.

## Validation

PHP and JavaScript syntax checks passed. A temporary browser fixture rendered the real shortcode output with sample station data and checked desktop/mobile popovers, phase jumps, keyboard navigation, empty routes, multiple instances, image loading, and overflow at 320, 600, 942, and 1100px. WordPress activation, ACF editing, and saving settings/order still require verification in the destination WordPress installation.

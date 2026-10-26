# Construction Notice Widget assets

## Styles

`vendor/bootstrap/bootstrap.min.css` is Bootstrap 5.3.8, with its MIT license
included alongside it. Only CSS is loaded: the current template uses utilities,
not Bootstrap JavaScript components.

Edit `css/construction-notice-widgets.css` for plugin styling. It loads after
Bootstrap on single widget pages only, with file modification time for cache
busting. Keep selectors scoped to `body.const-update-widget`.
Bootstrap utilities use `!important`; remove conflicting utility classes or use
a scoped `!important` override when deliberately overriding those utilities.

ACF colors and sizes are emitted as CSS variables after the plugin stylesheet.
Colors accept hex values; sizes accept px, rem, em, or percent, with bare numbers
treated as pixels. Empty or invalid values retain the stylesheet defaults.
The active theme still runs its normal WordPress hooks and asset enqueues, so
check the final layout on the destination site for theme-specific conflicts.

Add these logo files under `img/`:

- `FGL_linear.png` (light theme)
- `FGL_linear_reverse.png` (dark theme)

The `js/` directory includes iframe-resizer **4.3.11**, matching the existing
v4 API used by this integration, from:
https://github.com/davidjbradshaw/iframe-resizer/tree/v4.3.11
The upstream license is included as `js/iframe-resizer-LICENSE`.

- `iframeResizer.min.js` runs on the embedding website and is referenced by
  the generated embed code, followed by `iFrameResize()` initialization.
- `iframeResizer.contentWindow.min.js` runs inside the widget and is enqueued
  by the plugin on individual construction widget pages.

Keep both scripts on the same version. A v5 upgrade requires updating the
integration rather than simply replacing these files.

Save each widget again to regenerate its ACF embed-code field. Existing copies
of embed code on other websites must be replaced manually. URLs are generated
from the current WordPress installation, so regenerate after moving environments.

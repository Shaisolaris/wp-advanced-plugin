# wp-advanced-plugin

## Quick Start

1. Copy to `wp-content/plugins/wp-advanced-plugin/`
2. Activate in WordPress admin
3. Demo content auto-created: 3 portfolio items, 2 testimonials, 1 service
4. Visit Settings → Advanced Plugin to configure

### Demo Content

On activation, the plugin creates sample content so you can immediately see:
- Portfolio grid on any page with `[portfolio]` shortcode
- Testimonials carousel with `[testimonials]` shortcode
- Services list with `[services]` shortcode
- REST API endpoints at `/wp-json/advanced-plugin/v1/`


![CI](https://github.com/Shaisolaris/wp-advanced-plugin/actions/workflows/ci.yml/badge.svg)

WordPress plugin with 3 custom post types (Portfolio, Testimonials, Services), custom taxonomies (Project Types, Skills, Service Categories), meta boxes with custom fields, REST API endpoints with pagination and filtering, admin settings page, and a Gutenberg block for featured content display.

## Custom Post Types
- **Portfolio** — projects with client, URL, date meta fields, project types and skills taxonomies
- **Testimonials** — quotes with author name, role, star rating
- **Services** — service pages with categories, ordering, excerpts

## REST API (`/wp-json/wp-advanced/v1/`)
| Endpoint | Description |
|---|---|
| GET `/portfolio` | List projects (filter by type, paginate) |
| GET `/portfolio/{id}` | Single project with meta and terms |
| GET `/testimonials` | All testimonials with ratings |
| GET `/services` | All services ordered by menu_order |
| GET `/stats` | Post counts (admin only) |

## Gutenberg Block
**Featured Content** block with InspectorControls: select post type, posts count, columns. Server-side rendered with grid preview in editor.

## Setup
```bash
git clone https://github.com/Shaisolaris/wp-advanced-plugin.git
# Copy to wp-content/plugins/wp-advanced-plugin
# Activate in WordPress admin
```

## License
MIT

## Architecture

```
.editorconfig
.github/workflows/ci.yml
.gitignore
DEMO.md
Makefile
README.md
admin/class-settings.php
blocks/featured-content/block.json
blocks/featured-content/index.js
demo-data.php
includes/class-meta-boxes.php
includes/class-post-types.php
includes/class-taxonomies.php
rest-api/class-rest-controller.php
wp-advanced-plugin.php
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a Pull Request

## License

MIT

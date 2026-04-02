# wp-advanced-plugin

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

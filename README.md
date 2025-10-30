# WordPress
# solid-headless-theme

![WordPress](https://img.shields.io/badge/WordPress-Headless-blue?style=flat-square) ![JS](https://img.shields.io/badge/JavaScript-ES6-yellow?style=flat-square) ![PHP](https://img.shields.io/badge/PHP-Backend-blueviolet?style=flat-square) ![REST API](https://img.shields.io/badge/REST_API-Enabled-brightgreen?style=flat-square) ![SOLID](https://img.shields.io/badge/SOLID-Principles-lightgrey?style=flat-square)

# DESCRIPTION
Professional headless WordPress theme | SOLID, Clean Code, DRY, fully decoupled, JS modules, REST API-powered, zero PHP templates, pages rendered entirely with dynamic JS modules and HTML. Implements Design Patterns (Adapter, Cache Aside, and more).

# FEATURES
- Headless WordPress architecture  
- SOLID, Clean Code, DRY  
- Modular JavaScript for dynamic front-end rendering  
- REST API-driven content (WordPress REST API)  
- No PHP in page templates
- Scalable and maintainable codebase  
- Implements common design patterns (Adapter, Cache Aside, and more)  

# TECH STACK
| Technology | Purpose |
|------------|---------|
| PHP        | Backend REST API within WordPress |
| JavaScript (ES6 Modules) | Front-end dynamic rendering |
| WordPress REST API | Fetch dynamic content |
| HTML & CSS | Semantic, modular, scalable design |

# INSTALLATION & SETUP
```bash
git clone https://github.com/rafapress/solid-headless-theme.git
```

# INSTALLATION & SETUP
Copy the theme folder to wp-content/themes.
Activate the theme in WordPress admin panel.
Ensure REST API is enabled.
Pages will populate dynamically via JS modules (no PHP templates).

# USAGE
Example: fetch posts dynamically

```
fetch('/wp-json/wp/v2/posts')
  .then(res => res.json())
  .then(posts => {
    // Render posts dynamically
  });
```

Manage custom post types via WP admin panel.
All content is modular and dynamic.

# CONTRIBUTION
Pull requests welcome.
Follow Clean Code and modular JS principles.

# SUPPORT
Contact: rafapress@yahoo.com

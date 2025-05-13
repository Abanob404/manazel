# Project Structure for Manazel PHP Website

This document outlines the proposed directory and file structure for the Manazel real estate website, which will be built using HTML, CSS, JavaScript, and PHP with a MySQL database.

```
manazel_php_project/
├── config/                  # Configuration files
│   └── config.php           # Database credentials, site settings, language settings
│
├── public_html/             # Publicly accessible directory (web root)
│   ├── assets/              # Compiled CSS, JS, images, fonts
│   │   ├── css/             # CSS files
│   │   │   └── style.css    # Main stylesheet
│   │   ├── js/              # JavaScript files
│   │   │   └── script.js    # Main JavaScript file
│   │   ├── images/          # Site images (logos, backgrounds, etc.)
│   │   └── fonts/           # Custom fonts
│   ├── uploads/             # User-uploaded content (e.g., property images) - ensure proper permissions
│   ├── index.php            # Main entry point for the application (router)
│   └── .htaccess            # Apache configuration (for clean URLs, security)
│
├── src/                     # Core application source code (PHP classes and logic)
│   ├── Auth/                # Authentication logic (login, register, logout, session management)
│   │   └── AuthController.php
│   ├── Property/            # Property management logic (CRUD, search, ratings, follows)
│   │   └── PropertyController.php
│   │   └── PropertyModel.php
│   ├── User/                # User profile management
│   │   └── UserController.php
│   │   └── UserModel.php
│   ├── Admin/               # Admin panel specific logic
│   │   └── AdminController.php
│   ├── Core/                # Core framework components (Router, Request, Response, Database connection)
│   │   └── Database.php
│   │   └── Router.php
│   │   └── Request.php
│   │   └── Response.php
│   │   └── App.php          # Application bootstrap
│   └── helpers.php          # Utility functions (e.g., for sanitization, formatting)
│
├── templates/               # HTML templates (views)
│   ├── layouts/             # Base layout files
│   │   ├── header.php       # Site header (navigation, logo)
│   │   ├── footer.php       # Site footer (copyright, links)
│   │   └── admin_layout.php # Layout for admin panel
│   ├── pages/               # Page-specific templates
│   │   ├── home.php
│   │   ├── about.php
│   │   ├── services.php
│   │   ├── listings.php     # Property listings page
│   │   ├── property-details.php
│   │   ├── contact.php
│   │   ├── login.php
│   │   ├── register.php
│   │   ├── profile.php      # User profile page
│   │   └── admin/           # Admin panel pages
│   │       ├── dashboard.php
│   │       ├── manage-properties.php
│   │       └── manage-users.php
│   └── partials/            # Reusable template partials (e.g., property card, search form)
│       ├── property_card.php
│       ├── search_form.php
│       └── language_switcher.php
│
├── lang/                    # Language files for internationalization
│   ├── en.php               # English translations
│   └── ar.php               # Arabic translations
│
├── includes/                # PHP files to be included (e.g., bootstrap, core functions)
│   ├── bootstrap.php        # Initializes the application (autoloader, config, session)
│   ├── functions.php        # General helper functions, including `trans()` for language
│   └── db.php               # Database connection setup (if not handled in Core/Database.php)
│
├── tests/                   # Unit and integration tests (optional, but recommended)
│
├── vendor/                  # Composer dependencies (if any are used)
│
├── composer.json            # Composer dependency management file (if used)
├── README.md                # Project overview and setup instructions
└── .gitignore               # Specifies intentionally untracked files that Git should ignore
```

## Explanation of Key Directories:

*   **`config/`**: Stores all application configuration, such as database credentials, API keys, and site-wide settings. This keeps sensitive information and settings separate from the codebase.
*   **`public_html/`**: This is the web server's document root. Only files that need to be directly accessible via a browser should be placed here (e.g., `index.php`, CSS, JavaScript, images). All other application logic and sensitive files should be outside this directory for security.
    *   **`assets/`**: Contains sub-directories for static assets like CSS, JavaScript, images, and fonts.
    *   **`uploads/`**: For storing user-uploaded files like property images. Ensure this directory has correct write permissions for the web server and is secured against direct script execution.
    *   **`index.php`**: Acts as the single entry point (front controller) for the application. All requests will be routed through this file.
*   **`src/`**: Contains the core PHP application logic, organized into subdirectories based on functionality (e.g., `Auth`, `Property`, `User`, `Admin`). This promotes a clean and modular codebase, potentially following an MVC-like pattern.
    *   **`Core/`**: Could house fundamental classes for routing, database interaction, request/response handling.
*   **`templates/`**: Holds all HTML presentation files (views). These files will typically contain HTML markup mixed with PHP for displaying dynamic data.
    *   **`layouts/`**: Contains base HTML structures (e.g., header, footer) that are common across multiple pages.
    *   **`pages/`**: Contains templates for specific pages of the website.
    *   **`partials/`**: Contains reusable snippets of HTML/PHP (e.g., a property card, a search form) that can be included in multiple pages.
*   **`lang/`**: Stores language files for internationalization. Each file (e.g., `en.php`, `ar.php`) will contain an associative array of translation strings.
*   **`includes/`**: This directory can hold PHP scripts that are included in various parts of the application, such as a bootstrap file to initialize settings and autoloaders, or common utility functions.
*   **`tests/`**: For automated tests (e.g., PHPUnit). While optional for this project's scope, it's good practice for larger applications.
*   **`vendor/`**: If Composer is used for managing PHP dependencies, this directory will store the downloaded libraries. It should typically be added to `.gitignore`.

This structure aims to provide a clear separation of concerns, making the application easier to develop, maintain, and scale.


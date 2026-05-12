# Zipply Paste 🚀

[![PHP Version](https://img.shields.io/badge/php-%3E%3D%208.0-777bb4.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Style](https://img.shields.io/badge/style-modern--dark-indigo.svg)](https://zipply.io)

Zipply Paste is a **lightweight, self-hosted, multi-user Pastebin platform** built with PHP 8+. Designed for speed, security, and developer experience, it combines the simplicity of classic pastebins with a polished, modern UI inspired by high-end file transfer tools.

[**Live Demo**](https://paste.boxlabs.uk/) | [**Documentation**](docs/) | [**Download**](https://github.com/user/zipply-paste/archive/refs/heads/main.zip)

---

## ✨ Features

### 📝 Advanced Editor
- **Monaco Editor Integration:** The same engine that powers VS Code.
- **Syntax Highlighting:** Support for JavaScript, PHP, Python, HTML, CSS, Markdown, and hundreds more.
- **Theme Toggle:** Seamlessly switch between a sleek Dark Mode and a clean Light Mode.
- **Markdown Preview:** Real-time rendering for Markdown pastes.

### 🔐 Security & Privacy
- **Password Protection:** Encrypt your pastes with a custom password.
- **Visibility Levels:** Public, Unlisted, or Private (User-only) pastes.
- **Burn After Read:** Pastes that self-destruct after a single view.
- **Expiration Dates:** Set pastes to expire after 10 minutes, 1 hour, a day, or a week.
- **Robust Protection:** Built-in CSRF, XSS, and SQL injection prevention.

### 👤 Multi-User System
- **Personal Dashboards:** Manage your history, edit saved pastes, or delete them.
- **Public Profiles:** Show off your snippets with Gravatar-integrated profile pages.
- **API Keys:** Generate keys to create pastes programmatically via your own scripts.
- **Admin Panel:** Powerful site settings, user management, and global paste moderation.

### 🚀 Performance & Deployment
- **Zero Dependencies:** No Composer required for production. All vendors are pre-bundled.
- **Dual Database Support:** Uses **SQLite** by default for zero-config setup, with optional **MySQL** support for scaling.
- **Self-Contained:** Runs from the root directory; no complex Apache configurations needed.
- **Responsive Design:** Fully mobile-friendly UI built with Tailwind CSS.

---

## 🛠️ Quick Start

### 1. Requirements
- PHP 8.0 or higher
- PDO Extension (SQLite or MySQL)
- Apache with `mod_rewrite` enabled

### 2. Installation
1. **Download:** [Download the latest release](https://github.com/user/zipply-paste/archive/refs/heads/main.zip) and extract it to your server.
2. **Permissions:** Ensure the `storage/` directory is writable (`chmod -R 775 storage`).
3. **Run Installer:** Visit the project URL in your browser (e.g., `http://localhost/zipply-paste/`).
4. **Complete Setup:** The web installer will guide you through database configuration and admin account creation.

---

## 📂 Project Structure

```text
zipply-paste/
├── app/                # Application Core (MVC)
│   ├── Controllers/    # Request Handlers
│   ├── Core/           # Router, Database, Base Controller
│   ├── Helpers/        # Security, View Helpers
│   ├── Models/         # Database Interactions
│   └── Views/          # UI Templates (HTML/PHP)
├── assets/             # Images & Icons
├── config/             # DB and Site Settings
├── css/                # Bundled Tailwind CSS
├── js/                 # Bundled Lucide & Monaco Loader
├── storage/            # SQLite DB & Activity Logs
├── .htaccess           # Clean URL Rewriting
└── index.php           # Main Entry Point
```

---

## 📄 License

This project is open-source software licensed under the **MIT License**. Created with ❤️ for the self-hosted and developer community.

---

*“Simple, Fast, Secure Pasting.”* – **Zipply Paste**

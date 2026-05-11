# Zipply Paste 🚀

Zipply Paste is a lightweight, self-hosted, multi-user Pastebin platform built with PHP 8+. It features a modern dark-first UI, syntax highlighting with Monaco Editor, and a robust set of features for developers and teams.

## ✨ Features

- **Modern UI:** Polished, dark-first aesthetic with a Light/Dark mode toggle.
- **Advanced Editor:** Integrated Monaco Editor (VS Code style) with syntax highlighting for hundreds of languages.
- **Multi-User:** Secure registration, login, and personal dashboards.
- **Paste Management:** Public, unlisted, and private pastes with expiration options.
- **Security:** CSRF protection, IP-based rate limiting, and password-protected pastes.
- **Burn After Read:** Self-destructing pastes for extra privacy.
- **Admin Panel:** Powerful site moderation and settings management.
- **Lightweight:** Minimal dependencies and easy to deploy.
- **Zero Configuration:** Pre-bundled dependencies. No Composer required!

## 🛠️ Installation

### 1. Requirements
- PHP 8.0 or higher
- SQLite (default) or MySQL support
- Apache with `mod_rewrite` enabled (for clean URLs)

### 2. Setup
1. Clone the repository or download the source code.
2. Navigate to the project directory.
3. Point your web server (Laragon, XAMPP, WAMP, or Apache) to the root directory of the project.
   - *Example: If you extract to `D:\laragon\www\zipply-paste`, your URL will be `http://localhost/zipply-paste/`.*

### 3. Web Installation
Navigate to the `/install` route in your browser (e.g., `http://localhost/zipply-paste/install`).
Follow the on-screen instructions to set up your admin account and initialize the database.

## 📁 Project Structure
- `app/`: Core logic (Controllers, Models, Views, Helpers)
- `config/`: Database and site configuration
- `storage/`: Database files and logs
- `index.php`: Main entry point

## 📄 License
MIT License. Created with ❤️ for the self-hosted community.

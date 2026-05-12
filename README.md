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
- **Zero Configuration:** Pre-bundled dependencies. No Composer required!

## 🛠️ Installation

### 1. Requirements
- PHP 8.0 or higher
- SQLite (default) or MySQL support
- Apache with `mod_rewrite` enabled

### 2. Setup
1. Clone the repository or download the source code.
2. Extract the files directly into your web server's root or a subfolder (e.g., `D:\laragon\www\zipply-paste`).
3. Ensure the `storage/` directory is writable by the web server.

### 3. Web Installation
Navigate to your project's URL in your browser (e.g., `http://localhost/zipply-paste/`).
The system will automatically detect if it's not installed and redirect you to the `/install` route.
Follow the on-screen instructions to set up your admin account and initialize the database.

## 📁 Project Structure
- `app/`: Core logic (Controllers, Models, Views, Helpers)
- `config/`: Database and site configuration
- `storage/`: Database files and logs
- `css/`, `js/`, `assets/`: Frontend assets (Tailwind, Lucide, etc.)
- `index.php`: Main entry point (No more `public/` folder needed in URL!)

## 📄 License
MIT License. Created with ❤️ for the self-hosted community.

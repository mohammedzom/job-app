<div align="center">

# 🌐 Shaghalni — Job Platform

**A modern, bilingual (Arabic/English) job marketplace connecting employers and job seekers.**

[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-38BDF8?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3-77C1D2?style=flat-square&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

</div>

---

## 📌 Overview

**Shaghalni** is the main user-facing application for the Shaghalni Job Platform. It provides a seamless experience for job seekers to find listings, build their profiles, and submit job applications, while also incorporating AI to analyze resumes.

This project delivers a premium "Cosmic Dark" UI experience, ensuring responsive and highly polished user interactions.

> **Backend:** Fully developed by **[@mohammedzom](https://github.com/mohammedzom)**  
> **Frontend / UI:** Designed with the assistance of **AI (Claude by Anthropic / Gemini)**

---

## ✨ Key Features

### 👤 Job Seeker Profiles & Resumes
- Comprehensive user profiles.
- Integrated Resume Parsing and AI Analysis (extracting skills, education, and experience dynamically).
- Premium resume view interface inline with modern standards.

### 💼 Job Search & Applications
- Browse and filter job vacancies dynamically.
- Detailed job display pages.
- Job application tracking and management for job seekers.

### 🌍 Internationalization (i18n)
- Full **English (LTR)** and **Arabic (RTL)** support.
- Localization of UI strings.
- RTL layout flips automatically.

### 🎨 Premium UI/UX Design
- **Cosmic Dark** theme tailored for a high-end experience.
- Responsive mobile-first layouts.
- Dynamic interactions, toast notifications, and modals using Alpine.js and Tailwind CSS.

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.5 |
| Framework | Laravel 13 |
| Frontend CSS | Tailwind CSS v4 |
| Interactivity | Alpine.js v3 |
| Templating | Blade |
| Database | MySQL / SQLite |
| Build Tool | Vite |

---

## 🔗 Related Repositories & Architecture

This application is part of a broader ecosystem. To maintain consistency, **Eloquent Models are shared** between the main job platform and the backoffice dashboard via a local package.

All three projects should ideally be placed in the same parent directory to correctly resolve the local composer path for the shared library.

| Project | Link | Role |
|---|---|---|
| 🌐 **Job Platform (User-Facing)** | [mohammedzom/job-app](https://github.com/mohammedzom/job-app) | This repository (Main application for job seekers) |
| 🏢 **Backoffice Dashboard** | [mohammedzom/job-backoffice](https://github.com/mohammedzom/job-backoffice) | Administration & Company Dashboard |
| 📦 **Shared Models Library** | [mohammedzom/job-shared](https://github.com/mohammedzom/job-shared) | Local library containing shared Eloquent models |

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL or SQLite

### Installation

```bash
# 1. Create a directory for the project
mkdir job-project

# 2. Enter the directory
cd job-project

# 3. Clone the repository library
git clone https://github.com/mohammedzom/job-shared.git

# 4. Clone the backoffice
git clone https://github.com/mohammedzom/job-backoffice.git

# 5. Enter the directory backoffice
cd job-backoffice

# 6. Install PHP dependencies
composer install

# 7. Install Node dependencies
npm install

# 8. Copy environment file and configure
cp .env.example .env
php artisan key:generate

# 9. Set up the database in .env (make sure it connects to the same DB as backoffice if needed), then run migrations
php artisan migrate --seed

# 10. Build frontend assets
npm run build

# 11. Serve the application (optional)
php artisan serve --port=8001

# 12. Go back to the parent directory
cd ..

# 13. Clone this repository
git clone https://github.com/mohammedzom/job-app.git

# 14. Make sure you have the following directory structure:
job-project/
├── job-app/
├── job-shared/
└── job-backoffice/

# 15. Enter the directory
cd job-app

# 16. Install PHP dependencies
composer install

# 17. Install Node dependencies
npm install

# 18. Copy environment file and configure
cp .env.example .env
php artisan key:generate

# 19. Set up the database in .env (make sure it connects to the same DB as backoffice if needed), then run migrations
php artisan migrate

# 20. Build frontend assets
npm run build

# 21. Serve the application
php artisan serve
```

### Development Mode

```bash
# Run Vite dev server with hot reload
npm run dev

# In a separate terminal, serve Laravel
php artisan serve
```

---

## 📁 Project Structure (Key Directories)

```
app/
├── Http/Controllers/       # Controllers for Jobs, Resumes, User Profile...
├── Services/               # Business logic (e.g. OpenAI parsing)
└── ...

job-shared/ (External package)
└── src/Models/             # Eloquent models with relationships & casts

resources/
├── views/
│   ├── layouts/            # App shell
│   ├── components/         # Reusable Blade components
│   ├── jobs/               # Job vacancy listings & details
│   ├── resumes/            # Resume building & viewing
│   └── job-applications/   # Job Application tracking
├── css/
│   └── app.css             # Global design system
└── js/
    └── app.js              # Interactivity entry point
```

---

## 👨‍💻 Author

**Mohammed Zomlot**  
Backend Developer & DevOps Engineer | Laravel 
📎 [GitHub @mohammedzom](https://github.com/mohammedzom)

---

## 📄 License

This project is open-sourced software licensed under the [MIT License](LICENSE).

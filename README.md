# uriblog - Premium Editorial Management System

uriblog is a high-end editorial platform designed for seamless content management and premium reading experiences. Built with Laravel 12, it combines modern backend performance with a sophisticated, minimalist user interface focused on high-quality digital content delivery.

## Core Features

### Premium Editorial Design
The platform features a sophisticated Indigo brand identity with fluid animations and premium 3D isometric visual elements. The user interface is designed to feel high-end, clean, and professional.

### Advanced Authentication System
Secure entry system featuring a centered split-panel layout for login and registration. Includes full email verification workflows, password recovery, and secure session management.

### Content Management Dashboard
A dedicated workspace for creators to manage their stories. Features include full CRUD (Create, Read, Update, Delete) capabilities, automatic slug generation, and ultra-minimalist pagination (Current / Total).

### User Profile and Personalization
Advanced profile management allowing users to update their personal information, securely change passwords, and manage their identity. Features a circular avatar upload system with real-time camera-integrated previews and automatic storage management.

### Dynamic Community Showcase
The authentication pages feature a real-time creators showcase that dynamically fetches active member avatars directly from the database, providing authentic social proof.

### Responsive Architecture
The entire platform is built with a mobile-first approach, ensuring a premium editorial experience across desktop, tablet, and smartphone devices.

## Tech Stack

### Backend
- Laravel 12 Framework
- PHP 8.2 or higher
- MySQL Relational Database
- Laravel Breeze (customized)

### Frontend
- Tailwind CSS (Utility-first styling)
- Alpine.js (Lightweight interactivity)
- Blade Templating Engine
- Material Symbols Outlined (System icons)

## Installation Guide

### Prerequisites
- PHP 8.2+
- Composer
- Node.js and NPM
- MySQL Server

### 1. Clone the Repository
```bash
git clone https://github.com/kholilmustofa/uri-blog.git
cd uri-blog
```

### 2. Install Project Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```
Open the .env file and configure your database settings (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

### 4. Database Initialization
```bash
php artisan migrate
php artisan db:seed
```

### 5. Storage Link
```bash
php artisan storage:link
```

### 6. Build and Run
```bash
npm run dev
php artisan serve
```
Access the application at http://127.0.0.1:8000

## Project Status
Completed UI/UX overhaul and core management features.

## Developer
Kholil Mustofa

## License
This project is licensed under the MIT License.

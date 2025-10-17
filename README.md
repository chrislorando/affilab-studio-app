# 🎬 Affilab Studio App - Livewire Implementation

[![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen)]()
[![Laravel](https://img.shields.io/badge/Laravel-11.x-red)]()
[![Livewire](https://img.shields.io/badge/Livewire-3.x-blue)]()
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-purple)]()

---

## 🚀 About

Affilab Studio App is a modern Laravel + Livewire application for managing video content generation workflows. Users can create ideas with images, track processing status in real-time, and integrate with N8N for automated video generation.

**Key Features:**
- ✨ Real-time updates with Livewire polling
- 📸 Image upload to S3/Minio storage
- 🔄 Queue-based processing with N8N integration
- 📊 Live status tracking
- 📱 Responsive, mobile-friendly UI
- 🔐 Secure authentication & authorization

---

## ⚡ Quick Start (5 Minutes)

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- PostgreSQL (Supabase recommended)

### 1️⃣ Setup ENV

Edit `.env` file:
```env
DB_CONNECTION=pgsql
DB_URL=

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
AWS_ENDPOINT=
AWS_USE_PATH_STYLE_ENDPOINT=true

# N8N Webhook Configuration
N8N_WEBHOOK_URL=

```

### 2️⃣ Setup Database

```bash

# Clear cache
php artisan config:clear
php artisan cache:clear

# Run migrations
php artisan migrate --force
```

### 3️⃣ Run Development Servers

**Terminal 1 - Laravel**
```bash
php artisan serve
```

**Terminal 2 - Queue Worker**
```bash
php artisan queue:work
```

**Terminal 3 - Vite (Optional)**
```bash
npm run dev
```

---

## 🎯 Features

### Content Management
- ✅ Create idea with image upload
- ✅ Search and filter by text
- ✅ View content details
- ✅ Delete content and image
- ✅ Pagination (10 items/page)

### Real-Time Updates
- ✅ Auto-refresh 
- ✅ Live status tracking
- ✅ Event-driven updates
- ✅ Status badges (color-coded)

### Processing Workflow
- ✅ Image upload to S3/Minio
- ✅ Queue-based processing
- ✅ N8N webhook integration
- ✅ 5-state status tracking
- ✅ Error handling & retry

### Security
- ✅ Authentication required
- ✅ User ownership check
- ✅ Input validation
- ✅ CSRF protection

---

## 🛠️ Technology Stack

| Layer | Tech |
|-------|------|
| Framework | Laravel 11 + Livewire 3 |
| Frontend | Tailwind CSS 3 |
| Database | PostgreSQL (Supabase) |
| Storage | AWS S3 / Minio |
| Queue | Database Driver |
| HTTP | Guzzle 7 |
| Auth | Laravel Fortify |

---

## 📜 License

This project is licensed under the MIT License.

---

## 👥 Contributors

- **Created**: October 16, 2025
- **Framework**: Laravel + Livewire
- **Status**: Production Ready

---


**Made with ❤️ for Afflab Studio**

Generated: October 16, 2025 | Version: 1.0 | Status: ✅ Production Ready

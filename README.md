# 🎬 Affilab Studio App - Livewire Implementation

[![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen)]()
[![Laravel](https://img.shields.io/badge/Laravel-12.x-red)]()
[![Livewire](https://img.shields.io/badge/Livewire-3.x-blue)]()
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-purple)]()

---

## 🚀 About

Affilab Studio App is a modern Laravel + Livewire application for managing video content generation workflows. Users can create ideas with images, track processing status in real-time, and integrate with N8N for automated video generation.

![Affilab Studio App](https://github.com/user-attachments/assets/31cdcfa3-df5a-4c2c-9b71-c899c1955dda)

**Key Features:**
- ✨ Real-time updates with Livewire polling
- 📸 Image upload to S3/Minio storage
- 🔄 Queue-based processing with N8N integration
- 📊 Live status tracking
- 📱 Responsive, mobile-friendly UI

---

## ⚡ Quick Start (5 Minutes)

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- PostgreSQL (Supabase recommended)

### N8N Workflow Requirements
The N8N workflow requires the following integrations to be configured:
- **OpenAI API** - For AI-powered content generation and narration
- **Kie AI** - For access the Best Video, Image & Music Models in One API
- **Supabase** - For database operations

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
- ✅ Duplicate content
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
- ✅ 8-state status tracking
- ✅ Error handling & retry

---

## 🛠️ Technology Stack

| Layer | Tech |
|-------|------|
| Framework | Laravel 12 + Livewire 3 |
| Frontend | Tailwind CSS 3 + Flux UI |
| Database | PostgreSQL (Supabase) |
| Storage | AWS S3 / Minio |

---

## References

 - n8n service  
https://sumopod.com/register?ref=b9120f87-b648-40ef-b5b4-ec62bcfe72e0  

 - Sora 2 workflow (Base workflow - Modified)
https://lynk.id/azisbajri/o517wngvk6og
> ℹ️ **Note**: The current N8N workflow is a modified version of the Sora 2 workflow reference above, customized for Affilab Studio's specific content generation requirements. To obtain the original Sora 2 workflow, purchase it from the link above.

---

## Demo

http://affilab.demolite.my.id/
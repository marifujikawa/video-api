<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Video API

A Laravel-based RESTful API for managing video content with features like view counting and likes.

## Requirements

- Composer
- MySQL 5.7 or higher
- Laravel 12

## Installation

1. Clone the repository
```bash
git clone git@github.com:marifujikawa/video-api.git
cd video-api
```

2. Install dependencies
```bash
composer install
```

3. Environment Setup
```bash
cp .env.example .env
sail artisan key:generate
```

4. Run migrations and seeders
```bash
sail artisan migrate
sail artisan db:seed
```

## Running Tests

Run the test suite using:
```bash
sail test
```

## API Endpoints

### List Videos
```
GET /api/videos
```

### Get Video Details
```
GET /api/videos/{id}
```

### Increment Video Views
```
PATCH /api/videos/{id}/increment/views
```

### Increment Video Likes
```
PATCH /api/videos/{id}/increment/likes
```

## Development

### Running the Development Server
```bash
sail up -d
```
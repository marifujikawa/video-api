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

### Increment Video Likes
```
PATCH /api/videos/{id}/increment/likes
```

## Development

### Running the Development Server
```bash
sail up -d
```
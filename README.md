# Kenneth's Portfolio

A modern, responsive portfolio website built with Laravel, Vue.js, and Tailwind CSS.

## Features

- Modern and responsive design
- Dark mode support
- Animated components and transitions
- Interactive code editor display
- Project showcase
- Contact form
- Skills and technologies showcase

## Tech Stack

- Laravel
- Vue.js 3
- Tailwind CSS
- TypeScript
- Inertia.js

## Setup Instructions

1. Clone the repository:

```bash
git clone https://github.com/yourusername/kenneth-portfolio.git
cd kenneth-portfolio
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Node.js dependencies:

```bash
npm install
```

4. Create environment file:

```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env` file and run migrations:

```bash
php artisan migrate
```

6. Build assets:

```bash
npm run dev
```

7. Start the development server:

```bash
php artisan serve
```

Visit `http://localhost:8000` to see the application.

## Development

- Run `npm run dev` for development
- Run `npm run build` for production build

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

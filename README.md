# Laravel Vue2 SPA

Laravel 9 and vue2 spa using Bootstrap 5

## Features

- Laravel 9
- Vue + VueRouter + Vuex
- Login, register, update profile
- Password reset
- Authentication with JWT
- Bootstrap 5, Font Awesome 6
- Admin CRM for:
  - Galleries
  - Blogs
  - Services
  - Testimonials
  - Widget Areas

## Installation

- Navigate to the web root directory
- `composer create-project Php3ch0/laravel-vue2-spa .`
- Edit `.env` and set your database connection details
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed --class=CountriesTableSeed`
- `php artisan storage:link`
- `npm install`
- `npm run watch`

## Usage

#### Development

```bash
npm run watch

```

#### Production

```bash
npm run build
```

##

Highly inspired by [laravel-vue-spa by cretueusebiu](https://github.com/cretueusebiu/laravel-vue-spa) where it uses bootstrap 4 fontawesome and JWT for authentification

##

> Other features are under development coming soon :fire:

# Laravel Solid Example

[Link to article described this code](https://medium.com/@thepatrykooo/laravel-solid-princliples-project-example-bc3ad390b322)

## Introduction

I have prepared a Laravel project that include SOLID principles and some design patterns such as builder or template
method. I have tried to write the code like a professional developer, and the result is a simple API application for
managing company departments.

## Business Features

- Implement CRUD functionality for managing company departments
- Implement CRUD functionality for managing employees assigned to departments
- Implement report generation for departments, such as:
    - List all employees in each department
    - List all employees with their salaries
    - List all employees with their roles and responsibilities within the department.

## Run project

Clone repository:

    git@github.com:ThePatrykOOO/laravel-solid-example.git

Go to folder:

    cd laravel-solid-example

Install dependencies:

    composer install

Copy .env file:

    cp .env.example .env

Generate app key:

    php artisan key:generate

Run migrations:

    php artisan migrate

Run tests (optional):

    ./vendor/bin/phpunit

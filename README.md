# Inertia Movie Management

Movie Management System is a web application built with Laravel and Inertia.js that allows users to manage movies, actors, and productions. Users can create, edit, and delete movies, actors, and productions, as well as perform CRUD operations on them. The application also includes pagination and search functionality for easy navigation and management of data.

## Table of Contents

-   [Installation](#installation)
-   [Contributing](#contributing)
-   [License](#License)

## Installation

Before getting started, ensure you have [Node.js](https://nodejs.org/en/download/) and [Composer](https://getcomposer.org/download/) installed on your machine.

1. Clone the repository:

    ```bash
    git clone https://github.com/rohitatzignuts/Inertia-movie-management
    ```

2. Navigate into the project directory:

    ```bash
    cd project
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Install NPM dependencies:

    ```bash
    npm install
    ```

5. Copy the `.env.example` file to `.env` and update the environment variables:

    ```bash
    cp .env.example .env
    ```

6. Generate an application key:

    ```bash
    php artisan key:generate
    ```

7. Set up your database in the `.env` file and run the database migrations and seeders:

    ```bash
    php artisan migrate --seed
    ```

8. Start the development server:

    ```bash
    npm run dev
    php artisan serve
    ```

9. Visit `[http://127.0.0.1:8000].` in your browser to view the application.

## Contributing

If you would like to contribute to the project, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/yourfeature`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature/yourfeature`).
5. Create a new Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

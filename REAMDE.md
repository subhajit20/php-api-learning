# PHP Project

A PHP API project utilizing a clean architecture and various libraries for routing, validation, database interaction, and more.

## Libraries Used

* **nikic/fast-route**: Routing system for defining routes like `/api/users`, etc.
* **rakit/validation**: Form and input validation for username, email rules, etc.
* **ramsey/uuid** (optional): UUID generation
* **PDO (built-in)**: Database interaction with MySQL using `prepare`, `query`, etc.
* **Composer**: Dependency manager for installing and autoloading libraries

## Folder Structure

The project follows a clean architecture with the following folder structure:

* `models/`: Classes like `User.model.php`
* `controllers/`: API logic
* `routes/`: Organized routing
* `config/db.php`: Centralized database connection
* `public/index.php`: Entry point

## Features and Libraries

| Feature | Library / Method Used |
| --- | --- |
| RESTful Routing | `nikic/fast-route` |
| Validation Rules | `rakit/validation` |
| DB Queries (safe way) | `PDO` (with `prepare`, `execute`) |
| Password Hashing | `password_hash()` (built-in) |
| UUID Generation | `ramsey/uuid` or custom |
| Token-based Auth | Manual JWT implementation |
| Autoloading & PSR-4 | Via Composer |

## Getting Started

To get started with this project, create a `composer.json` file listing all dependencies properly or organize the app into a reusable package structure.

## Contributing

Contributions are welcome! Feel free to submit a pull request or open an issue.
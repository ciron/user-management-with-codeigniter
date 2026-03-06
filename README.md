# User Management System (CI4 + ClickHouse)

This is a User Management System built using CodeIgniter 4, custom backend layouts, DataTables, and **ClickHouse** as the primary database.

## Prerequisites

Before running this project, ensure you have the following installed:
- PHP >= 8.2 with the following extensions enabled: `curl`, `mbstring`, `intl`, `json`
- [Composer](https://getcomposer.org/)
- **ClickHouse** server running locally (or remotely)

## Setup Instructions

### 1. Install Dependencies
Run the following command in the root project directory to install all PHP dependencies (including the ClickHouse driver):
```bash
composer install
```

### 2. Configure Environment
Copy the `env` file to a new file named `.env`:
```bash
cp env .env
```
Open the `.env` file and set your environment strictly to development to see errors:
```ini
CI_ENVIRONMENT = development
```

### 3. Configure Database Connection (ClickHouse)
This project uses **ClickHouse** instead of MySQL. Therefore, the standard CodeIgniter `.env` database block is **NOT used**.

Instead, database connection details are hardcoded as a service. Open `app/Libraries/ClickHouseService.php` and update the connection array to match your local or remote ClickHouse server:

```php
$this->client = new Client([
    'host' => '127.0.0.1',
    'port' => 8123,
    'username' => 'default',
    'password' => 'admin', // Update your password here
]);
$this->client->database('ci4_clickhouse');
```

### 3. Setup the ClickHouse Database

1. Ensure your ClickHouse server is running.
2. In your terminal or ClickHouse client, create the database:
   ```sql
   CREATE DATABASE IF NOT EXISTS ci4_clickhouse;
   ```
3. Run the database test/creation script we have included in the `public/` directory. You can execute this from your browser or via CLI:
   ```bash
   php public/test_db.php
   ```
   *(This script will create the `users` table with the correct schema if it doesn't already exist.)*

### 4. Start the Application Server

Start the CodeIgniter development server by running:
```bash
php spark serve
```
By default, this will host the application at `http://localhost:8080/`.

## Accessing the Application

- **Public Site / Signup:** `http://localhost:8080/`
- **User Login:** `http://localhost:8080/login`
- **User Dashboard:** `http://localhost:8080/user/dashboard`
- **Admin Login:** `http://localhost:8080/admin/login`
- **Admin Dashboard:** `http://localhost:8080/admin/dashboard`
- **Admin User List (Datatable):** `http://localhost:8080/admin/userlist`

*(Note: ClickHouse uses `8123` for HTTP, ensure it is available if connecting locally. To access the admin panel, you'll need an admin account in the `users` table `role = 'admin'`)*

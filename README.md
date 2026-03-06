# User Management System (CI4 + ClickHouse)

This is a User Management System built using CodeIgniter 4, custom backend layouts, DataTables, and **ClickHouse** as the primary database.

## Prerequisites

Before running this project, ensure you have the following installed:
- PHP >= 8.2 
- [Composer](https://getcomposer.org/)
- **ClickHouse** server running locally (or remotely)

### 1. Clone the Repository
Clone the project to your local machine:
```bash
git clone https://github.com/ciron/user-management-with-codeigniter.git

```

### 2. Install Dependencies
Run the following command in the root project directory to install all PHP dependencies (including the ClickHouse driver):
```bash
composer install / composer update
```

### 3. Configure Environment
Copy the `env` file to a new file named `.env`:
```bash
cp env .env
```
Open the `.env` file and set your environment strictly to development to see errors:
```ini
CI_ENVIRONMENT = development
```

### 4. Configure Database Connection (ClickHouse)
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

### 5. Setup the ClickHouse Database

1. Ensure your ClickHouse server is running.
2. In your terminal or ClickHouse client, create the database:
   ```sql
   CREATE DATABASE IF NOT EXISTS ci4_clickhouse;
   ```
3. Import the `users` table schema by importing the SQL dump provided in the `public` directory:
   ```bash
   clickhouse-client -h 127.0.0.1 --port 9000 -d ci4_clickhouse -u default --password admin < public/users_202603061832.sql
   ```
   *(Alternatively, you can open `public/users_202603061832.sql` )*

### 6. Start the Application Server

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

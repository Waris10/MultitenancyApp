# Multi-Tenancy Starter Kit

A starter kit for building Laravel multi-tenancy applications. This kit provides a customizable foundation for managing multiple tenants with subdomain-based tenant separation, dynamic database connections, and tenant-specific authentication.

## Features

### 1. **Multi-Tenancy Setup**

-   Seamlessly manage multiple tenants with **subdomain-based** routing.
-   Automatically create databases and migrations for each tenant.
-   Each tenant can have its own database for isolation and performance.
-   Support for dynamic database switching based on the tenant's subdomain.

### 2. **Tenant Onboarding**

-   Simple onboarding process where a user can input their store name, and a subdomain will be automatically generated for their tenant (e.g., `store1.multitenancyapp.test`).
-   During onboarding, a store's initial database, migrations, and default data are set up.

### 3. **Dynamic Database Connection**

-   Automatic switching to the tenant’s database during a request using Laravel's database connection configuration.
-   Each tenant has its own isolated database for storing data.
-   Support for migration running on a per-tenant basis.

### 4. **Tenant-Specific Resources**

-   Store-specific content is easily managed and accessed using dynamic routes and views.
-   Each tenant can manage their own data without interference from others.

### 9. **Event-Driven Architecture**

-   Use of events and listeners to handle asynchronous tasks (e.g., database creation, sending emails, etc.) to optimize tenant registration.

### 10. **Laravel Integration**

-   Fully integrated with Laravel's core features, such as **Artisan commands**, **jobs and queues**, **Eloquent ORM**, and **Blade components**.
-   Leverages **Livewire** for real-time frontend interactions and dynamic page updates.

## Installation

### Prerequisites

1. PHP >= 8.0
2. Composer
3. MySQL or any other database connection supported by Laravel
4. Laravel 12.x or later

### Setup

1. Clone the repository:

    ```bash
    git clone https://github.com/Waris10/MultitenancyApp.git
    cd multitenancy app
    ```

2. Install dependencies:

    ```bash
    composer install
    ```

3. Configure your `.env` file:

    - Set your database and app configurations.
    - Configure the `main_domain` for tenant routing.

4. Set up the database:

    ```bash
    php artisan migrate
    ```

5. Set up any required queues, events, or background jobs.

### Running the Application

1. Run the local development server:

    ```bash
    php artisan serve
    ```

2. For dynamic subdomains on your local machine, I created a bat script in the root directory of the application to modify your local machine host file and this Script is utilized in the TenantRegister.php class component.

    N.B: feel free to customize according to personal preference!

3. For production environments, configure your web server to handle tenant subdomains and route requests to Laravel.

## Customization

-   **Tenant Subdomains**: You can modify the subdomain routing logic and database configurations in `TenantMiddleware` to better suit your needs.
-   **Tenant Models**: The default user model for tenants is `Tenant/User`. You can easily extend or modify it to include additional attributes or relationships.

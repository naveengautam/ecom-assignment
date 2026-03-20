## Project Setup

### Tech Stack Used

- **Laravel** 12.5
- **PHP** 8.2 or higher
- **Database:** MySQL

---

### How to Configure This Project

1. Configure the database settings in the `.env` file.
2. Install all required packages:
   ```
   composer install
   ```
3. Run the database migrations:
   ```
   php artisan migrate
   ```
4. Seed the Users, Vendors, and Products tables:
   ```
   php artisan db:seed
   ```

5. The application provides the following users for login:

   **Customer:**
   - Email: `ajay@example.com`
   - Password: `password`

   **Admin:**
   - Email: `admin@example.com`
   - Password: `password`

6. Events and Listeners for OrderCreation:
   - To process queued listeners, run:
   ```
   php artisan queue:work
   ```
   - Listener logic is intentionally simple and currently only writes logs.

---

### Limitations

1. Vendor login is not available because a vendor was not created in the users table.
2. I haven't written any Unit Tests or followed TDD approach because of time constraint.
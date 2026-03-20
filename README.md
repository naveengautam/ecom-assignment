## Project Setup

### Tech Stack Used

- **Laravel** 12.5
- **PHP** 8.2 or higher
- **Database:** MySQL

---

### How to Configure This Project

1. Configure the database settings in the `.env` file.
   ```
   cp .env.example .env
   ```

2. Generate the key
   ```
   php artisan key:generate
   ```

3. Install all required packages:
   ```
   composer install
   ```
4. Run the database migrations:
   ```
   php artisan migrate
   ```
5. Seed the Users, Vendors, and Products tables:
   ```
   php artisan db:seed
   ```
6. I have used Auth toolkit for authentication so we also need to install and build npm packages:
   ```
   npm install
   ```
7. We can build it so we don't need to run it again:
   ```
   npm run build
   ```

8. Now you're good to run the server:
   ```
   php artisan serve
   ```
   It would run on http://127.0.0.1:8000/

9. The application provides the following users for login:

   **Customer:**
   - Email: `ajay@example.com`
   - Password: `password`

   **Admin:**
   - Email: `admin@example.com`
   - Password: `password`

10. Events and Listeners for OrderCreation:
   - To process queued listeners, run:
   ```
   php artisan queue:work
   ```
   - Listener logic is intentionally simple and currently only writes logs.

---

### Limitations

1. Vendor login is not available because a vendor was not created in the users table.
2. I haven't written any Unit Tests or followed TDD approach because of time constraint.
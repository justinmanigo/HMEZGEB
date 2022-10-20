# HMEZGEB

## Requirements
- PHP Version >= `v8.0.2` (Works best in `v8.0.*`)

## Setup Guide
### 1. Clone GitHub repo for this project locally
```
git clone https://github.com/justinmanigo/HMEZGEB.git
```
### 2. `cd` into the `hmezgeb` project
```
cd hmezgeb
```
### 3. Install Composer Dependencies
```
composer install
```
### 4. Create a copy of `.env` file from `.env.example`. 
The `.env.example` file is already filled with default database information including the name of the database `hmezgeb`.
```
cp .env.example .env
```
### 5. Generate an app encryption key.
```
php artisan key:generate
```
### 6. Create an empty database named `hmezgeb`.
This can be done by opening XAMPP, run Apache and MySQL, then create a database to phpMyAdmin.
### 7. Update `.env` values when necessary (Optional)
Just in case your database server's configuration is different from the default `root` and blank password, or the name of the database, you may reflect those changes to the `.env` file.
### 8. Migrate and seed the database
```
php artisan migrate --seed
```

---

### For the users to receive emails (for testing in Mailtrap.io), kindly run this command. It works similarly as `php artisan serve`.
```
php artisan queue:work
```

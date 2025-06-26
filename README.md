# Repository for my website

Website still under construction.

## Next steps:

- Add timeline
- Add database access with more information and password for companies
- Add portfolio
<<<<<<< codex/update-readme-with-setup-details

## Requirements

This project requires **PHP 7.2.5** or newer. Ensure the `pdo_mysql` extension is enabled so the database connection works.

Install dependencies via Composer:

```bash
composer install
```

## Environment variables

Create a `.env` file inside the `includes` directory with the following keys:

```
DB_HOST=your_mysql_host
DB_NAME=your_database
DB_USER=your_user
DB_PASS=your_password
```

`db_connect.php` reads these values to configure the PDO connection.

## Building SCSS

The SCSS sources reside in `src/scss/`. There are currently no npm scripts defined for compilation. You can build the styles manually using the [Sass CLI](https://sass-lang.com/install):

```bash
npm install -g sass
sass src/scss/style.scss style.css
```

=======
- Hash all real passwords using PHP's `password_hash` before storing them
>>>>>>> main

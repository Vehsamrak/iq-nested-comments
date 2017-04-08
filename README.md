### Installation

1. Database `iq_option_comments` must be created.
1. MySQL user `root` with empty password must have access to database.
1. Table `comments` with schema (see below) must be created inside `iq_option_comments` database.
1. `composer install`
1. Run php builtin webserver `php -S localhost:8000 -t web`
1. Application is ready on `http://localhost:8000`

---
### Features

[✓] PHP 7.1

[✓] No frameworks were used

[✓] MVC project structure

[✓] Usage of Smarty

[✓] Usage of jQuery

[✓] Nested Sets were used to store tree structure in database

[✓] PSR-2

---
### Project structure (MVC)
- `web` - public directory for web server
- `src` - source code
- `src/Controller` - Controllers
- `src/Entity` - Domain models and their repositories
- `src/View` - Smarty view templates
- `src/Core` - Structure scaffoldings (non-business logic)

---
### Database table schema

```sql
CREATE TABLE `comments` (
	`id` VARCHAR(36) NOT NULL,
	`text` TEXT NOT NULL,
	`left_key` INT(16) UNSIGNED NOT NULL DEFAULT '0',
	`right_key` INT(16) UNSIGNED NOT NULL DEFAULT '0',
	`level` INT(16) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	INDEX `index_left_key` (`left_key`, `right_key`, `level`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
```

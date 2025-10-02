# Changelog


## [Unreleased][unreleased]

### Added
- Inicializovaná CakePHP 5 aplikácia.
- Vytvorený `UsersController` s podporou registrácie a login/logout.
- Pridaná autentifikácia cez CakePHP Authentication plugin.
- `UsersTable` so základnými validáciami (`username`, `email`, `password`, password_confirm`).
- Automatické hashovanie hesla pri registrácii cez `beforeSave`.
- Vytvorený základný layout `default.php` s horným navigačným barom a zobrazením identity používateľa.
- Identity helper `IdentityHelper` pre jednoduchý prístup k prihlásenému používateľovi vo view.
- Registrácia a login view `register.php` a `login.php` s Bootstrap 5 dizajnom.
- Vytvorený model `CategoriesTable` a `Category` entity.
- Vytvorený model `ProductsTable` a `Product` entity s väzbou na kategórie (`products_categories` join table).
- Routing pre produkty podľa kategórií vo formáte: `/eshop/<id>-webalized(<name>)`.
- Zobrazenie menu s kategóriami a produktami vo view.
- `HomeController` s `index` action pre zobrazenie všetkých produktov.
- Migrácia `CreateUsers` a `InsertDefaultUser` pre defaultného používateľa (`login: rshop`, `password: rshop`).
- Pridaný docker-compose.yml so službami rshop-db (MySQL 8.0) a rshop-app.
- Konfigurácia zabezpečuje automatickú inicializáciu databázy, aplikáciu migrácií a spustenie appky.
- Zabezpečené poradie štartu služieb – appka sa spustí až po zdravej DB.

### Fixed
- Riešené chyby: `Subject must be an instance of AuthenticationServiceInterface`, `Missing Table class`, hashovanie hesla, IdentityHelper trait chýbajúci.
- Odstránené problémy s logout route a nezobrazením identity používateľa.
- Opravené SQL dotazy pre join medzi produktmi a kategóriami.

## Change Log
### [Unreleased][unreleased]

### Added
- Pridana funkcionalita zlavy `najlacnejsi produkt bezplatne v quantity == 1` v košíku, v ktorom su aspoň 4 itemy

## [1.1.0]
### Changed
- Prechod na php8.4

## [1.0.0]
### Changed
- Zmenená konfigurácia na sqllite
- Upravene nastavenia v configoch

### Removed
- Odstranena create database migracia, ktora nemala opodstatnenie

## [1.0.0-alpha]
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
- Integracia `riesenia/cart` nakupneho košíka
- Rozdelenie a ukladanie stavu košíka podla userID, každý user ma vlastný storrage do ktorého sa môže kedykolvek vrátit a načítat stav košíku

### Fixed
- Riešené chyby: `Subject must be an instance of AuthenticationServiceInterface`, `Missing Table class`, hashovanie hesla, IdentityHelper trait chýbajúci.
- Odstránené problémy s logout route a nezobrazením identity používateľa.
- Opravené SQL dotazy pre join medzi produktmi a kategóriami.

[unreleased]: https://github.com/digilopment/rshop/compare/1.1.0...master
[1.1.0]: https://github.com/digilopment/rshop/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/digilopment/rshop/compare/1.0.0-alpha...1.0.0
[1.0.0-alpha]: https://github.com/digilopment/rshop/commit/412dd73...1.0.0-alpha

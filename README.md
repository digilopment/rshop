# RShop CakePHP 5

Jednoduchá e-shop aplikácia postavená na **CakePHP 5** s podporou používateľských účtov, kategórií, produktov a nákupného košíka.

---

## Funkcionality

### Používatelia
- Registrácia, login/logout.
- Autentifikácia cez **CakePHP Authentication plugin**.
- Základná validácia údajov (`username`, `email`, `password`).
- Automatické hashovanie hesla pri registrácii.
- Identity helper pre jednoduchý prístup k prihlásenému používateľovi vo view.

### Produkty a kategórie
- Modely `CategoriesTable` a `ProductsTable` s väzbou cez join table `products_categories`.
- Routing produktov podľa kategórií:  
  `/eshop/<id>-webalized(<name>)`.
- Menu s kategóriami a produktami vo view.
- `HomeController@index` pre zobrazenie všetkých produktov.

### Nákupný košík
- Integrácia riešenia `riesenia/cart`.
- Stav košíka uložený per userID – každý používateľ má svoj vlastný košík.
- Možnosť kedykoľvek načítať predchádzajúci stav košíka.

### Inštalácia a Docker
- Docker Compose so službami:
  - `rshop-db` (MySQL 8.0)
  - `rshop-app` (CakePHP aplikácia)
- Automatická inicializácia databázy a migrácií.
- Správne poradie štartu služieb – aplikácia sa spustí až po zdravej DB.

---

## Migrácie
- `CreateUsers` – vytvorenie tabuľky používateľov.
- `InsertDefaultUser` – vloženie defaultného používateľa:  
  `login: rshop`, `password: rshop`.

---

## Frontend
- Bootstrap 5 layout a formuláre pre registráciu a login.
- Zobrazenie identity používateľa v hornom navigačnom bare.

---

## Opravy a vylepšenia
- Riešené chyby: `Subject must be an instance of AuthenticationServiceInterface`, `Missing Table class`, hashovanie hesla, chýbajúci IdentityHelper trait.
- Opravené logout route a zobrazenie identity používateľa.
- SQL dotazy pre join medzi produktmi a kategóriami opravené.

---

## Spustenie DEVEL

1. Naklonuj repozitár:  
   ```bash
   git clone <repo-url>
   cd rshop
   bin/cake server
    ```


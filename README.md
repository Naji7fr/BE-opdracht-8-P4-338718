# BE Opdracht 8 - Autorijschool De Komeet

MVC PHP applicatie voor Feature2: **Verwijderen voertuig**.

## Vereisten

- PHP 8.1+
- MySQL / MariaDB
- Apache met mod_rewrite (XAMPP/WAMP)
- Composer (voor PHPUnit)

## Installatie

1. Importeer de database:
   ```sql
   SOURCE db/create.sql;
   ```
   Of voer `db/create.sql` uit via phpMyAdmin.

2. Pas indien nodig databasegegevens aan in `app/Config/Database.php`.

3. Stel de document root in op de map `public/` (of open via `http://localhost/opdracht8/public/`).

4. Installeer PHPUnit:
   ```bash
   composer install
   vendor/bin/phpunit
   ```

## Git workflow (opdracht)

```bash
git init
git add .
git commit -m "Initial commit"
git checkout -b feature-opdracht8
# ... werk uitvoeren ...
git checkout main
git merge feature-opdracht8
```

## Scenario's

| Scenario | Beschrijving |
|----------|--------------|
| 01 | Voertuig verwijderen van instructeur (Mohammed El Yassidi → Vespa) |
| 02 | Toegewezen voertuig verwijderen via Alle voertuigen |
| 03 | Niet-toegewezen non-actief voertuig kan niet verwijderd worden (Kymco) |

## Paginering

Maximaal **4 records** per pagina op:
- Instructeurs in dienst
- Door Instructeur gebruikte voertuigen
- Alle voertuigen

## Projectstructuur

```
app/
  Config/       Database configuratie
  Controllers/  MVC controllers
  Core/         Router, Controller, Model, Pagination
  Models/       Instructeur, Voertuig (PDO)
  Services/     VoertuigValidator
  Views/        PHP templates
db/             create.sql + stored procedures
docs/           Testplan, Testrapport, ERD, Class-diagram
tests/          PHPUnit unit tests
public/         Front controller (index.php)
```

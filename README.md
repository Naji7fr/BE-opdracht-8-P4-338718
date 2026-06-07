# BE Opdracht 8 - Autorijschool De Komeet

Laravel applicatie voor Feature2: **Verwijderen voertuig**.

## Starten

```powershell
php artisan serve
```

Open: **http://127.0.0.1:8000**

## Database

Importeer `db/create.sql` in phpMyAdmin (database: `komeet_rijschool`).

Pas `.env` aan indien nodig:

```
DB_DATABASE=komeet_rijschool
DB_USERNAME=root
DB_PASSWORD=
```

## Tests

```powershell
php artisan test
```

## Projectstructuur

```
app/
  Http/Controllers/   Home, Instructeur, Voertuig
  Models/             Eloquent modellen
  Repositories/       PDO + stored procedures
  Services/           Validatie helpers
resources/views/      Blade templates
db/create.sql         Database + stored procedures
routes/web.php        Routes
tests/Unit/           Unit tests
```

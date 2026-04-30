# Cégértékelő minialkalmazás (Symfony 8.0, PHP 8.4)

Ez a projekt egy Symfony-alapú webalkalmazás, amely lehetővé teszi, hogy felhasználók cégekről értékeléseket írjanak, majd ezeket listázzák, keressék és aggregált statisztikák formájában elemezzék.

A rendszer célja egy jól strukturált, skálázható CRUD + statisztikai mini platform létrehozása modern Symfony best practice-ek alkalmazásával.

---

# Adatmodell

A fő entitás a `Review`, Doctrine ORM attribute alapú mappinggel:

- `id` (auto increment)
- `companyName` (string)
- `rating` (1–5 integer)
- `reviewText` (text)
- `authorEmail` (valid email)
- `createdAt` (automatikusan beállítva)
- `updatedAt` (automatikusan beállítva)

Követelmények:
- Doctrine attribute alapú mapping
- Migrationök Doctrine Migrations segítségével
- Külön `ReviewRepository` a lekérdezési logikához

---

# Architektúra

A projekt réteges architektúrát követ:

- **Controller** → HTTP réteg
- **Fetcher / Service layer** → üzleti logika (pagination, aggregáció)
- **Repository** → adatlekérdezések (Doctrine QueryBuilder)
- **Twig** → kizárólag UI réteg
- **DTO / Result objektumok** → strukturált válaszok (pl. paginated list)

---

# Vélemény beküldése

- Symfony Form
- Validáció:
  - minden mező kötelező
  - rating: 1–5 közötti egész szám
  - author_email: valid email formátum
- Sikeres mentés után flash üzenet

UI:
- Bootstrap card layout
- interaktív star rating (hidden field + JS + Bootstrap Icons)

---

# Vélemények listázása

A fő listaoldal megjeleníti:

- cégnév
- értékelés (csillag ikonokkal)
- vélemény szövege (rövidítve)
- dátum
- részletező oldal gomb (ikonos UI)

Funkciók:
- keresés cégnév alapján (query paraméter)
- pagination (újrahasznosítható Twig component)
- Bootstrap table

---

# Vélemény részletező oldal

Minden értékeléshez tartozik egy külön oldal:

- teljes vélemény szöveg
- meta adatok (email, dátumok)
- visszanavigálás a listára

---

# Cégstatisztika (/companies)

Aggregált statisztika oldal cégenként:

- vélemények száma
- átlagos értékelés
- rendezés: átlag szerint csökkenő sorrend

Megvalósítás:
- Doctrine QueryBuilder aggregáció
- külön service (CompanyRatingStatsFetcher)
- paginált megjelenítés
- CSV export funkció (bónusz)

---

# Keresés (bónusz)

- cégnév alapú szűrés query stringből
- pagination-kompatibilis filterezés

---

# Frontend

Bootstrap 5 alapú UI:

- card layout formokhoz
- table layout listához
- flash message alert komponensek
- interaktív star rating (JS + Bootstrap Icons)
- search form

---

# Bónusz funkciók

- interaktív star rating komponens
- CSV export céges adatokból
- kereshető és paginált lista
- reusable pagination Twig component
- tiszta service/repository/fetcher réteg szétválasztás

---

# Inicializáláshoz szükséges parancsok

```bash

# Docker-környezet létrehozása
docker compose up -d --build

# Composer telepítés
docker compose exec php bash composer install

# Adatbázis létrehozása
docker compose exec php bash bin/console doctrine:database:create

# Migrációs fájlok lefuttatása
docker compose exec php bash bin/console doctrine:migrations:migrate

# Adatbázis feltöltése tesztadatokkal
docker compose exec php bash bin/console doctrine:fixtures:load

```
---

# Teszteléshez szükséges parancsok

```bash

# Tesztkörnyezet létrehozása (a tesztadatbázis .env.test-ben van definiálva)
docker compose exec php bash composer test:setup

# Tesztek futtatása
docker compose exec php bash bin/phpunit tests

```

---

# Munkanapló

A fejlesztés 2026. április 27–30. között zajlott.

---

## 📅 04. 27. (hétfő)
- Symfony projekt inicializálása Docker környezetben
- PHP 8.4 + Symfony 8 alap konfiguráció beállítása
- Doctrine ORM és migrációs rendszer előkészítése
- Review entitás létrehozása
- Alap adatbázis struktúra kialakítása

---

## 📅 04. 28. (kedd)
- Review listázó rendszer kialakítása
- Pagination logika implementálása (Fetcher + PaginationFactory)
- Repository réteg kialakítása QueryBuilder alapú lekérdezésekkel
- Twig lista nézet Bootstrap táblázattal
- Review detail (show) oldal elkészítése

---

## 📅 04. 29. (szerda)
- Review beküldő form (Symfony Form + ReviewType)
- Validációs szabályok implementálása
- Flash message rendszer bevezetése
- Interaktív star rating UI (Bootstrap Icons + JavaScript)
- Keresés cégnév alapján (query paraméteres filterezés)
- UI finomhangolás (Bootstrap card/table layout)

---

## 📅 04. 30. (csütörtök)
- Cégstatisztika oldal implementálása (/companies)
- Aggregációs lekérdezések
- CompanyRatingStatsFetcher service kialakítása
- CSV export funkció implementálása
- Reusable pagination Twig komponens kialakítása
- Tesztkörnyezet setup (test:setup Composer script)
- Fixture alapú seedelés integrálása tesztkörnyezetbe
- Integration tesztek készítése (pagination + filter + aggregáció)
- Dokumentáció

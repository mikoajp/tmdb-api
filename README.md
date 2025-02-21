# Laravel TMDB API Project

Ten projekt w języku PHP oparty na frameworku Laravel służy do pobierania danych o filmach i serialach z The Movie Database (TMDB) API i zapisywania ich w lokalnej bazie danych MySQL. Wykorzystuje kolejki (queues) do asynchronicznego przetwarzania danych w różnych językach (angielski, polski, niemiecki).

## Wymagania wstępne

Zanim zaczniesz, upewnij się, że masz zainstalowane następujące narzędzia:

- **PHP** (>= 8.1, zgodnie z najnowszymi wymaganiami Laravela)
- **Composer** (Dependency Manager dla PHP)
- **MySQL** (>= 5.7, z obsługą JSON)
- **Git** (do klonowania repozytorium)
- **Klucz API TMDB** (uzyskaj go na [themoviedb.org](https://www.themoviedb.org/))

---

## Instalacja i konfiguracja

### 1. Sklonuj repozytorium

```bash
git clone git@github.com:mikoajp/tmdb-api.git
cd tmdb-api
```

### 2. Zainstaluj zależności PHP

Użyj Composera, aby zainstalować wszystkie wymagane pakiety:

```bash
composer install
```

### 3. Skonfiguruj plik `.env`

Skopiuj plik konfiguracyjny:

```bash
cp .env.example .env
```

Wygeneruj klucz aplikacji:

```bash
php artisan key:generate
```

Edytuj plik `.env`, aby skonfigurować połączenie z bazą danych i klucz API TMDB:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=tmdb
DB_USERNAME=tmdb_user
DB_PASSWORD=password

TMDB_API_KEY=twój_klucz_api_z_tmdb
```

Wstaw swój klucz API TMDB w `TMDB_API_KEY`.

4. Uruchom bazę danych w Dockerze
```
 docker-compose up -d
```
### 5. Uruchom migracje

```
php artisan migrate
```

---

## Uruchomienie aplikacji

### 1. Uruchom serwer aplikacji Laravel:

```
php artisan serve
```

Aplikacja będzie dostępna pod adresem `http://127.0.0.1:8000`.

### 2. Uruchomienie kolejek:

```
php artisan queue:work

php artisan data:fetch-all   

```

---

## Testowanie API


```
Dostępne endpointy


GET

/movies/{language}

Pobiera listę filmów w określonym języku pl,en,de

GET

/series/{language}

Pobiera listę seriali w określonym języku pl,en,de

GET

/genres

Pobiera dostępne gatunki filmowe
```


---

## Dodatkowe informacje

- Dokumentacja Laravela: [Laravel Docs](https://laravel.com/docs/)
- Dokumentacja TMDB API: [TMDB API Docs](https://developer.themoviedb.org/docs)

---

## Licencja

Projekt dostępny jest na licencji **MIT**.

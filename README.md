## Dane autora 
Dmytro Tus dmytrotus@gmail.com
Senior Full Stack PHP Developer

## How to start the project 

Trzeba klonować sobie projekt lokalnie
```sh
git clone https://github.com/dmytrotus/puzzlup.git
```
Potem wejść do projektu w uruchomić komendę
```sh
docker compose up -d
```
Infrastruktura się uruchomi, a baza danych się utworzy automatycznie.

Potem należy wejśc do kontenera
```sh
docker exec -it puzzlup-lara-php bash
```
skopijować plik .env
```sh
cp .env.example .env
```
Zgenerować klucz
```sh
php artisan key:generate
```
Uruchomić migrację
```sh
php artisan migrate
```
Projekt będzie dostępny z przeglądarki pod adresem
```sh
http://localhost/
```
Endpoint podany w zadaniu to 
```sh
http://localhost/api/temperature
type: POST
headers: Accept: application/json
body: {
    device_id: 'qwerty12345'
    temperature: 10 
    date: '14-02-2024 15:12:34'
}
```

Zeby uruchomić testy trzeba wykonać polecenie
```sh
php artisan test
```
## Queues 

Standardowo w projekcie NIE jest włączone kolejkowanie przy wysyłce e-mail.
Żeby go włączyć nalezy zmienić w pliku .env 

```sh
QUEUE_CONNECTION=sync
```
na linijkę

```sh
QUEUE_CONNECTION=database
```
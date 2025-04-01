# Dockerized_laravel_app
Докеризированное laravel приложение
Инструкция по запуску:
1. клонировать репозиторий в пустую папку с проектом (git clone https://github.com/uropbbro1/Dockerized_laravel_app.git)
2. перейдите в папку проекта (cd Dockerized_laravel_app)
3. Запустите Docker Desktop
4. поднимите контейнеры приложения (docker-compose up --build -d)
5. установить зависимости с помощью сервиса composer (docker-compose run composer install)
6. зайдите в корневую папку laravel (cd src) и скопируйте файл окружения .env.example (cp .env.example .env)
7. В файле .env с 23 строки замените значения на следующие:
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel
DB_PASSWORD=password
8. После этого сгенирируйте ключ для шифрования (docker-compose run artisan key:generate)
9. запустите миграцию (docker-compose run artisan migrate)
10. перейти по адресу http://localhost:8000
После этого уже можно работать с приложением

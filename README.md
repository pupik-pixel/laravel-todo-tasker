# Для разворачивания проекта необходимо:
## Установить composer
### Провести инсталляцию пакетов -> composer install
## Установить node.js
### Провести инсталляцию пакетов -> node install
### Скомпилировать ресурсы приложения -> npm run prod
## Создать файл .env на основе .env.example
### Прописать параметры подключения к бд
### Выполнить миграцию -> php artisan migrate
## Создать символическую ссылку модуля storage -> php artisan storage:link
![screenshot](/screenshot.jpg?raw=true "Screenshot")
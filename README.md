## Установка
- Для установки как библиотека - в уже существующем PHP-проекте выполнить команду:
```
composer require shlappy/drom-test:dev-master
```
- Для установки как проект для разработки:
```
git clone https://github.com/Shlappy/drom-test.git drom-test
```

### Первое задание
Скрипт находится по пути **TotalCount/GetTotalCountFromFiles.php**

1. Клонировать пакет и перейти в него (если ещё не было сделано):
```
git clone https://github.com/Shlappy/drom-test.git drom-test
```

2. Установить зависимости (если ещё не было сделано)
```
composer install
```

3. Поместить желаемое кол-во файлов count и прописать в них любые числа
в папки по пути **TotalCount/files**

4. Для запуска скрипта - выполнить команду из корневой папки:
```
php TotalCount/GetTotalCountFromFiles.php
```
В консоль вернётся сумма всех чисел (по умолчанию возвращается 10)

### Второе задание
Клиент находится по пути **src/Client.php**. Пример использования клиента
находится в файле **src/Example.php**

Для использования клиента в своём проекте:
```
use CommentsClient\Client;
```

Для запуска тестов:
1. Клонировать пакет и перейти в него (если ещё не было сделано):
```
git clone https://github.com/Shlappy/drom-test.git drom-test
```

2. Установить зависимости (если ещё не было сделано)
```
composer install
```

3. Запуск тестов из корневой папки (находятся по пути **tests/**):
```
php vendor/bin/phpunit
```

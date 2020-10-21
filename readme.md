Для запуска нужно выполнить команды

Docker
docker-compose build
docker-compose -up

Скопировать файлы
cp config/api.php.dist config/api.php
cp config/db.php.dist config/db.php
cp config/defaultSetting.php.dist config/defaultSetting.php

Запустить миграцию
php bin/console migrate 

Консольные команды 
php bin/console.php sending - команда берет email из очереди и отправляет
php bin/console.php delayed - команда смотрит в delayed_queue и проверяет статус

Команды добавляются в крон

Скопированные файлы в config нужно заполнить

Пример запроса 
{
    "EmailSubject": "Тестовое письмо",
    "EmailContent": "контент(текст или html шаблон)",
    "EmailSenderName": "Тестовое имя",
    "service": "название сервиса с помощью которого будет отсылаться письмо",
    "Email":""
}
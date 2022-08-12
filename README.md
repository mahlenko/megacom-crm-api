# Установка API на сервере
Клонируйте проект API из репозитория bitbucket, для возможностей обновлять проект или получения его последней версии.

`git clone git@bitbucket.org:mahlenko/api-crm-megacom.git`

Перейдите в каталог проекта и запустите установку зависимостей `composer install`.

Настройте домен API на вашем сервере, настройте apache или nginx на каталог `/public` из проекта.
Или запустите проект через Docker контейнер, если используете Docker на сервере:
`./vendor/bin/sail up -d` или `docker-compose up -d`

## Настройки API и БД 

Перейдите в каталог проекта `cd /full/path/project/...` переименуйте файл `.env.example` в `.env`, командой `mv .env.example .env`.

Отредактируйте файл `.env`.
```dotenv
# Подключение к БД для API
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

# Подключение к БД CRM
EXTERNAL_APP=true
EXTERNAL_APP_DB_CONNECTION=app_mysql
EXTERNAL_APP_DB_HOST=127.0.0.1
EXTERNAL_APP_DB_PORT=3306
EXTERNAL_APP_DB_DATABASE=
EXTERNAL_APP_DB_USERNAME=
EXTERNAL_APP_DB_PASSWORD=
```

Если проект API не требует подключения к внешней БД, а работает как "самостоятельный" проект, укажите это в настройках. После этого при регистрации пользователя не требуется отправлять `external_user_id`. 
```dotenv
EXTERNAL_APP=false
```

## Установка миграций

Запустите команду для установки миграция базы данных (MySQL) из каталога проекта.
`php artisan migrate`

Убедитесь что миграции были выполнены успешно. **Обратите внимание**, при установке миграций проверяется подключение к БД только к проекту API. Подключение к проекту CRM можно проверить выполнив запрос к `/api/{version}/ping/external-db`.

Все готово, можно использовать API для своей CRM.

## Документация по API

Запросы к API отправляются к серверу где он установлен. Для лучшей безопасности, устанавливайте API с SSL сертификатом, чтобы адрес был доступен по `https` протоколу.

**Пример адреса запросов:**
`https://{api_domain}/api/{version}/{api_method}`

- `{version}` - На данный момент API существует в единственной версии `v1`.
- `{api_method}` - Название метода/объекта.

## Стандарт запросов к API
- **GET** - получить информацию по объекту или списку объектов
- **POST** - добавить объект
- **PUT** - обновить объект
- **DELETE** - удалить объект

Установите в заголовке вашего запроса: `Accept: application/json` для всех обращений к API.

Все запросы к API возможны только авторизованным пользователям, кроме методов регистрации `/api/{version}/users` и выдачи токена `/api/{version}/users/token`. 

## Авторизация Bearer Token
Для запросов требующих авторизацию, вы должны прислать в заголовке запроса, ранее полученный токен пользователя:
`Header: Authorization: Bearer <token>`

## Ответы API

Успешный ответ от сервера всегда возвращает `ok: true` или `ok: false` когда произошла внутренняя ошибка API или ошибка запроса.
```json
{
    "ok": true,
    "data": {
        "token": "..."
    },
    "description": null,
    "code": 200
}
```

**Пример успешного ответа** при запросах **списка данных:**
```json
{
    "ok": true,
    "data": [
        
    ],
    "per_page": 50,
    "page": 1,
    "total": 1754,
    "count": 50,
    "description": null,
    "code": 200
}
```

**Пример ответа с ошибкой:**
```json
{
    "ok": false,
    "errors": {
        "email": [
            "Пользователь с таким email уже есть."
        ]
    },
    "description": "The given data was invalid.",
    "code": 422
}
```

- **ok**: статус ответа, по нему можно ориентироваться, успешно или нет прошел ваш запрос.
- **errors**: Список ошибок
- **per_page**: Максимальное количество возвращаемых объектов за 1 запрос
- **page**: Номер страницы
- **total**: Общее количество объектов в БД
- **count**: Количество объектов в `data`
- **description**: Текстовое сообщение об ошибке
- **code**: HTTP код с ошибкой, 200 при успешном запросе.

# Доступные методы
Доступные методы API, можно посмотреть в документации к Collection Postman: https://documenter.getpostman.com/view/7785421/UVC2J9zG

Актуальная версия документации, всегда есть в файле этого репозитория `API Megacom.postman_collection.json` - данный файл вам нужно импортировать в Postman, от туда же можно открыть документацию.
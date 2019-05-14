# Installation

**Requirements:**
* Docker
* Docker-compose (syntax v3)

## Project setup with `make`
```
> git clone git@github.com:grozwalker/contact-book.git
> cd contact-book
> make project-install
```
Visit: http://localhost:8081

### Fronted development work
```
make develop-front
```
Visit: http://localhost:3000

Start server: `make up`

Stop server: `make stop`


### About

Входная точка приложения файл `public/index.php`

Основные "компоненты" - Классы `Container` и `Application`.

`Container` -записываем конфиг и сервис в одно "хранилище" и можем получать оттуда по ключу. 
Одно из преимуществ, что мы не создаем объекты сразу, когда их описываем (когда прописываем мидлверы, БД и т.д.) и плюсом можем автоматически создавать объекты и плюс автоматически внедрять зависимости в конструкторы создаваемых классов.
Сервисы, где нужна какая-то особенная конфигурация прописаны в `config/services.php'

`Application` - отвечает за прохождение реквеста через приложение. 

При инициилизации передаем туда:
* `Resolver` - Класс, который по тому, что передано для обработки (объект, массив, строка) возвращем анонимную ф-цию, куда передается реквест и следующая ф-ция

* `Default` - что будет вызывано, в конце цепочки, если роут ненайден.

* `Pipeline` - отвечает за построение цепочки вложенных вызовов.


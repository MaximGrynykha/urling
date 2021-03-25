[![Urling - url parser & constructor](https://raw.githubusercontent.com/ismaxim/urling/master/assets/hero-image.png "Urling")](https://github.com/ismaxim/urling#installation)

![Build Status](https://img.shields.io/github/workflow/status/ismaxim/urling/Build?label=build&logo=github&logoColor=white&style=for-the-badge)

<!-- <p align="center">
    <img src="https://img.shields.io/github/workflow/status/ismaxim/urling/Build?label=build&logo=github& logoColor=white&style=for-the-badge" alt="Build Status">
    <img src="https://img.shields.io/codecov/c/github/samsonasik/mezzio-authentication-with-authorization?color=codecov&logo=codecov&style=for-the-badge" alt="Tests Coverage">
    <img src="https://img.shields.io/packagist/l/ismaxim/urling?color=1384C4&style=for-the-badge" alt="Packagist License">
    <img src="https://img.shields.io/packagist/v/laravel/laravel?label=version&style=for-the-badge" alt="Packagist Version">
</p> -->

# __Urling__

> 🌐 <a href="https://github.com/ismaxim/urling/blob/master/README.md">Documentation in english →</a> | <a href="https://github.com/ismaxim/urling/blob/master/assets/README-UA.md">Документація на українській →</a>

## ⚙️ Установка

Для того чтобы установить эту библиотеку — запустите в своем терминале следующую комманду:

```shell
composer require ismaxim/urling
```
## 🧙 Использование

### 📖 Концепт

#### Три основные идеи

📗 1. Два режима работы с URL: режим парсера и режим конструктора.  
📘 2. Доступ к конкретной части URL с использование алиасов (см. [ТАБЛИЦА ДОСТУПА](#accessing-table), столбец — [Алиасы](#aliases)).  
📙 3. Базовые редакторы для обработки полного URL и каждой части по отдельности (см. раздел — [Базовое использование](https://github.com/ismaxim/urling#basic-usage)).  

***

### 🚀 Начало

```php
# Режим парсера URL

use Urling\Urling;

$urling = new Urling("https://github.com/ismaxim/urling#начало");

$url_part_values = [
    "protocol_value" => $urling->url->protocol->get(),
    "domain_value"   => $urling->url->domain->get(),
    "routes_value"   => $urling->url->routes->get(),
    "anchor_value"   => $urling->url->anchor->get(),
];

print_r($url_part_values);

/* 
    РЕЗУЛЬТАТ: 

    [
        "protocol_value" => "https",
        "domain_value"   => "github.com",
        "routes_value"   => "ismaxim/urling",
        "anchor_value"   => "начало",
    ] 
*/
```

```php
# Режим конструктора URL

use Urling\Urling;
        
$urling = new Urling();

$urling->url->construct([
    "protocol" => "https",
    "domain"   => "github.com",
    "routes"   => "ismaxim/urling",
    "anchor"   => "начало",
]);

// Либо вы можете установить значение для каждой части URL по отдельности,
// обратившись к ней напрямую, к примеру:

$urling->url->protocol->add("https");
$urling->url->domain->add("github.com");
$urling->url->routes->add("ismaxim/urling");
$urling->url->anchor->add("начало");

print_r($urling->url->get());

/* 
    РЕЗУЛЬТАТ:
    
    "https://github.com/ismaxim/urling#начало"
*/
```

#### 🔑 *__Доступ__*

***

Вы можете обратиться к конкретной части URL для того, чтобы распарсить ее, используя название этой части (см. [ТАБЛИЦА ДОСТУПА](#accessing-table), столбец — [Часть URL](#url-part)) или обратившись к ней с помощью алиаса (см. [ТАБЛИЦА ДОСТУПА](#accessing-table), столбец — [Алиасы](#aliases)) например: 

```php
$urling->url->scheme->... | $urling->url->protocol->... (схожим образом и другие части url).
```
<a id="accessing-table"></a>__ТАБЛИЦА ДОСТУПА__

| <a id="url-part"></a>Часть URL | <a id="aliases"></a>Алиасы  | <a id="parser"></a>Парсер               |
| ------------------------------ | --------------------------- | --------------------------------------- |
| scheme                         | protocol                    | [SchemeParser](https://bit.ly/3vOpzbs)  |
| user                           | username                    | [UserParser](https://bit.ly/2NLCWYQ)    |
| pass                           | password                    | [PassParser](https://bit.ly/3lPdkXG)    |
| host                           | hostname, domain            | [HostParser](https://bit.ly/394KA8c)    |
| port                           |                             | [PortParser](https://bit.ly/39aiMz0)    |
| path                           | routes                      | [PathParser](https://bit.ly/3lEZS8H)    |
| query                          | params, attributes          | [QueryParser](https://bit.ly/3d0VaOu)   |
| fragment                       | anchor                      | [FragmetParser](https://bit.ly/3tKfI4C) |

#### 👶 *__Базовое использование__*

***

По сути, __базовые редакторы__ — [BaseUrlEditor](https://bit.ly/3vXg0qA) и [BasePartEditor](https://bit.ly/3tNXSgZ) охватывают почти все задачи: добавление, получение, обновление или удаление URL или значения в любой его части. __Базовые редакторы__ — это "CRUDable" обертка над функцией __parse_url()__ из нативного PHP и в соответствии с этим фактом, они возвращают и модифицируют значения схожим образом. <ins>Единственное, существенное отличие — это синтаксис обращений при парсинге URL или его частей.

```php
// Работа с URL

$urling->url->add();
$urling->url->get();
$urling->url->update();
$urling->url->delete();

// Работа с одной из частей URL

$urling->url->scheme->add();
$urling->url->scheme->get();
$urling->url->scheme->update();
$urling->url->scheme->delete();

// К примеру, предствим что у нас есть следующий URL - https://github.com/ismaxim/urling#basic-usage
// Тогда пример рабочего процесса распаршивания этого URL для части "схема" или "протокол" (см. ТАБЛИЦА ДОСТУПА, столбец — Алиасы) будет следующим:

$urling->url->scheme->get();          # вернет "https" (состояние URL: https://github.com/ismaxim/urling#basic-usage)
$urling->url->scheme->delete();       # вернет null    (состояние URL: github.com/ismaxim/urling#basic-usage)
$urling->url->scheme->add("ftp");     # вернет "ftp"   (состояние URL: ftp://github.com/ismaxim/urling#basic-usage)
$urling->url->scheme->update("smtp"); # вернет "smtp"  (состояние URL: smtp://github.com/ismaxim/urling#basic-usage)

// Работа с остальными частями URL может быть проведена таким же способом.
```

#### 🧔 *__Расширенное использование__*

***

Если вам нужно сделать что-то вроде: добавления, получения, обновления, или удаления значения любой части URL, но это выходит за рамки базовой функциональности, вы можете использовать одну из функций __базовых редакторов__: add, get, update или delete, как префикс, с именем конкретной функции подходящей для вашей задачи, как постфикса. Например:

> (add, get, update, delete) + "НекоеНазваниеФункции" для конкретной задачи.

Примечание: *Почти все функции будут использовать это соглашение по коду на постоянной основе.*

Примеры:  
- getValueByName();
- getNameValuePairs();
- и другие...

```php
$urling->url->params->getValueByName();
$urling->url->params->getNameValuePairs();
```

## 🧪 Тестирование

_На самом деле, все тесты уже автоматически прошли проверку в CI сборке._

Для того чтобы протестировать эту библиотеку — запустите в своем терминале следующую комманду:

```shell
composer test
```

## 🤝 Содействие

Если у вас есть задача, которая не может быть решена с помощью данной библиотеки, пожалуйста, напишите свое решение и если вы хотите помочь другим разработчикам которые также используют эту библиотеку (или, если хотите сохранить свое решение рабочим после выхода новой версии, которая поступит в зависимости пакетного менеджера) - создайте pull-request. Мы будем щасливы добавить ваш превосходный код в библиотеку!

🐞 Сообщить о любом баге или проблеме вы можете с помощью [GitHub issues](https://github.com/ismaxim/urling/issues).

### ✨ Создание собственного функционала

Вы можете расширить функциональность библиотеки своим кодом, создав в классах-парсеров, правки для решения ваших задач. Существуют два типа классов парсеров: первый и главный — [парсер URL](https://github.com/ismaxim/urling/blob/master/src/Urling/Core/Url.php), но также есть другие, — [парсеры частей URL](https://github.com/ismaxim/urling/tree/master/src/Urling/PartParsers). Для каждой части, есть свой отдельный класс парсер.

Используя эту библиотеку, или изучая документацию вы могли заметить такую же, или схожую с этой запись:

```php
$urling->url->params->get() 
```

Эта запись может быть интерпретирована таким образом: "Эй, Urling, обратись к части 'параметры' у текущего URL и верни значение этой части".

В основном раширяя функциональность, вы будуте работать с частью URL'а практически все время и будете обрабатывать, или получать значение конкретной части. Для понимая того, как доступиться к парсеру нужной части, вы можете заглянуть в [ТАБЛИЦУ ДОСТУПА](#accessing-table). Вам лишь нужно сопоставить значения из столбцов: [*__url part__*](#url-part) и [*__aliases__*](#aliases), со значением из столбца [*__parser__*](#parser) и тогда вы сможете перейти к желаемому файлу-парсера и написать лучший на в мире код!

## 📎 Список участников
- [Ведущий разработчик →](https://github.com/ismaxim)
- [Участники вносящие свой вклад →](https://github.com/ismaxim/urling/contributors)

## 📃 Лицензия

Лицензия — MIT License (MIT). Для получения дополнительной информации, пожалуйста, взгляните на [файл лицензии](LICENSE.md).

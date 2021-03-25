[![Urling - url parser & constructor](https://raw.githubusercontent.com/ismaxim/urling/master/assets/hero-image.png "Urling")](https://github.com/ismaxim/urling#installation)

<p align="center">
    <img src="https://img.shields.io/github/workflow/status/ismaxim/urling/Build?label=build&logo=github& logoColor=white&style=for-the-badge" alt="Build Status">
    <img src="https://img.shields.io/codecov/c/github/samsonasik/mezzio-authentication-with-authorization?color=codecov&logo=codecov&style=for-the-badge" alt="Tests Coverage">
    <img src="https://img.shields.io/packagist/l/ismaxim/urling?color=1384C4&style=for-the-badge" alt="Packagist License">
    <img src="https://img.shields.io/packagist/v/laravel/laravel?label=version&style=for-the-badge" alt="Packagist Version">
</p>

# __Urling__

> 🌐 <a href="https://github.com/ismaxim/urling/blob/master/README.md">Documentation in english →</a> | <a href="https://github.com/ismaxim/urling/blob/master/assets/README-RU.md">Документация на русском →</a>

## ⚙️ Встановлення

Для того щоб встановити цю бібліотеку — запустіть у своему терміналі наступну команду:

```shell
composer require ismaxim/urling
```
## 🧙 Використання

### 📖 Концепт

#### Три основні ідеї

📗 1. Два режими роботи із URL: режим парсера та режим конструктора.  
📘 2. Доступ до конкретної частини URL із використанням аліасів (див. [ТАБЛИЦЮ ДОСТУПУ](#accessing-table), стовпець — [Аліаси](#aliases)).  
📙 3. Базові редактори для обробки повного URL, та кожної частини окремо (див. розділ — [Базове використання](https://github.com/ismaxim/urling#базове-використання)).  

***

### 🚀 Початок

```php
# Режим парсера URL

use Urling\Urling;

$urling = new Urling("https://github.com/ismaxim/urling#початок");

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
        "anchor_value"   => "початок",
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
    "anchor"   => "початок",
]);

// Або ви можете встановити значення для кожної частини URL окремо, 
// звернувшись до неї безпосередньо, до прикладу:

$urling->url->protocol->add("https");
$urling->url->domain->add("github.com");
$urling->url->routes->add("ismaxim/urling");
$urling->url->anchor->add("початок");

print_r($urling->url->get());

/* 
    РЕЗУЛЬТАТ:
    
    "https://github.com/ismaxim/urling#початок"
*/
```

#### 🔑 *__Доступ__*

***

Ви можете звернутися до конкретної частини URL для того, щоб розпарсити її, використовуючи назву цієї частини (див. [ТАБЛИЦЮ ДОСТУПУ](#accessing-table), стовпець — [Частина URL](#url-part)) або звернувшись до неї за допомогою аліасу (див. [ТАБЛИЦЮ ДОСТУПУ](#accessing-table), стовпець — [Аліаси](#aliases)), наприклад: 

```php
$urling->url->scheme->... | $urling->url->protocol->... (схожим чином і інші частини url).
```
<a id="accessing-table"></a>__ТАБЛИЦЯ ДОСТУПУ__

| <a id="url-part"></a>Частина URL | <a id="aliases"></a>Аліаси  | <a id="parser"></a>Парсер               |
| -------------------------------- | --------------------------- | --------------------------------------- |
| scheme                           | protocol                    | [SchemeParser](https://bit.ly/3vOpzbs)  |
| user                             | username                    | [UserParser](https://bit.ly/2NLCWYQ)    |
| pass                             | password                    | [PassParser](https://bit.ly/3lPdkXG)    |
| host                             | hostname, domain            | [HostParser](https://bit.ly/394KA8c)    |
| port                             |                             | [PortParser](https://bit.ly/39aiMz0)    |
| path                             | routes                      | [PathParser](https://bit.ly/3lEZS8H)    |
| query                            | params, attributes          | [QueryParser](https://bit.ly/3d0VaOu)   |
| fragment                         | anchor                      | [FragmetParser](https://bit.ly/3tKfI4C) |

#### 👶 *__Базове використання__*

***

По суті __базові редактори__ — <ins>[BaseUrlEditor](https://bit.ly/3vXg0qA) и [BasePartEditor](https://bit.ly/3tNXSgZ),
охоплюють майже усы задачі: додавання, отримання, оновлення або видалення URL, чи значення у будь якій його частині.</ins>   
<ins>__Базові редактори__ — це "CRUDable" огортка над функцією __parse_url()__ з нативного PHP</ins> та відповідно із цим фактом, вони повертають та модифікують значення схожим чином.  
<ins>Єдина, істотна відмінність — це синтаксис звернень при парсингу URL або його частин.</ins> 

```php
// Робота з URL

$urling->url->add();
$urling->url->get();
$urling->url->update();
$urling->url->delete();

// Робота з однією із частин URL

$urling->url->scheme->add();
$urling->url->scheme->get();
$urling->url->scheme->update();
$urling->url->scheme->delete();

// До прикладу, уявімо, що в нас є наступний URL - https://github.com/ismaxim/urling#базове-використання
// Тоді приклад робочого процесу розпаршування цього URL в частини "схема" або "протокол" (див. ТАБЛИЦЮ ДОСТУПУ, стовпець — Аліаси) буде наступним:

$urling->url->scheme->get();          # поверне "https" (стан URL: https://github.com/ismaxim/urling#базове-використання)
$urling->url->scheme->delete();       # поверне null    (стан URL: github.com/ismaxim/urling#базове-використання)
$urling->url->scheme->add("ftp");     # поверне "ftp"   (стан URL: ftp://github.com/ismaxim/urling#базове-використання)
$urling->url->scheme->update("smtp"); # поверне "smtp"  (стан URL: smtp://github.com/ismaxim/urling#базове-використання)

// Робота з іншими частинами URL може бути проведена у такий же спосіб.
```

#### 🧔 *__Розширене використання__*

***

Якщо вам потрібно зробити щось на зразок: дадавання, отримання, оновлення або видалення значення в будь якій
частині URL, але це виходить за рамки базової функціональності,  
ви можете використати одну з функцій
__базових редакторів__: add, get, update або delete, як префікс, з назвою конкретної функції підходящої для вашої задачі, як префікса. Наприклад:

> (add, get, update, delete) + "ДеякаНазваФункції" для конкретної задачі.

Примітка: *Майже всі функції будуть використовувати цю угоду за кодом на постійній основі.*

Приклади:  
- getValueByName();
- getNameValuePairs();
- тощо...

```php
$urling->url->params->getValueByName();
$urling->url->params->getNameValuePairs();
```

## 🧪 Тестування

_На справді, усі тести вже автоматично пройшли перевірку у CI збірці._

Для того щоб протестувати цю бібліотеку — запустіть у своєму терміналі наступну команду:

```shell
composer test
```

## 🤝 Cприяння

Якщо у вас є завдання, що не може бути вирішене за допомогою данної бібліотеки, будь ласка,
напишить своє рішення, та якщо ви бажаете допомогти іншим розробникам, котрі також використовують
цю бібліотеку (або, якщо бажаете зберегти свое рішення працюючим після виходу нової версії,
котра надійде до залежностей пакетного менеджера) - створіть pull-request.  
Ми будемо щасливі додати ваш чудовий код у бібліотеку!

🐞 Повідомити про будь-який баг чи проблему ви можете за допомогою [GitHub issues](https://github.com/ismaxim/urling/issues).

### ✨ Створення власного функціоналу

Ви можете розширити функціональність бібліотеки власним кодом, створивши у класах-парсерів правки для вирішення ваших задач.  
Їснують два типи класів-парсерів: перший і головний — [парсер URL](https://github.com/ismaxim/urling/blob/master/src/Urling/Core/Url.php), але також є інші, — [парсери частин URL](https://github.com/ismaxim/urling/tree/master/src/Urling/PartParsers).  
Для кожної частини, є свій окремий клас-парсер.

Використовуючи цю бібліотеку, або досліджуючи документацію, ви могли помітити такий же, або схожий із цим запис:

```php
$urling->url->params->get()
```

Цей запис може були інтерпритований таким чином: "Гей, Urling, звернися до частини 'параметри' у поточного URL та поверни значення цієї частини".

В основому розширючи функціональність, ви будете працювати із частиною URL, практично увесь час та будете
, чи отримувати значення конкретної частини. Для розуміння того, як доступитися до парсера потрібної частини, ви можете заглянути у [ТАБЛИЦЮ ДОСТУПУ](#accessing-table).
Вам лише потрібно співставити значення зі стовпців: [*__частина url__*](#url-part) та [*__аліаси__*](#aliases), зі значенням стовпця [*__парсер__*](#parser), тоді, ви зможете перейти до бажаного файлу-парсеру та написати найкращий у світі код!

## 📎 Список учасників
- [Ведучий розробник →](https://github.com/ismaxim)
- [Учасники, що вносять свій вклад →](https://github.com/ismaxim/urling/contributors)

## 📃 Ліцензія

Ліцензія — MIT License (MIT). Для отримання додаткової інформації, будь ласка, погляньте на [файл ліцензії](LICENSE.md).

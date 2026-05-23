# Инструкция по запуску Лабораторной работы (AJAX + Fetch API)

**Выполнил:** студент группы Гунько Іван Дмитрович  
**Варіант:** №5 (Товари в інтернет-магазині)

Чтобы всё работало корректно, выполни эти 5 простых шагов.

---

### Шаг 1. Размещение файлов
Распакуй папку с проектом в директорию твоего локального веб-севера (OpenServer). 
* Если у тебя старая версия OpenServer (5.x), это папка `OSPanel\domains`.
* Если новая (6.0), это папка `OSPanel\home`.

<img width="757" height="522" alt="image" src="https://github.com/user-attachments/assets/c4237131-f4f9-4e9f-aa70-35c90068e471" />

* Здесь не забудь создать папку `custintdb.local`, это обязательно, и закинь туда все наши файлы (`index.php`, `vendor_items.php`, `category_items.php`, `price_items.php`, `db.php`, `.osp/project.ini`):

<img width="1173" height="432" alt="image" src="https://github.com/user-attachments/assets/b8293860-83b0-441e-b686-a0f6ee29cfaf" />


### Шаг 2. Загрузка базы данных (ОБЯЗАТЕЛЬНО)
Проект не будет работать без базы данных.
1. Запусти OpenServer и открой **phpMyAdmin**.

<img width="568" height="434" alt="image" src="https://github.com/user-attachments/assets/3f0adaac-645a-46ee-a20d-9f191c5a8d8b" />

<img width="1909" height="523" alt="image" src="https://github.com/user-attachments/assets/4a911c5a-6640-4f14-b325-2155e5d86545" />

3. Перейди во вкладку **Импорт** (Import) в верхнем меню.

<img width="1919" height="557" alt="Знімок екрана 2026-05-23 125036" src="https://github.com/user-attachments/assets/a3c58531-8829-42ce-8d21-760946322ac1" />

4. Выбери файл базы данных интернет-магазина `lb_pdo_goods.sql` (он лежит в папке с проектом) и нажми **Import**.
База данных `lb_pdo_goods` и все таблицы с товарами, категориями и производителями создадутся автоматически.

<img width="1624" height="771" alt="image" src="https://github.com/user-attachments/assets/4848d2e3-b9e0-4a3e-9eab-83b3efd0e76c" />


### Шаг 3. Настройка подключения (db.php)
**Важный момент!** Настройки базы зависят от твоей версии OpenServer. 
Открой файл `db.php` в любом редакторе. Сейчас там стоят настройки для OpenServer 6.0 и твоей базы `lb_pdo_goods`:
* `$host = 'MySQL-8.4';`
* `$db   = 'lb_pdo_goods';`
* `$pass = '';`

**Если у тебя старая версия OpenServer (или XAMPP), измени эти строки на стандартные:**
* `$host = 'localhost';`
* `$pass = 'root';` (или оставь пустым `''`, если пароля на root нет).


### Шаг 4. Запуск
Запусти проект (или перезапусти OpenServer, чтобы он увидел новую папку). Открой браузер и перейди по локальному адресу проекта: `http://custintdb.local`.

Также просмотри, чтобы в настройках OpenServer у тебя стояли эти версии PHP и MySQL:

<img width="419" height="174" alt="image" src="https://github.com/user-attachments/assets/e6fa492f-2214-459c-b6b7-9c1c1157d72d" />

<img width="468" height="151" alt="image" src="https://github.com/user-attachments/assets/499aa6a8-d1d0-4118-bae3-c0927a42d8bb" />


### Шаг 5. Проверка приложения и AJAX-технологий
Пройдись по всем трем запросам. Главная фишка этой лабораторной — **страница не перезагружается при отправке форм**, а данные мгновенно подгружаются в блок результатов:

1. **Поиск товаров по производителю (Формат TEXT):** Запрос отправляется через `XMLHttpRequest`, сервер возвращает готовый HTML-список товаров.
<img width="441" height="183" alt="image" src="https://github.com/user-attachments/assets/5b063b1b-87c3-4f2c-bebd-ee086b4ed4b9" />

2. **Поиск товаров по категории (Формат XML):** Запрос идет через `XMLHttpRequest`, сервер возвращает структурированный XML-документ, который JavaScript парсит на стороне клиента и выводит на экран.
<img width="463" height="193" alt="image" src="https://github.com/user-attachments/assets/f8c42dde-655e-4def-82f3-c0cebb22e656" />

3. **Фильтрация по цене (Формат JSON + Fetch API):** Используется современный метод `fetch()`. Сервер возвращает JSON-строку, которая десериализуется в JS-массив объектов для вывода товаров в выбранном диапазоне цен.
<img width="556" height="259" alt="image" src="https://github.com/user-attachments/assets/8ac9fc87-d37e-4f00-b0b7-eff0e1fb558c" />

---

### 🛠 Частые ошибки:
* **Списки пустые или не загружаются:** Ты забыл импортировать файл `lb_pdo_goods.sql` в phpMyAdmin, либо очисти кэш браузера (Ctrl + F5).
* **Ошибка "target machine actively refused it" (SQLSTATE 2002):** Сервер не может найти базу. Проверь, правильно ли указан сервер `$host` и порт/пароль в файле `db.php` для твоей текущей версии OpenServer.

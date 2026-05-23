# Инструкция по запуску Лабораторной работы (AJAX + Fetch API)

Чтобы всё работало корректно, выполни эти 5 простых шагов.

---

### Шаг 1. Размещение файлов
Распакуй папку с проектом в директорию твоего локального веб-севера (OpenServer). 
* Если у тебя старая версия OpenServer (5.x), это папка `OSPanel\domains`.
* Если новая (6.0), это папка `OSPanel\home`.

<img width="1173" height="463" alt="image" src="https://github.com/user-attachments/assets/7e582dee-4c3f-4334-a3aa-2c83443e2e19" />


* Здесь не забудь создать папку `custintdb.local`, это обязательно, и закинь туда все наши файлы (`index.php`, `vendor_items.php`, `category_items.php`, `price_items.php`, `db.php`, `.osp/project.ini`):

На всякий, если что-то сделаешь с файлом project.ini:
<img width="1274" height="372" alt="image" src="https://github.com/user-attachments/assets/d783ce61-4443-43cf-92bd-60db1ba58e8f" />


### Шаг 2. Загрузка базы данных (ОБЯЗАТЕЛЬНО)
Проект не будет работать без базы данных.
1. Запусти OpenServer и открой **phpMyAdmin**.

<img width="568" height="434" alt="image" src="https://github.com/user-attachments/assets/3f0adaac-645a-46ee-a20d-9f191c5a8d8b" />

<img width="1909" height="523" alt="image" src="https://github.com/user-attachments/assets/4a911c5a-6640-4f14-b325-2155e5d86545" />

3. Перейди во вкладку **Импорт** (Import) в верхнем меню.

<img width="1919" height="557" alt="Знімок екрана 2026-05-23 125036" src="https://github.com/user-attachments/assets/a3c58531-8829-42ce-8d21-760946322ac1" />

4. Выбери файл базы данных интернет-магазина `lb_pdo_goods.sql` (он лежит в папке с проектом) и нажми **Import**.
База данных `lb_pdo_goods` и все таблицы с товарами, категориями и производителями создадутся автоматически.

<img width="1112" height="432" alt="image" src="https://github.com/user-attachments/assets/1329cc81-5b62-406d-9369-bcc0e7f08478" />



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

<img width="565" height="263" alt="image" src="https://github.com/user-attachments/assets/444320cd-6826-4e2e-a674-cc8fa43337dc" />


Также просмотри, чтобы в настройках OpenServer у тебя стояли эти версии PHP и MySQL:

<img width="419" height="174" alt="image" src="https://github.com/user-attachments/assets/e6fa492f-2214-459c-b6b7-9c1c1157d72d" />

<img width="468" height="151" alt="image" src="https://github.com/user-attachments/assets/499aa6a8-d1d0-4118-bae3-c0927a42d8bb" />


### Шаг 5. Проверка приложения и AJAX-технологий
Пройдись по всем трем запросам. Главная фишка этой лабораторной — **страница не перезагружается при отправке форм**, а данные мгновенно подгружаются в блок результатов:

1. **Поиск товаров по производителю (Формат TEXT):** Запрос отправляется через `XMLHttpRequest`, сервер возвращает готовый HTML-список товаров.
<img width="887" height="617" alt="image" src="https://github.com/user-attachments/assets/6400d807-4d61-429a-a97a-f185ac4eb747" />

<img width="796" height="554" alt="image" src="https://github.com/user-attachments/assets/1a704066-9706-4f34-bb25-a6b8d68a0be1" />

2. **Поиск товаров по категории (Формат XML):** Запрос идет через `XMLHttpRequest`, сервер возвращает структурированный XML-документ, который JavaScript парсит на стороне клиента и выводит на экран.

<img width="783" height="570" alt="image" src="https://github.com/user-attachments/assets/35c2dd79-9dc0-4273-b469-2be5650eab47" />

<img width="723" height="645" alt="image" src="https://github.com/user-attachments/assets/602a4dbe-57de-4488-b9a4-644e6d525b61" />


3. **Фильтрация по цене (Формат JSON + Fetch API):** Используется современный метод `fetch()`. Сервер возвращает JSON-строку, которая десериализуется в JS-массив объектов для вывода товаров в выбранном диапазоне цен.
<img width="771" height="649" alt="image" src="https://github.com/user-attachments/assets/32a20027-67a9-4acd-b10e-7fd76ed88679" />

---

### 🛠 Частые ошибки:
* **Списки пустые или не загружаются:** Ты забыл импортировать файл `lb_pdo_goods.sql` в phpMyAdmin, либо очисти кэш браузера (Ctrl + F5).
* **Ошибка "target machine actively refused it" (SQLSTATE 2002):** Сервер не может найти базу. Проверь, правильно ли указан сервер `$host` и порт/пароль в файле `db.php` для твоей текущей версии OpenServer.
